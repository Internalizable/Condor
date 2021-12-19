<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Boutique | Ecommerce bootstrap template</title>
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <script src="js/jquery-3.1.0.min.js"></script>
  </head>
  <style>
  .quantity {
  position: relative;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}

.quantity input {
  width: 45px;
  height: 42px;
  line-height: 1.65;
  float: left;
  display: block;
  padding: 0;
  padding-right: 20px;
  margin: 0;
  border: none;
  box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.08);
  font-size: 1rem;
  border-radius: 4px;
}

.quantity input:focus {
  outline: 0;
}

.quantity-nav {
  float: left;
  position: relative;
  height: 42px;
}

.quantity-button {
  position: relative;
  cursor: pointer;
  border: none;
  border-left: 1px solid rgba(0, 0, 0, 0.08);
  width: 21px;
  text-align: center;
  color: #333;
  font-size: 13px;
  font-family: "FontAwesome" !important;
  line-height: 1.5;
  padding: 0;
  background: #FAFAFA;
  -webkit-transform: translateX(-100%);
  transform: translateX(-100%);
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}

.quantity-button:active {
  background: #EAEAEA;
}

.quantity-button.quantity-up {
  position: absolute;
  height: 50%;
  top: 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  font-family: "FontAwesome";
  border-radius: 0 4px 0 0;
  line-height: 1.6
}

.quantity-button.quantity-down {
  position: absolute;
  bottom: 0;
  height: 50%;
  font-family: "FontAwesome";
  border-radius: 0 0 4px 0;
}
  </style>
  <body>
    <?php
    session_start();
    if (!isset($_SESSION['id'])){
    $users_id=-1;
    header('Location:user/login.php');
    }
    else $users_id=$_SESSION['id'];
    date_default_timezone_set("Asia/Beirut");
    include("controllers/database/connection.php");
    $con=openCon();
    //$users_id=1;
    $products = mysqli_query($con, "SELECT cart.users_id, cart.products_id, cart.quantity as itemquantity, products.*, products_media.* FROM cart, products,products_media WHERE cart.users_id = $users_id and cart.products_id=products.id and products_media.products_id=products.id;")
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
                <h1 class="h2 text-uppercase mb-0">Cart</h1>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item"><a href="index.php">Home </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <h2 class="h5 text-uppercase mb-4">Shopping cart</h2>
          <h2 class="h5 text-uppercase mb-4" id='empty'></h2>
          <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
              <div class="table-responsive mb-4">
                <table class="table" id="cart1">
                  <thead class="bg-light">
                    <tr>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Product</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Price</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Quantity</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
                      <th class="border-0" scope="col"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $subtotal=0;
                    while($rproducts=mysqli_fetch_array($products)){
                      $old_price = $rproducts["price"];
                        if (!empty($rproducts["salePercentage"])) {
                          $sale = 1 - $rproducts["salePercentage"] / 100;
                          $new_price = $rproducts["price"] * $sale;
                        } else {
                          $new_price = $rproducts["price"];
                        };

                      echo"<tr value=".$rproducts["id"]." price=".$new_price." id='row1'>
                      <th class='pl-0 border-0' scope='row'>
                      
                        <div class='media align-items-center'><a class='reset-anchor d-block animsition-link' href='detail.php?productid=" . base64_encode($rproducts["id"]) ."'><img src='".$rproducts["media_path"]."' alt='...' width='70'/></a>
                          <div class='media-body ml-3'><strong class='h6'><a class='reset-anchor animsition-link' href='detail.php?productid=" . base64_encode($rproducts["id"]) ."'>".$rproducts["name"]."</a></strong></div>
                        </div>
                        
                      </th>
                      <td class='align-middle border-0' id='itemprice'>
                        <p class='mb-0 small'>";
                        if ($old_price == $new_price) {
                          echo '$'.$new_price;
                        } else {
                          echo "<s>$" . $old_price . "</s> &nbsp &nbsp$" . $new_price;
                        }
                        echo"</p>
                      </td>
                      
                      <td class='align-middle border-0 qty'>";

                      echo "<p class='mb-0 small'>";
                        if ($rproducts["itemquantity"]>$rproducts["quantity"])
                        {
                          mysqli_query($con, "update cart set quantity=$rproducts[quantity] where users_id=$users_id and products_id = $rproducts[id]");
                          echo '<script>window.location="cart.php"</script>';
                        }
                      echo"<div class='quantity'>
                      <input type='number' min='1' max='".$rproducts["quantity"]."' step='1' value='".$rproducts["itemquantity"]."'>
                    </div>";
                         echo "</p>
                         
                       </td>";

                        $subtotalprod = $new_price*$rproducts["itemquantity"];
                        $subtotal= $subtotal + $subtotalprod;
                        echo"
                      <td class='align-middle border-0'>
                      <div id ='subtotal".$rproducts["id"]."'>
                        <p class='mb-0 small' id='subb".$rproducts["id"]."'>$".$subtotalprod."</p>
                        </div>
                      </td>
                      <td class='align-middle border-0'><a class='reset-anchor' href='#' value=".$rproducts["id"]."><i class='fas fa-trash-alt small text-muted trash'></i></a></td>
                    </tr>"
                    ;
                    }
                    ?>

                  </tbody>
                </table>

                <script>
                      var users_id = <?php echo $users_id?>;
                      $(document).ready(function(){




                        jQuery('<div class="quantity-nav"><button class="quantity-button quantity-up"><i class="fa fa-angle-up"></i></button><button class="quantity-button quantity-down"><i class="fa fa-angle-down"></i></button></div>').insertAfter('.quantity input');
                      jQuery('.quantity').each(function () {
                        var spinner = jQuery(this),
                            input = spinner.find('input[type="number"]'),
                            btnUp = spinner.find('.quantity-up'),
                            btnDown = spinner.find('.quantity-down'),
                            min = input.attr('min'),
                            max = input.attr('max');

                        btnUp.click(function () {
                          console.log($(this).closest('tr').attr('value'));
                          var id=$(this).closest('tr').attr('value');
                          var price=$(this).closest('tr').attr('price');
                          console.log(price);
                          var oldValue = parseFloat(input.val());
                          if (oldValue >= max) {
                            var newVal = oldValue;
                          } else {
                            var newVal = oldValue + 1;
                          }
                          spinner.find("input").val(newVal);
                          spinner.find("input").trigger("change");
                          //console.log(newVal);
                          $.ajax({
                            type: "POST",
                            url:'updatecart.php',
                            data:{
                              'quantity':newVal,
                              'id':id,
                            },
                            datatype: 'JSON',
                            success: function(data){

                              $('#subb'+id).text('$'+newVal*price);
                              $( "#sub1" ).load( "cart.php #sub1" );
                            }
                          })
                         });

                        btnDown.click(function () {
                          var id=$(this).closest('tr').attr('value');
                          var price=$(this).closest('tr').attr('price');
                          var oldValue = parseFloat(input.val());
                          if (oldValue <= min) {
                            var newVal = oldValue;
                          } else {
                            var newVal = oldValue - 1;
                          }
                          spinner.find("input").val(newVal);
                          spinner.find("input").trigger("change");
                          console.log(newVal);

                          $.ajax({
                            type: "POST",
                            url:'updatecart.php',
                            data:{
                              'quantity':newVal,
                              'id':id,
                            },
                            datatype: 'JSON',
                            success: function(data){
                              $('#subb'+id).text('$'+newVal*price);
                              $( "#sub1" ).load( "cart.php #sub1" );
                              // $( "#orderTotal" ).load( "cart.php #orderTotal" );
                            }
                          })
                        });
                      });
                      var rowCount = $('#cart1 tr').length ;
                      if (rowCount == 1){
                      $('#cart1').remove();
                      $('#empty').html('You do not have anything in your cart yet.');
                      $('#checkout').hide();
                      $('#orderTotal').hide();
                      }
                      $("#cart1").on('click','.trash',function(){
                      var row = $(this).closest('tr');

                      rowCount = $('#cart1 tr').length ;
                      if (rowCount == 1){
                      $('#cart1').remove();
                      $('#empty').html('You do not have anything in your cart yet.');
                      $('#checkout').hide();
                      $('#orderTotal').hide();
                      }
                      $.ajax({
                        type: "POST",
                        url: 'deletefromcart.php',
                        data: {
                          'users_id': users_id,
                          'products_id': $(this).closest('tr').attr('value'),
                        },
                        datatype: 'text',
                        success:function(data){
                         row.remove();
                          $( "#sub1" ).load( "cart.php #sub1" );
                          rowCount = $('#cart1 tr').length ;
                      console.log (rowCount);
                      if (rowCount == 1){
                      $('#cart1').remove();
                      $('#empty').html('You do not have anything in your cart yet.');
                      $('#checkout').hide();
                      $('#orderTotal').hide();
                      }
                        },
                        error:function(){

                        }
                      })

                    });
                      });

                    </script>
              </div>
              <!-- CART NAV-->
              <div class="bg-light px-4 py-3">
                <div class="row align-items-center text-center">
                  <div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href="shop.php"><i class="fas fa-long-arrow-alt-left mr-2"> </i>Continue shopping</a></div>
                  <div class="col-md-6 text-md-right"><a class="btn btn-outline-dark btn-sm" href="checkout.php" id='checkout'>Procceed to checkout<i class="fas fa-long-arrow-alt-right ml-2"></i></a></div>
                </div>
              </div>
            </div>
            <!-- ORDER TOTAL-->
            <div class="col-lg-4" id='orderTotal'>
              <div class="card border-0 rounded-0 p-lg-4 bg-light">
                <div class="card-body">
                  <h5 class="text-uppercase mb-4">Cart total</h5>
                  <ul class="list-unstyled mb-0">
                    <li class="border-bottom my-2"></li>
                    <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span><div id='sub1'>$<?php
                    echo $subtotal;
                    ?></div></span></li>

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
      <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
    </div>
  </body>
</html>
