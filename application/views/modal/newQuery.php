<form action="<?= base_url('index.php/process/insert/query') ?>" method="post">
  <h5 class="text-info"><i class="fa-solid fa-folder-plus fa-lg"></i> Create Query</h5>
  <hr>
  <div class="mb-1">
    <label for="companyname"  class="form-text">Query Name</label>
    <input type="text" required name="name" class="form-control" id="companyname" placeholder="Example Company LTD">
  </div>
  
  <label class="form-text">Select database</label>
  <select class="form-select" name="database_id" aria-label="Default select example">
    <option selected value="">Select Database</option>
    <?php foreach ($db as $database): ?>
      <option value="<?= $database->id ?>"><?= $database->db_name ?></option>
    <?php endforeach; ?>
  </select>
  
  <div class="mb-1">
    <label for="get" class="form-text">Pass Variable</label>
    <div class="input-group">
      <small class="input-group-text" id="basic-addon3"><em>http://URL/endpoint?</em></small>
      <input type="text" name="get" class="form-control" id="get" placeholder="key1=value&key2=value4" aria-describedby="basic-addon3 basic-addon4">
    </div>
  </div>
    
  <div class="row">
    <div class="col-md-8">
      <label class="form-text">Query</label>
      <div class="position-relative" style="width:100%; height:200px">
        <div id="editor" class="editor"></div>
      </div>
    </div>
    <div class="col-md-4">
      <a class="testQuery btn btn-outline-info btn-sm mt-4 rounded-pill" style="width:100%" href="javascript:void(0)">Test Query</a>
      <div class="query-result"></div>
    </div>
  </div>
  
  <textarea name="code" id="query-field" class="d-none"></textarea>

  <div class="accordion-collapse collapse alerting mt-2" data-bs-parent="#accordionExample">
      <div class="alert alert-danger msg" role="alert">
          
      </div>
  </div>
  <button type="submit" class="btn mt-2 btn-info text-white rounded-pill btn-sm" style="width:100%">Submit</button>
</form>

     
<script>
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/chrome");
    editor.session.setMode("ace/mode/sql");

    // let input = $('input[name="komutdosyasi"]');

    editor.getSession().on("change", function () {
      let val = editor.getSession().getValue()
      $("#query-field").val(val)
    });

    $(".testQuery").click(function(){
      let form = $(this).closest("form")

      let val = form.find("#query-field").val()
      let db = form.find("[name=database_id]").find(":selected").val()
      if(db != ""){
        let urls = "<?= base_url() ?>index.php/process/testQuery/"
        $.ajax({
          type : "POST",
          url : urls + db,
          data : {query : val},
          success : function(res) {
            let data = JSON.parse(res)
            if(data.error){
              console.log("error");
            } else {
              prettyPrintJson(data.data, 'query-result');
              console.log(data.data);
            }
          }
        })
      }
    });

    function syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, undefined, 2);
        }
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(\.\d*)?([eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }

    function prettyPrintJson(obj, elementId) {
        var element = $('.' + elementId);
        if (element.length) {
            element.html(syntaxHighlight(obj));
        }
    }
</script>