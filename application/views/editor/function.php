<div class="mt-3">
    <div class="alert not-array alert-danger p-2" role="alert">
        Make sure the function return array!
    </div>
    <ul style="font-size:small" class="list-group result-view">
    </ul>
</div>

<script>
    function dynamicFunction(query){
        <?= $function ?>
    }
    returned = dynamicFunction(queryResult);
    if(Number.isInteger(returned.length)){
        $(".not-array").addClass("d-none")
        $(".result-view").removeClass("d-none")
        $(".result-view").html("")
        for (let i = 0; i < 10; i++) {
            let element = returned[i];
            let printed = ""
            if(typeof element == "object"){
                printed = JSON.stringify(element);
                $(".result-view").append(`<li style="overflow:hidden" class="p-1 list-group-item">${printed}</li>`)
            } else if(typeof element == "undefined") {
                printed = " "
            } else {
                printed = element
                $(".result-view").append(`<li style="overflow:hidden" class="p-1 list-group-item">${printed}</li>`)
            }

        }
        if(returned.length > 10){
            $(".result-view").append(`<li style="overflow:hidden" class="p-1 list-group-item">...</li>`)
            let element = returned[returned.length-1];
            let printed = ""
            if(typeof element == "object"){
                printed = JSON.stringify(element);
            } else if(typeof element == "undefined") {
                printed = " "
            } else {
                printed = element
            }
            $(".result-view").append(`<li style="overflow:hidden" class="p-1 list-group-item">${printed}</li>`)
        }
        
        console.log('array');
    } else {
        $(".not-array").removeClass("d-none")
        $(".result-view").html("")
        $(".result-view").addClass("d-none")
        console.log('not array');
    }
</script>