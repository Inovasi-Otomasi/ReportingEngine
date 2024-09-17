
<form action="<?= base_url('index.php/process/update/databases/') . $config->id ?>" method="post">
  <h5 class="text-info"><i class="fa-solid fa-folder-plus fa-lg"></i> Add New Database</h5>
  <hr>
  <div class="mb-1">
      <label for="dsn" class="form-text">DSN</label>
      <input type="text" name="dsn" class="form-control form-control-sm" id="dsn" placeholder="Enter DSN" value="<?= isset($config->dsn) ? $config->dsn : '' ?>">
  </div>

  <div class="mb-1">
      <label for="hostname" class="form-text">Hostname</label>
      <input type="text" name="hostname" class="form-control form-control-sm" id="hostname" placeholder="Enter hostname" value="<?= isset($config->hostname) ? $config->hostname : '' ?>" required>
  </div>

  <div class="mb-1">
      <label for="username" class="form-text">Username</label>
      <input type="text" name="username" class="form-control form-control-sm" id="username" placeholder="Enter username" value="<?= isset($config->username) ? $config->username : '' ?>" required>
  </div>

  <div class="mb-1">
      <label for="password" class="form-text">Password</label>
      <input type="password" name="password" class="form-control form-control-sm" id="password" placeholder="Enter password" value="<?= isset($config->password) ? $config->password : '' ?>" required>
  </div>

  <div class="mb-1">
      <label for="database" class="form-text">Database</label>
      <input type="text" name="database" class="form-control form-control-sm" id="database" placeholder="Enter database" value="<?= isset($config->database_name) ? $config->database_name : '' ?>" required>
  </div>

  <div class="accordion" id="accordionExample">
    <div class="">
      <h2 class="accordion-header" id="headingOne">
        <button class="btn collapsed border rounded-pill form-text" type="button" style="width:100%" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fa-solid fa-gear fa-xs"></i> Advance Setting
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="">
          <div class="mb-1">
              <label for="dbdriver" class="form-text">DB Driver</label>
              <input type="text" name="dbdriver" class="form-control form-control-sm" id="dbdriver" value="<?= isset($config->dbdriver) ? $config->dbdriver : 'mysqli' ?>" placeholder="Enter DB driver">
          </div>
        
          <div class="mb-1">
              <label for="dbprefix" class="form-text">DB Prefix</label>
              <input type="text" name="dbprefix" class="form-control form-control-sm" id="dbprefix" placeholder="Enter DB prefix" value="<?= isset($config->dbprefix) ? $config->dbprefix : '' ?>">
          </div>
        
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="pconnect" value="false">
              <label class="form-text" for="pconnect">Persistent Connection</label>
              <input class="form-check-input" type="checkbox" name="pconnect" id="pconnect" value="true" <?= isset($config->pconnect) && $config->pconnect ? 'checked' : '' ?>>
          </div>
        
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="db_debug" value="false">
              <label class="form-text" for="db_debug">DB Debug</label>
              <input class="form-check-input" type="checkbox" name="db_debug" id="db_debug" value="true" <?= isset($config->db_debug) && $config->db_debug ? 'checked' : '' ?>>
          </div>
        
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="cache_on" value="false">
              <label class="form-text" for="cache_on">Cache On</label>
              <input class="form-check-input" type="checkbox" name="cache_on" id="cache_on" value="true" <?= isset($config->cache_on) && $config->cache_on ? 'checked' : '' ?>>
          </div>
        
          <div class="mb-1">
              <label for="cachedir" class="form-text">Cache Directory</label>
              <input type="text" name="cachedir" class="form-control form-control-sm" id="cachedir" placeholder="Enter cache directory" value="<?= isset($config->cachedir) ? $config->cachedir : '' ?>">
          </div>
        
          <div class="mb-1">
              <label for="char_set" class="form-text">Character Set</label>
              <input type="text" name="char_set" class="form-control form-control-sm" id="char_set" value="<?= isset($config->char_set) ? $config->char_set : 'utf8' ?>" placeholder="Enter character set">
          </div>
        
          <div class="mb-1">
              <label for="dbcollat" class="form-text">DB Collation</label>
              <input type="text" name="dbcollat" class="form-control form-control-sm" id="dbcollat" value="<?= isset($config->dbcollat) ? $config->dbcollat : 'utf8_general_ci' ?>" placeholder="Enter DB collation">
          </div>
        
          <div class="mb-1">
              <label for="swap_pre" class="form-text">Swap Prefix</label>
              <input type="text" name="swap_pre" class="form-control form-control-sm" id="swap_pre" placeholder="Enter swap prefix" value="<?= isset($config->swap_pre) ? $config->swap_pre : '' ?>">
          </div>
        
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="encrypt" value="false">
              <label class="form-text" for="encrypt">Encrypt</label>
              <input class="form-check-input" type="checkbox" name="encrypt" id="encrypt" value="true" <?= isset($config->encrypt) && $config->encrypt ? 'checked' : '' ?>>
          </div>
        
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="compress" value="false">
              <label class="form-text" for="compress">Compress</label>
              <input class="form-check-input" type="checkbox" name="compress" id="compress" value="true" <?= isset($config->compress) && $config->compress ? 'checked' : '' ?>>
          </div>
        
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="stricton" value="false">
              <label class="form-text" for="stricton">Strict On</label>
              <input class="form-check-input" type="checkbox" name="stricton" id="stricton" value="true" <?= isset($config->stricton) && $config->stricton ? 'checked' : '' ?>>
          </div>
          <div class="form-check form-switch mb-1">
              <input type="hidden" name="save_queries" value="false">
              <label class="form-text" for="save_queries">Save Queries</label>
              <input class="form-check-input" type="checkbox" name="save_queries" id="save_queries" value="true" <?= isset($config->save_queries) && $config->save_queries ? 'checked' : '' ?>>
          </div>
        </div>
      </div>
      <div class="accordion-collapse collapse alerting mt-2" data-bs-parent="#accordionExample">
          <div class="alert alert-danger msg" role="alert">
              
          </div>
      </div>
    </div>
  </div>

  <button type="submit" class="btn mt-2 btn-info text-white rounded-pill btn-sm" style="width:100%">Submit</button>
</form>