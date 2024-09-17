<form action="<?= base_url('index.php/process/insert/report') ?>" method="post">
  <h5 class="text-info"><i class="fa-solid fa-folder-plus fa-lg"></i> Create Report</h5>
  <hr>
  <div class="mb-1">
    <label for="name"  class="form-text">Template Name</label>
    <input type="text" required name="name" class="form-control" id="name" placeholder="Example Company LTD">
  </div>
  
  <label class="form-text">Select Template</label>
  <select class="form-select" name="template_id" aria-label="Default select example">
    <option selected>Open this select menu</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
  </select>
  
  <div class="mb-1">
    <label for="url" class="form-text">Url</label>
    <div class="input-group">
      <small class="input-group-text" id="basic-addon3"><em><?= base_url() ?></em></small>
      <input type="text" class="form-control" id="url" name="url" aria-describedby="basic-addon3 basic-addon4">
    </div>
  </div>


  <div class="accordion-collapse collapse alerting mt-2" data-bs-parent="#accordionExample">
      <div class="alert alert-danger msg" role="alert">
          
      </div>
  </div>
  <button type="submit" class="btn mt-2 btn-info text-white rounded-pill btn-sm" style="width:100%">Submit</button>
</form>
