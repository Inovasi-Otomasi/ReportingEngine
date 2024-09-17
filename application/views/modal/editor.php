<?php

$sheet = json_decode($editor->sheets,true);
function generateAlphabetArray() {
    $alphabetArray = [];

    // Generate single letters A-Z
    foreach (range('A', 'Z') as $letter) {
        $alphabetArray[] = $letter;
    }

    // Generate double letters AA-AZ
    foreach (range('A', 'Z') as $first) {
        foreach (range('A', 'Z') as $second) {
            $alphabetArray[] = $first . $second;
        }
    }

    return $alphabetArray;
}

$alpha = generateAlphabetArray()

?>
<div class="d-flex flex-column" style="height:100%; gap:10px">
    <h5 id="report-name" report-id="<?=$editor->id?>"><?= $editor->name ?></h5>
    
    <div class="border p-2 mt-2">
        <div class="d-flex" style="gap:10px">
            <?php $ind = 0; foreach($sheet as $sht):?>
            <button class="btn rounded-pill text-white sheet-tab px-5 <?php if($ind == 0) echo "btn-info"; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#sheet-<?=$ind?>" aria-expanded="false" aria-controls="sheet-<?=$ind?>">
                <?= $sht ?>
            </button>
            <?php $ind++; endforeach ?>
        </div>
    </div>
    <div class="border" style="overflow:scroll; flex-grow:4;" id="sheetgroup">
        <?php $ind = 0; foreach($sheet as $sht):?>
        <div class="accordion-item">
            <div id="sheet-<?=$ind?>" class="accordion-collapse <?php if($ind == 0) echo "show"; ?> collapse" data-bs-parent="#sheetgroup" style="">
                <div class="accordion-body">
                    <?php for ($i=1; $i <= 25; $i++) :?>
                    <div class="d-flex" style="">
                        <?php 
                            for ($a=0; $a < 26; $a++): 
                                $arr_id = "";
                                $direction = "";
                                $limit = "";
                                $offset = "";
                                $class = "";
                                $ittid = "";
                                foreach($itterate as $itt){
                                    if(($itt->sheet == $ind)&&($itt->col == $alpha[$a])&&($itt->row == $i)){
                                        $arr_id = $itt->array_id;
                                        $direction = $itt->direction;
                                        $class = ($itt->direction == 1) ? 'horizontal' : (($itt->direction == 2) ? 'vertical' : '');
                                        $limit = ($itt->limit == 0) ? '' : $itt->limit;
                                        $offset = ($itt->offset == 0) ? '' : $itt->offset;
                                        $ittid = ($itt->id == 0) ? '' : $itt->id;
                                    }
                                }

                                $class .= " ". $ind . "-". $alpha[$a] . "-" . $i
                        ?>
                        <button 
                            style="flex: 0 0 200px; border-radius:0; height:31px" 
                            class="btn border cell d-flex justify-content-between <?= $class ?>"
                            role="button"
                            data-bs-toggle="popover"
                            data-bs-trigger="click"
                            data-bs-container="body"
                            data-bs-html="true"
                            title="as"
                            cell-row="<?= $i ?>"
                            cell-col="<?= $alpha[$a] ?>"
                            cell-array="<?= $arr_id ?>"
                            cell-direction="<?= $direction ?>"
                            cell-limit="<?= $limit ?>"
                            cell-offset="<?= $offset ?>"
                            cell-sheet="<?= $ind ?>"
                            itt-id="<?= $ittid ?>"
                            data-bs-content="as">
                            <span style="font-size:9px; color:cyan"><?= $alpha[$a].$i ?></span>
                            <div>
                                <span class="badge text-bg-info px-3 py-1 aro down d-none text-white">
                                    <i class="fa-solid fa-arrow-down fa-xs"></i>
                                </span>
                                <span class="badge text-bg-primary px-3 py-1 aro right d-none text-white">
                                    <i class="fa-solid fa-arrow-right fa-xs"></i>
                                </span>
                            </div>
                        </button>
                        <?php endfor ?>
                    </div>
                    <?php endfor ?>
                </div>
            </div>
        </div>
        <?php $ind++; endforeach ?>
    </div>
</div>

<script>
    if (!window.hasOwnProperty( "poppy" )) {
        let poppy = null
        $(".cell").popover({
            sanitize: false,
            title: "editor",
            content: "s"
        }).on('click', function(){
            if(poppy != null) {
                poppy.hide()
            }
            let data = bootstrap.Popover.getInstance(this)
            //preparing data set
            let row = $(this).attr('cell-row');
            let col = $(this).attr('cell-col');
            let sheet = $(this).attr('cell-sheet');
            let report_id = $("#report-name").attr('report-id');

            let array = $(this).attr('cell-array');
            let direction = $(this).attr('cell-direction');
            let limit = $(this).attr('cell-limit');
            let offset = $(this).attr('cell-offset');
            let ittid = $(this).attr('itt-id');
            
            $(".form-report-id").val(report_id);
            $(".form-report-sheet").val(sheet);
            $(".form-report-limit").attr('value',limit);
            $(".form-report-offset").attr('value',offset);
            $(".form-report-row").val(row);
            $(".form-report-col").val(col);

            $(".direction-selector option").each(function(){
                $(this).attr('selected', false)
                if($(this).attr('value') == direction){
                    $(this).attr('selected', true)
                }
            })

            $(".array-selector option").each(function(){
                $(this).attr('selected', false)
                if($(this).attr('value') == array){
                    $(this).attr('selected', true)
                }
            })

            // get styling
            
            if(ittid != ""){
                $.get("<?= base_url('index.php/process/style/') ?>"+ittid, function(datas) {
                    applyStyle(JSON.parse(datas))
                    console.log(JSON.parse(datas))
                    data.setContent({
                        '.popover-header': 'Cell ' + col + row,
                        '.popover-body': $('#dummy').html()
                    })
                    poppy = data;
                });
            } else {
                let style = {"font-size":"12","color":"","bold":"","underline":"","italic":"","strikethrough":"","horizontal":"","vertical":"","top":"","bottom":"","right":"","left":"","cell":""}
                applyStyle(style)
                data.setContent({
                    '.popover-header': 'Cell ' + col + row,
                    '.popover-body': $('#dummy').html()
                })
                poppy = data;
            }

        })
        $(document).on('click', ".close-form", function(e){
            let pop = $(e.target).closest(".popover")
            pop.hide()
        })
        $(document).on('click', ".save-form", function(e){
            let form = $(e.target).closest("form")[0]
            let pop = $(e.target).closest(".popover")
            e.preventDefault();
            let formData = new FormData(form); // Create FormData object from the form
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: formData,
                contentType: false, // Prevent jQuery from automatically setting the Content-Type header
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                success: function(res) {
                    if (res != 'done') {
                        console.log(res);
                    } else {
                        let sheet = $(form).find('.form-report-sheet').val()
                        let row = $(form).find('.form-report-row').val()
                        let col = $(form).find('.form-report-col').val()
                        
                        let limit = $(form).find('.form-report-limit').val()
                        let offset = $(form).find('.form-report-offset').val()
                        let direction = $(form).find('.direction-selector').find(":selected").val()
                        let array = $(form).find('.array-selector').find(":selected").val()
                        
                        let clas = "." + sheet + "-" + col + "-" + row
                        let cell = $(clas)

                        cell.attr('cell-array', array);
                        cell.attr('cell-direction', direction);
                        cell.attr('cell-limit', limit);
                        cell.attr('cell-offset', offset);
                        cell.removeClass("horizontal")
                        cell.removeClass("vertical")
                        if(direction == "1"){
                            cell.addClass("horizontal")
                        } else if( direction == "2") {
                            cell.addClass("vertical")
                        }
                        pop.hide()
                    }
                }
            });
        })

        $(".sheet-tab").click(function(){
            $(".sheet-tab").removeClass('btn-info')
            $(this).addClass('btn-info')
        })

        function applyStyle(style){
            if(style.top == "true"){
                $("#dummy").find("[borders='top']").addClass('btn-secondary')
                $("#dummy").find("[borders='top']").removeClass('btn-outline-secondary')
            } else {
                $("#dummy").find("[borders='top']").addClass('btn-outline-secondary')
                $("#dummy").find("[borders='top']").removeClass('btn-secondary')
            }
            if(style.bottom == "true"){
                $("#dummy").find("[borders='bottom']").addClass('btn-secondary')
                $("#dummy").find("[borders='bottom']").removeClass('btn-outline-secondary')
            } else {
                $("#dummy").find("[borders='bottom']").addClass('btn-outline-secondary')
                $("#dummy").find("[borders='bottom']").removeClass('btn-secondary')
            }
            if(style.left == "true"){
                $("#dummy").find("[borders='left']").addClass('btn-secondary')
                $("#dummy").find("[borders='left']").removeClass('btn-outline-secondary')
            } else {
                $("#dummy").find("[borders='left']").addClass('btn-outline-secondary')
                $("#dummy").find("[borders='left']").removeClass('btn-secondary')
            }
            if(style.right == "true"){
                $("#dummy").find("[borders='right']").addClass('btn-secondary')
                $("#dummy").find("[borders='right']").removeClass('btn-outline-secondary')
            } else {
                $("#dummy").find("[borders='right']").addClass('btn-outline-secondary')
                $("#dummy").find("[borders='right']").removeClass('btn-secondary')
            }

            if(style.bold == "true"){
                $("#dummy").find("[style-type='bold']").addClass('active')
            } else {
                $("#dummy").find("[style-type='bold']").removeClass('active')
            }

            if(style.underline == "true"){
                $("#dummy").find("[style-type='underline']").addClass('active')
            } else {
                $("#dummy").find("[style-type='underline']").removeClass('active')
            }

            if(style.italic == "true"){
                $("#dummy").find("[style-type='italic']").addClass('active')
            } else {
                $("#dummy").find("[style-type='italic']").removeClass('active')
            }

            if(style.strikethrough == "true"){
                $("#dummy").find("[style-type='strikethrough']").addClass('active')
            } else {
                $("#dummy").find("[style-type='strikethrough']").removeClass('active')
            }
            
            $("#dummy").find("[style-color]").each(function(){
                if($(this).attr('style-color') == style.color){
                    let color = $(this).css("background-color")
                    $(this).closest('.collapser').find('.btn-collapser').css("background-color", color)
                }
            })

            $("#dummy").find("[style-cell]").each(function(){
                if($(this).attr('style-cell') == style.cell){
                    let color = $(this).css("background-color")
                    $(this).closest('.collapser').find('.btn-collapser').css("background-color", color)
                }
            })

            $("#dummy").find("[vertical-align]").each(function(){
                if($(this).attr('vertical-align') == style.vertical){
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            })

            $("#dummy").find("[horizontal-align]").each(function(){
                if($(this).attr('horizontal-align') == style.horizontal){
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            })
            
            $("[name='style[font-size]']").attr('value',style['font-size'])
            Object.keys(style).forEach(function(o){
                $("[name='style["+o+"]']").val(style[o]);
            })
        }
    }

</script>