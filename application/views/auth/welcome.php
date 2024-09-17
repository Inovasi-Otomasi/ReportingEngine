<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IAN Platform - Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>">
  </head>
  <body class="overflow-hidden">
    <!-- Section: Design Block -->
    <section class="background-radial-gradient" style="height:100vh; width:100vw;">

        <div class="px-4 py-5 px-md-5 vertical-center" style="width:100%">
            <div class="row gx-lg-5 align-items-center justify-content-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form action="<?= base_url('index.php/auth/welcome') ?>" method="post">
                                <div class="row">
                                    <div data-mdb-input-init class="form-outline col-9 mb-1">
                                        <label class="form-label text-white" for="hostname">Host</label>
                                        <input type="text" required name="dbhost" id="hostname" class="form-control form-control-sm" />
                                    </div>
                                    <div data-mdb-input-init class="form-outline col-3 mb-1">
                                        <label class="form-label text-white" for="hostport">port</label>
                                        <input type="number" name="dbport" id="hostport" class="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div data-mdb-input-init class="form-outline col-md-6 mb-1">
                                        <label class="form-label text-white" for="dbusername">Username</label>
                                        <input type="text" required name="dbuser" id="dbusername" class="form-control form-control-sm" />
                                    </div>
                                    <div data-mdb-input-init class="form-outline col-md-6 mb-1">
                                        <label class="form-label text-white" for="dbpassword">password</label>
                                        <input type="text" required name="dbpass" id="dbpassword" class="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-1">
                                    <label class="form-label text-white" for="dbname">Database Name</label>
                                    <input type="text" required name="dbname" id="dbname" class="form-control form-control-sm" />
                                </div>
                                <!-- Submit button -->
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                                    Next
                                </button>
                            </form>
                            <div id="invalid-login" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="alert alert-danger" role="alert">
                                    Invalid username or password
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <!-- Section: Design Block -->
    <script>
        $(document).on('submit', 'form' , function(e){
        e.preventDefault();
        let data = $(this).serialize()
        $.ajax({
            type : $(this).attr('method'),
            url : $(this).attr('action'),
            data : data,
            success : function(res){
                if(res != '"done"'){
                    console.log(res)
                    $("#invalid-login").collapse('show')
                } else {
                    window.location.reload();
                }
            }
        })
      })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>