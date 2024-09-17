<form action="<?= base_url('index.php/process/insert/array') ?>" method="post">
  <h5 class="text-info"><i class="fa-solid fa-folder-plus fa-lg"></i> Array Builder</h5>
  <hr>
  <div class="mb-1">
    <label for="companyname"  class="form-text">Name</label>
    <input type="text" required name="name" class="form-control" id="companyname" placeholder="Example Company LTD">
  </div>
  <div class="mb-1">
    <label for="query"  class="form-text">Queries</label>
    <select class="selectize" aria-label="Default select example" id="line_name" placeholder="Pick a line..." multiple>
      <option value="">Select a line...</option>
      <?php foreach($query as $que): ?>
      <option value="<?= $que->id ?>" ><?= $que->name ?></option>
      <?php endforeach ?>
    </select>
    <input type="hidden" class="queryID" name="query" value="">
  </div>

  <div class="mb-1">
    <label for="get" class="form-text">Pass Variable</label>
    <div class="input-group">
      <small class="input-group-text" id="basic-addon3"><em>http://URL/endpoint?</em></small>
      <input type="text" name="get" class="form-control" id="get" placeholder="key1=value&key2=value4" aria-describedby="basic-addon3 basic-addon4">
    </div>
  </div>


  <label class="form-text">Array</label>
  <div class="position-relative" style="width:100%; height:200px">
    <div id="editor" class="editor">console.log(query)</div>
  </div>
  <a class="testArray btn btn-outline-info btn-sm mt-4 rounded-pill" style="width:100%" href="javascript:void(0)">Test Query</a>
  <div class="array-result"></div>


  <textarea name="code" id="query-field" class="d-none"></textarea>


  <div class="accordion-collapse collapse alerting mt-2" data-bs-parent="#accordionExample">
      <div class="alert alert-danger msg" role="alert">
          
      </div>
  </div>
  <div class="border rounded-pill p-1 my-3" style="width:100%;">
      <div class="loading-bar bg-glass rounded-pill" style="height:10px; width:0%; transition: width 2s"></div>
  </div>
  <button type="submit" class="btn mt-2 btn-info text-white rounded-pill btn-sm" style="width:100%">Submit</button>
</form>


<script>
    queryResult = {};
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/chrome");
    editor.session.setMode("ace/mode/javascript");
    queries = JSON.parse('<?= json_encode($query) ?>')
    generated = ""

    val = editor.getSession().getValue()
    $("#query-field").val(val)

    editor.getSession().on("change", function () {
      val = editor.getSession().getValue()
      $("#query-field").val(val)
    });

    $(document).on('change', ".selectize", function(e){
      let value = JSON.stringify($(e.target).val());
      $(e.target).siblings(".queryID").val(value)

      let form = $(e.target).closest("form")
      form.find("#get").val(createGet(value))
    })
    
    $(".testArray").click(function(){
      //get form 
      let form = $(this).closest("form")
      let ids = form.find('.selectize').val()
      let get = form.find("#get").val()

      let limit = 100;

      let i = 0
      let counter = []
      let endresult = []
      let nQuery = 0;
      let process = 0;
      let doneCount = 0;

      if(generated != get){
        count()
        generated = get
      } else {
        let urls = "<?= base_url() ?>index.php/process/testfunction"
        $.ajax({
          type : "POST",
          url : urls,
          data : {function : val},
          success : function(res) {
            $(".array-result").html(res)
          }
        })
      }

      function count(){
        loader(0)
        if(i < ids.length){
          i++;
          $.ajax({
              type: "POST",
              url: "<?= base_url("index.php/process/countQuery/?") ?>" + get,
              async: true,
              data: { id: ids[i-1] },
              success: function(res) {
                  res = JSON.parse(res);
                  if (!res.err) {
                    counter.push({ count: res.data[0].count, id: ids[i-1] });
                  }
                  count()
              },
              error: function(xhr, status, error) {
                  console.log(error);
                  count()
              }
          });
        } else {
          nQuery = 0;
          process = 0;
          endresult = []
          doneCount = 0;
          getData()
        }
      }

      function getData(){
        let max = 0;
        counter.forEach(function(n){
          max += parseInt(n.count)
        })
        max += limit;
        let prog = 100 * (doneCount/max)
        loader(prog)
        if(nQuery < counter.length){
          if(process < parseInt(counter[nQuery].count)){
            let id = parseInt(counter[nQuery].id) 
            $.ajax({
              type: "POST",
              url: "<?= base_url("index.php/process/getQuery?") ?>" + get,
              data : {
                id,limit,offset: process
              },
              success: function(res){
                process += limit
                
                let data = JSON.parse(res);
                data = data.data;

                endresult = endresult.concat(data)
                doneCount += data.length
                getData()
              }
            })
          } else {
            let name = "unamed"
            queries.forEach(function(ar){
              if(counter[nQuery].id == ar.id){
                name = ar.name
              }
            });
            queryResult[name] = endresult;
            nQuery ++;
            process = 0;
            endresult = []
            getData()
          }
        } else {
          loader(100);
          let urls = "<?= base_url() ?>index.php/process/testfunction"
          $.ajax({
            type : "POST",
            url : urls,
            data : {function : val},
            success : function(res) {
              $(".array-result").html(res)
            }
          })
        }
      }

      function loader(width){
        if(width > 100){
            width = 100
        }
        $(".loading-bar").css('width',width+'%');
      }

    });

    $('.selectize').selectize({
      create: true, // Allows creating new items
      sortField: 'text', // Sorts the options by text
      plugins: ['remove_button']
    });

    function createGet(id) {
        let jsonObjects = queries
        let ids = JSON.parse(id)
        const params = {};

        jsonObjects.forEach(obj => {
            if (ids.includes(obj.id) && obj.get !== null) {
                const urlParams = new URLSearchParams(obj.get);
                urlParams.forEach((value, key) => {
                    params[key] = value;
                });
            }
        });

        return new URLSearchParams(params).toString();
    }
</script>