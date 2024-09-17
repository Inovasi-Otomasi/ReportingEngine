<form action="<?= base_url('index.php/process/insert/template') ?>" method="post">
  <h5 class="text-info"><i class="fa-solid fa-folder-plus fa-lg"></i> Upload Template</h5>
  <hr>
  <div class="mb-1">
    <label for="companyname"  class="form-text">Template Name</label>
    <input type="text" required name="name" class="form-control" id="companyname" placeholder="Example Company LTD">
  </div>

  <div class="mb-3">
    <label class="form-text" for="formFile">Template File</label>
    <input class="form-control" name="template" type="file" id="formFile">
  </div>


  <div class="accordion-collapse collapse alerting mt-2" data-bs-parent="#accordionExample">
      <div class="alert alert-danger msg" role="alert">
          
      </div>
  </div>
  <button type="submit" class="btn mt-2 btn-info text-white rounded-pill btn-sm" style="width:100%">Submit</button>
</form>
