<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Condor - Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Google fonts - Popppins for copy-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="../vendor/back/prismjs/plugins/toolbar/prism-toolbar.css">
    <link rel="stylesheet" href="../vendor/back/prismjs/themes/prism-okaidia.css">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="../css/back/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../css/back/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="../img/back/favicon.png">
  </head>
  <body>
    <div class="container-fluid px-0">
      <div class="row gx-0 min-vh-100">
        <div class="col-md-9 col-lg-6 col-xl-4 px-5 d-flex align-items-center shadow">
          <div class="w-100 py-5">
            <div class="text-center"><img class="img-fluid mb-4" src="../img/back/brand/brand-1.svg" alt="..." style="max-width: 6rem;">
              <h1 class="h4 text-uppercase mb-5">Welcome Back</h1>
            </div>
            <form id="signform" class="needs-validation" method="post">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input class="form-control" id="username" name="username" minlength=4 maxlength=16 required>
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">Please choose a valid 4-16 lengthed username</div>
              </div>
              <div class="mb-4">
                <div class="row">
                  <div class="col">
                    <label class="form-label">Password</label>
                  </div>
                  <div class="col-auto"><a class="form-text small text-muted" href="reset.php">Forgot your password?</a></div>
                </div>
                <input class="form-control" id="password" name="password" type="password">
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback"></div>
              </div>
              <div class="form-check mb-4">
                <input class="form-check-input" id="remember" type="checkbox">
                <label class="custom-control-label" for="remember">Remember this device</label>
              </div>
              <!-- Submit-->
              <div class="d-grid mb-5">
                <button id="signin" class="btn btn-primary text-uppercase">Sign in</button>
              </div>
              <!-- Link-->
              <p class="text-sm text-muted text-center">
                 Don't have an account yet? <a href="register.php">Register</a>.</p>

              <p class="text-sm text-muted text-center">
                Go <a href="index.php">back</a>.</p>
            </form>
          </div>
        </div>
        <div class="col-md-3 col-lg-6 col-xl-8 d-none d-md-block">
          <!-- Image-->
          <div class="bg-cover h-100 me-n3" style="background-image: url(../img/back/photos/victor-ene-1301123-unsplash.jpg);"></div>
        </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="../vendor/back/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="../js/back/theme.js"></script>
    <!-- Prism for syntax highlighting-->
    <script src="../vendor/back/prismjs/prism.js"></script>
    <script src="../vendor/back/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js"></script>
    <script src="../vendor/back/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="../vendor/back/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <script src="../vendor/front/jquery/jquery.js"></script>
    <script type="text/javascript">
      // Optional
      Prism.plugins.NormalizeWhitespace.setDefaults({
      'remove-trailing': true,
      'remove-indent': true,
      'left-trim': true,
      'right-trim': true,
      });

    </script>

    <script>
        $(document).ready(function() {
            $('#signin').click(function(event) {
                if($('#signform')[0].checkValidity()) {
                    event.preventDefault();

                    console.log("sending");

                    $.ajax({
                        url: "../controllers/login.php",
                        type: "POST",
                        data: {
                            'username': $('#username').val(),
                            'password': $('#password').val()
                        },
                        dataType: 'json',
                        complete: function() { $("body").removeClass("loading"); },
                        success: function(dataResult) {

                            console.log(dataResult);

                            if(dataResult.success) {
                                window.location.replace("../index.php");
                            } else {
                                $('input[name=' + dataResult.name + ']').addClass('is-invalid');
                                $('input[name=' + dataResult.name + ']').next().next().html(dataResult.message);
                                $('input[name=' + dataResult.name + ']')[0].setCustomValidity(dataResult.message);
                                $('input[name=' + dataResult.name + ']').focus();
                            }

                        }
                    });


                }

            });

            $("#username").keydown(function() {
                $(this).removeClass('is-invalid');
                $(this)[0].setCustomValidity("");
                $(this).next().html("");
            });

            $("#password").keydown(function() {
                $(this).removeClass('is-invalid');
                $(this)[0].setCustomValidity("");
                $(this).next().html("");
            });
        });
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>
