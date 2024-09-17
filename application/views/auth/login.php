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

        <div class="px-4 py-5 px-md-5 vertical-center">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    Unlock the full potential  <br />
                    <span style="color: hsl(218, 81%, 75%)">of IoT</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                        Revolutionize your business with our comprehensive IoT services. We provide seamless integration, real-time data analytics, and smart automation solutions to enhance efficiency and foster innovation. Our expert team tailors each solution to meet your unique needs, ensuring you unlock the full potential of IoT technology. Boost productivity, reduce costs, and stay ahead of the competition with our cutting-edge IoT services.
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form action="<?= base_url('index.php/auth/login') ?>" method="post">
                                <!-- Email input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label text-white" for="form3Example3">Username</label>
                                    <input type="text" required name="username" id="form3Example3" class="form-control" />
                                </div>

                                <!-- Password input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label text-white" for="form3Example4">Password</label>
                                    <input required type="password" name="password" id="form3Example4" class="form-control" />
                                </div>
                                <!-- Submit button -->
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                                    Sign In
                                </button>
                            </form>
                            <div id="invalid-login" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="alert alert-danger msg" role="alert">
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
                if(res != "done"){
                    console.log(res)
                    $("#invalid-login").collapse('show')
                } else {
                    window.location.href = "<?= base_url() ?>";
                }
            }
        })
      })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>