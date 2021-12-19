<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Condor</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/front/bootstrap/css/bootstrap.min.css">
    <!-- Lightbox-->
    <link rel="stylesheet" href="vendor/front/lightbox2/css/lightbox.min.css">
    <!-- Range slider-->
    <link rel="stylesheet" href="vendor/front/nouislider/nouislider.min.css">
    <!-- Bootstrap select-->
    <link rel="stylesheet" href="vendor/front/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="vendor/front/owl.carousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/front/owl.carousel2/assets/owl.theme.default.css">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/front/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/front/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/front/favicon.png">
    <script src="js/jquery-3.1.0.min.js"></script>

    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
  <?php

    date_default_timezone_set("Asia/Beirut");
    include("controllers/database/connection.php");
    $con=openCon();
    session_start();
    if (!isset($_SESSION['id'])){
    $users_id=-1;
    header('Location:user/login.php');
    }
    else $users_id=$_SESSION['id'];
    //$users_id=1;
    $users = mysqli_query($con, "select * from users where id=$users_id");
    $rusers = mysqli_fetch_array($users);
    $products = mysqli_query($con, "SELECT cart.users_id, cart.products_id, cart.quantity as itemquantity, products.* FROM cart, products WHERE cart.users_id = $users_id and cart.products_id=products.id");
    if (mysqli_num_rows($products)==false){
      header('location: index.php');
    }
    ?>
    <div class="page-holder">
      <!-- navbar-->
      <header class="header bg-white">
      <div class="container px-0 px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="index.php"><span class="font-weight-bold text-uppercase text-dark">Boutique</span></a>
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <!-- Link--><a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <!-- Link--><a class="nav-link" href="shop.php">Shop</a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">

              <?php
                if($users_id == -1) {
              ?>
              <li class="nav-item"><a class="nav-link" href="user/login.php"> <i class="fas fa-user-alt mr-1 text-gray"></i>Login</a></li>
              <?php }
              else {
                echo "<li class='nav-item'><a class='nav-link' href='cart.php'> <i class='fas fa-dolly-flatbed mr-1 text-gray'></i>Cart<small class='text-gray'></small></a></li>
                <li class='nav-item'><a class='nav-link' href='wishlist1.php'> <i class='far fa-heart mr-1'></i><small class='text-gray'></small></a></li>";
                echo "

                <li class='nav-item dropdown'><a class='nav-link dropdown-toggle' id='pagesDropdown' href='#' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-user-alt mr-1 text-gray'></i></a>
                  <div class='dropdown-menu mt-3' aria-labelledby='pagesDropdown'><a class='dropdown-item border-0 transition-link' href='user/profile.php?id=".base64_encode($users_id)."'>User Profile</a>
                  ";
                  echo "
                  <a class='dropdown-item border-0 transition-link' href='myorders.php'>My Orders</a>";
                  if (isset($_SESSION['admin'])&& $_SESSION['admin']==true)
                  echo "
                  <a class='dropdown-item border-0 transition-link' href='admin/index.php'>Admin Panel</a>";
                  echo "
                  <a class='dropdown-item border-0 transition-link' href='user/logout.php'>Logout</a></div>
                </li>";
              }
              ?>
            </ul>
          </div>
        </nav>
      </div>
    </header>
         <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Checkout</h1>
                <?php
                      $verified=1;
                      if ($_SESSION['verified']==false){
                        $verified=0;
                        echo " <h3 class='h4  mb-0' style='color:red'>You should verify your email address before ordering.</h3>";
                      }
                    ?>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="cart.php">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>

                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <!-- BILLING ADDRESS-->
          <h2 class="h5 text-uppercase mb-4">Billing details</h2>
          <div id="toappend"></div>
          <div class="row">
            <div class="col-lg-8">
              <form action="#" id='main'>
                <div class="row">
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="firstName">First name</label>
                    <input class="form-control form-control-lg" id="firstName" name="firstName" type="text" value='<?php
                        echo $rusers["firstname"];
                        ?>' disabled>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="lastName">Last name</label>
                    <input class="form-control form-control-lg form-control" id="lastName" name="lastName" type="text" value='<?php
                        echo $rusers["lastname"];
                        ?>' disabled>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="email">Email address</label>
                    <input class="form-control form-control-lg" name = "email "id="email" type="email" value='<?php
                        echo $rusers["email"];
                        ?>' disabled>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="phone">Phone number</label>
                    <input class="form-control form-control-lg" id="phone" name = "phone" type="tel" placeholder="e.g. +02 245354745" required>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="company">Company name (optional)</label>
                    <input class="form-control form-control-lg" id="company" name = "company" type="text" placeholder="Your company name">
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="country">Country</label>
                    <select class="selectpicker country" id="country" name = "country" data-width="fit" data-style="form-control form-control-lg" data-title='<?php
                        echo $rusers["country"];
                        ?>' disabled></select>
                  </div>
                  <div class="col-lg-12 form-group">
                    <label class="text-small text-uppercase" for="address">Address line 1</label>
                    <input class="form-control form-control-lg" id="address" name = "address" type="text" placeholder="House number and street name" required>
                  </div>
                  <div class="col-lg-12 form-group">
                    <label class="text-small text-uppercase" for="address">Address line 2</label>
                    <input class="form-control form-control-lg" id="addressalt" type="text" name = "addressalt"  placeholder="Apartment, Suite, Unit, etc (optional)">
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="city">Town/City</label>
                    <input class="form-control form-control-lg" name="city" id="city" type="text" value='<?php
                        echo $rusers["city"];
                        ?>' disabled>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="zip">Zip</label>
                    <input class="form-control form-control-lg" name="zip" id="zip" type="text" value='<?php
                        echo $rusers["zip"];
                        ?>' disabled>
                  </div>
                  <!-- </form> -->

                  <div class="col-lg-6 form-group">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" id="alternateAddressCheckbox" type="checkbox" value='yes'>
                      <label class="custom-control-label text-small" for="alternateAddressCheckbox">Alternate billing address</label>
                    </div>
                  </div>
                  <form action="#">
                  <div class="col-lg-12">
                    <div class="row d-none" id="alternateAddress">
                      <div class="col-12 mt-4">
                        <h2 class="h4 text-uppercase mb-4">Alternative billing details</h2>
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="firstName2">First name</label>
                        <input class="form-control form-control-lg" name ='firstName2' id="firstName2" type="text" placeholder="Enter your first name" required>
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="lastName2">Last name</label>
                        <input class="form-control form-control-lg" name='lastName2' id="lastName2" type="text" placeholder="Enter your last name" required>
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="email2">Email address</label>
                        <input class="form-control form-control-lg" name='email2' id="email2" type="email" placeholder="e.g. Jason@example.com" required>
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="phone2">Phone number</label>
                        <input class="form-control form-control-lg" name='phone2' id="phone2" type="tel" placeholder="e.g. +02 245354745" required>
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="company2">Company name (optional)</label>
                        <input class="form-control form-control-lg" name= 'company2' id="company2" type="text" placeholder="Your company name">
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="country2">Country</label>
                        <select class="selectpicker country" name='coutnry2' id="country2" data-width="fit" data-style="form-control form-control-lg" data-title="Select your country" required></select>
                      </div>
                      <div class="col-lg-12 form-group">
                        <label class="text-small text-uppercase" for="address2">Address line 1</label>
                        <input class="form-control form-control-lg" name='address2' id="address2" type="text" placeholder="House number and street name" required>
                      </div>
                      <div class="col-lg-12 form-group">
                        <label class="text-small text-uppercase" for="addressalt2">Address line 2</label>
                        <input class="form-control form-control-lg" id="addressalt2" type="text" placeholder="Apartment, Suite, Unit, etc (optional)">
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="city2">Town/City</label>
                        <input class="form-control form-control-lg" name='city2' id="city2" type="text" required>
                      </div>
                      <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="zip2">Zip</label>
                        <input class="form-control form-control-lg" id="zip2" name='zip2' type="text" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12 form-group">
                    <button class="btn btn-dark" id="submit" >Place order</button>
                  </div>
                  </form>
                </div>
            </div>

            <script>

              $(document).ready(function(){

                var verified = <?php echo $verified; ?>;
                console.log("Verified");
                console.log(verified);
                if (verified=='0'){
                  $('#couponcode').attr('disabled',true);
                  $('#submit').attr('disabled',true);
                  return;
                }


                var usersid = <?php echo $users_id?>;
                console.log(usersid);

                var counter=0;
                var couponc = '0';
                $("#couponcode").click(function(){
                  counter++;
                  if (counter==1){
                  var couponid = $('#couponid').val();
                  var oldtotal = $('#total').text();
                  console.log(oldtotal);
                  $.ajax({
                    type: "POST",
                    url : 'insertcoupon.php',
                    data : {
                      'coupon': couponid,
                    },
                    dataType: 'json',
                    success: function (res) {
                      if (res.success){
                        $("#total").text(oldtotal*(1- (res.message/100)));
                        $('#couponadded').text('Coupon ' + couponid + ' added for ' + res.message+ ' % off.');
                        console.log(res.message);
                        couponc =couponid;
                        console.log("coupon: " + couponc);
                        $('#couponcode').attr('disabled',true);
                      }
                      else {
                        $('#couponadded').text('Coupon Not Available');
                        counter--;
                      }
                    }
                  })
                }
                })


                $("#submit").click(function(e){

                  if (!$('#alternateAddressCheckbox').prop('checked')){

                    if ( $("#phone").val()==''){
                        $('#phone').css('border-color','red');
                      }

                      if ($("#address").val()==''){
                        $('#address').css('border-color','red');
                      }



                    var firstName = $("#firstName").val();
                    var lastName = $("#lastName").val();
                    var email = $("#email").val();
                    var phone = $("#phone").val();
                    var company = $("#company").val();
                    var country = $("#country").attr('data-title');
                    var address = $("#address").val();
                    var address2 = $("#addressalt").val();
                    var city = $("#city").val();
                    var zip = $("#zip").val();
                  }
                    else {

                    var firstName = $("#firstName2").val();
                    var lastName = $("#lastName2").val();
                    var email = $("#email2").val();
                    var phone = $("#phone2").val();
                    var company = $("#company2").val();
                    var country = $("#country2 option:selected").text();
                    var address = $("#address2").val();
                    var address2 = $("#addressalt2").val();
                    var city = $("#city2").val();
                    var zip = $("#zip2").val();
                    };

                    if (firstName!='' && lastName!='' && email!='' && phone!='' && country!='' && address!='' && city!='' && zip!=''){

                    $.ajax({
                      type: "POST",
                      url:'placeorder.php',
                      data:{
                        'firstname' : firstName,
                        'lastname' : lastName,
                        'email' : email,
                        'phone' : phone,
                        'company' : company,
                        'country' : country,
                        'address' : address,
                        'address2' : address2,
                        'city' : city,
                        'zip' : zip,
                        'usersid' : usersid,
                        'coupon': couponc,
                      },
                      datatype: 'json',
                            success:function(data) {
                              window.location='myorders.php';
                            },
                            error: function(e) {
                                console.log(e);
                            },
                    })
                  }
                })
              })
            </script>
            <!-- ORDER SUMMARY-->
            <div class="col-lg-4">
              <div class="card border-0 rounded-0 p-lg-4 bg-light">
                <div class="card-body">
                  <h5 class="text-uppercase mb-4">Your order</h5>
                  <ul class="list-unstyled mb-0">
                    <?php
                    $subtotal=0;
                    while($rproducts=mysqli_fetch_array($products)){
                      $rproductsid = $rproducts["id"];
                      if ($rproducts["itemquantity"]>$rproducts["quantity"])
                      {
                        mysqli_query($con, "update cart set quantity=$rproducts[quantity] where users_id=$users_id and products_id = $rproducts[id]");
                        echo '<script>window.location="checkout.php"</script>';
                      }

                      $old_price = $rproducts["price"];
                        if (!empty($rproducts["salePercentage"])) {
                          $sale = 1 - $rproducts["salePercentage"] / 100;
                          $new_price = $rproducts["price"] * $sale;
                        } else {
                          $new_price = $rproducts["price"]
                          ;
                        }
                        $subtotalprod = $new_price*$rproducts["itemquantity"];
                        $subtotal= $subtotal + $subtotalprod;

                        echo"<li class='d-flex align-items-center justify-content-between'><strong class='small font-weight-bold'>".$rproducts["name"]."&nbsp (".($rproducts["itemquantity"]).")</strong><span class='text-muted small'>$".$subtotalprod."</span></li>";
                      }
                      echo"<li class='border-bottom my-2'></li>
                      <li class='d-flex align-items-center justify-content-between'><strong class='text-uppercase small font-weight-bold'>Total</strong><p>$<span id='total'>".$subtotal."</span></p></li>";
                      echo"<li>		
                      <div class='form-group mb-0' id='coupon'>
                                               <input class='form-control' type='text' placeholder='Enter your coupon' id='couponid'>
                                               <button class='btn btn-dark btn-sm btn-block' id='couponcode'> <i class='fas fa-gift mr-2'></i>Apply coupon</button>
                                               <!-- add ajax -->
                                             </div></li>
                                             <li id='couponadded' class='text-muted small'></li>";


                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="bg-dark text-white">
        <div class="container py-4">
          <div class="row py-5">
            <div class="col-md-4 mb-3 mb-md-0">
              <h6 class="text-uppercase mb-3">Customer services</h6>
              <ul class="list-unstyled mb-0">
                <li><a class="footer-link" href="#">Help &amp; Contact Us</a></li>
                <li><a class="footer-link" href="#">Returns &amp; Refunds</a></li>
                <li><a class="footer-link" href="#">Online Stores</a></li>
                <li><a class="footer-link" href="#">Terms &amp; Conditions</a></li>
              </ul>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
              <h6 class="text-uppercase mb-3">Company</h6>
              <ul class="list-unstyled mb-0">
                <li><a class="footer-link" href="#">What We Do</a></li>
                <li><a class="footer-link" href="#">Available Services</a></li>
                <li><a class="footer-link" href="#">Latest Posts</a></li>
                <li><a class="footer-link" href="#">FAQs</a></li>
              </ul>
            </div>
            <div class="col-md-4">
              <h6 class="text-uppercase mb-3">Social media</h6>
              <ul class="list-unstyled mb-0">
                <li><a class="footer-link" href="#">Twitter</a></li>
                <li><a class="footer-link" href="#">Instagram</a></li>
                <li><a class="footer-link" href="#">Tumblr</a></li>
                <li><a class="footer-link" href="#">Pinterest</a></li>
              </ul>
            </div>
          </div>
          <div class="border-top pt-4" style="border-color: #1d1d1d !important">
            <div class="row">
              <div class="col-lg-6">
                <p class="small text-muted mb-0">&copy; 2020 All rights reserved.</p>
              </div>
              <div class="col-lg-6 text-lg-right">
                <p class="small text-muted mb-0">Template designed by <a class="text-white reset-anchor" href="https://bootstraptemple.com/p/bootstrap-ecommerce">Bootstrap Temple</a></p>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- JavaScript files-->
      <script src="vendor/front/jquery/jquery.min.js"></script>
      <script src="vendor/front/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/front/lightbox2/js/lightbox.min.js"></script>
      <script src="vendor/front/nouislider/nouislider.min.js"></script>
      <script src="vendor/front/bootstrap-select/js/bootstrap-select.min.js"></script>
      <script src="vendor/front/owl.carousel2/owl.carousel.min.js"></script>
      <script src="vendor/front/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
      <script src="js/front/front.js"></script>
      <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite -
        //   see more here
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {

            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

      </script>
      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </div>
  </body>
</html>
