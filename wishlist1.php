<?php 
require_once("controllers/database/connection.php");
	  
$con = openCon();

session_start();

if (!isset($_SESSION['id'])){
	header('location: user/login');
	exit;
}
$userid=$_SESSION['id'];
?>
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
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
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
                if($userid == -1) {
              ?>
              <li class="nav-item"><a class="nav-link" href="user/login.php"> <i class="fas fa-user-alt mr-1 text-gray"></i>Login</a></li>
              <?php } 
              else {
                echo "<li class='nav-item'><a class='nav-link' href='cart.php'> <i class='fas fa-dolly-flatbed mr-1 text-gray'></i>Cart<small class='text-gray'></small></a></li>
                <li class='nav-item'><a class='nav-link' href='wishlist1.php'> <i class='far fa-heart mr-1'></i><small class='text-gray'>";
				$resultss = mysqli_query($con, "SELECT count(*) as total from wishlist where users_id='$userid'");
				if (mysqli_num_rows($resultss) == false) {
				echo "(0)";
				} else {
				while ($row = mysqli_fetch_array($resultss)) {
				echo "(".$row["total"].")";
					}
				}
				echo "</small></a></li>";
                echo "

                <li class='nav-item dropdown'><a class='nav-link dropdown-toggle' id='pagesDropdown' href='#' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-user-alt mr-1 text-gray'></i></a>
                  <div class='dropdown-menu mt-3' aria-labelledby='pagesDropdown'><a class='dropdown-item border-0 transition-link' href='user/profile.php?id=".base64_encode($userid)."'>User Profile</a>
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
      <!--  Modal -->
      <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Wish list</h1>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wish list</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <h2 class="h5 text-uppercase mb-4">Liked Product(s)</h2>
          <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
              <!-- CART TABLE-->
              <div class="table-responsive mb-4">
                <table class="table">
                  <!--<thead class="bg-light">
                    <tr>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Product</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Price</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Quantity</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
                      <th class="border-0" scope="col"> </th>
                    </tr>
                  </thead>-->
				  <?php 
					  //require_once("conn.php");
					  $result = mysqli_query($con, "SELECT * from wishlist where users_id='$userid'");
					  $rresult=mysqli_fetch_array($result);
					  $product = mysqli_query($con, "SELECT * from products where isDeleted=0");
					  $rproduct=mysqli_fetch_array($product);
					  $media = mysqli_query($con, "select  media_path as path, products.name from products,products_media,wishlist where products.isDeleted=0 and products_media.products_id=wishlist.products_id and products.id=wishlist.products_id and wishlist.users_id=$userid");
					 // $rmedia = mysqli_fetch_array($media);
					  $quantity = $rproduct["quantity"];
					  $sale = 1 - $rproduct["salePercentage"] / 100;
				?>
                  <tbody>
                    <tr>
                      <th class="pl-0 border-0" scope="row">
                        <!--<div class="media align-items-center"><a class="reset-anchor d-block animsition-link" href="detail.php"><img src="' . $rmedia_products['path'] . '" alt="photo" width="70"/></a>
                          <div class="media-body ml-3"><strong class="h6"><a class="reset-anchor animsition-link" href="detail.php">
							<?php
							/*require_once("conn.php");
							$result = mysqli_query($con, "SELECT products.name from products,wishlist where products.id=wishlist.products_id and wishlist.users_id=1 ");
							if (mysqli_num_rows($result) == false) {
							echo "No results found";
							} else {
							while ($row1 = mysqli_fetch_array($result)) {
							echo "<div class='media-body ml-3'><strong class='h6'><a class='reset-anchor animsition-link' href='detail.php'>".$row1["name"]."</a></strong></div>";
							echo "<br>";
								}
							}*/
							?>
						  </a></strong></div>
                        </div>
                      </th>
                      <td class="align-middle border-0">
                        <p class="mb-0 small">
						<?php
							/*require_once("conn.php");
							$result = mysqli_query($con, "SELECT products.price from products,wishlist where products.id=wishlist.products_id and wishlist.users_id=1 ");
							if (mysqli_num_rows($result) == false) {
							echo "No results found";
							} else {
							while ($row2 = mysqli_fetch_array($result)) {
							echo "<p class='mb-0 small'>$".$row2["price"]."</p>";
							echo "<br>";
								}
							}
							*/?>
						</p>
                      </td>
                      <td class="align-middle border-0">
					  <?php
							/*require_once("conn.php");
							$result = mysqli_query($con, "SELECT products.price from products,wishlist where products.id=wishlist.products_id and wishlist.users_id=1 ");
							if (mysqli_num_rows($result) == false) {
							echo "No results found";
							} else {
							while ($row3 = mysqli_fetch_array($result)) {
							echo "<div class='border d-flex align-items-center justify-content-between px-3'><span class='small text-uppercase text-gray headings-font-family'>Quantity</span>
                          <div class='quantity'>
                            <button class='dec-btn p-0'><i class='fas fa-caret-left'></i></button>
                            <input class='form-control form-control-sm border-0 shadow-0 p-0' type='text' value='1' name='quantity' id='quantity'/>
                            <button class='inc-btn p-0'><i class='fas fa-caret-right'></i></button>
                          </div>
                        </div>";
							echo "<br>";
								}
							}(*/
							?>
           
                      </td>
                      <td class="align-middle border-0">
                        <p class="mb-0 small">
						<?php
							/*require_once("conn.php");
							$result = mysqli_query($con, "SELECT products.price from products,wishlist where products.id=wishlist.products_id and wishlist.users_id=1 ");
							if (mysqli_num_rows($result) == false) {
							echo "No results found";
							} else {
							while ($row4 = mysqli_fetch_array($result)) {
							$row4["price"]=$row4["price"] * $sale;
							//$total=$row["price"]*$_POST[quantity];
							echo "<p class='mb-0 small'>$".$row4["price"]."</p>";
							echo "<br>";
								}
							}*/
							?>
						</p>
                      </td>
                      <td class="align-middle border-0">
					  <?php
							/*require_once("conn.php");
							$result = mysqli_query($con, "SELECT products.price from products,wishlist where products.id=wishlist.products_id and wishlist.users_id=1 ");
							if (mysqli_num_rows($result) == false) {
							echo "No results found";
							} else {
							while ($row5 = mysqli_fetch_array($result)) {
							echo "<a class='reset-anchor' href='#'><i class='fas fa-trash-alt small text-muted'></i></a>";
							echo "<br>";
								}
							}*/
							?>
					  </td>
                    </tr>-->
                    <!--<tr>
                      <th class="pl-0 border-light" scope="row">
                        <div class="media align-items-center"><a class="reset-anchor d-block animsition-link" href="detail.html"><img src="img/product-detail-2.jpg" alt="..." width="70"/></a>
                          <div class="media-body ml-3"><strong class="h6"><a class="reset-anchor animsition-link" href="detail.html">Apple watch</a></strong></div>
                        </div>
                      </th>
                      <td class="align-middle border-light">
                        <p class="mb-0 small">$250</p>
                      </td>
                      <td class="align-middle border-light">
                        <div class="border d-flex align-items-center justify-content-between px-3"><span class="small text-uppercase text-gray headings-font-family">Quantity</span>
                          <div class="quantity">
                            <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control form-control-sm border-0 shadow-0 p-0" type="text" value="1"/>
                            <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle border-light">
                        <p class="mb-0 small">$250</p>
                      </td>
                      <td class="align-middle border-light"><a class="reset-anchor" href="#"><i class="fas fa-trash-alt small text-muted"></i></a></td>
                    </tr>-->
					<?php 
					  //require_once("conn.php");
					  $result = mysqli_query($con, "SELECT * from wishlist where users_id='$userid'");
					  $result1 = mysqli_query($con, "SELECT products.name from products,wishlist where products.isDeleted=0 and products.id=wishlist.products_id and wishlist.users_id=$userid ");
					  //$row1 = mysqli_fetch_array($result1);
					  $result2 = mysqli_query($con, "SELECT products.price from products,wishlist where products.isDeleted=0 and products.id=wishlist.products_id and wishlist.users_id=$userid ");
					  //$row2 = mysqli_fetch_array($result2);
					  $result3 = mysqli_query($con, "SELECT products.id from products,wishlist where products.isDeleted=0 and products.id=wishlist.products_id and wishlist.users_id=$userid ");
					  $result4 = mysqli_query($con, "SELECT products.price from products,wishlist where products.isDeleted=0 and products.id=wishlist.products_id and wishlist.users_id=$userid ");
					  //$row4 = mysqli_fetch_array($result4);
					  //$row4["price"]=$row4["price"] * $sale;
					  if(mysqli_num_rows($result) == 0) {
					  echo "<br>No results found.";
					  } else {
						  echo "<table class='table'><thead class='bg-light'>
							<tr>
							  <th class='border-0' scope='col'> <strong class='text-small text-uppercase'>Product</strong></th>
							  <th class='border-0' scope='col'> <strong class='text-small text-uppercase'>Initial Price</strong></th>
							  <th class='border-0' scope='col'> <strong class='text-small text-uppercase'>Final Price</strong></th>
							  <th class='border-0' scope='col'> </th>
							</tr>
						</thead>";
						while($row = mysqli_fetch_array($result)) {	
							while($row1 = mysqli_fetch_array($result1) and $row2 = mysqli_fetch_array($result2) and $row4 = mysqli_fetch_array($result4) and $rmedia = mysqli_fetch_array($media) and $row3 = mysqli_fetch_array($result3)){
							$row4["price"]=$row4["price"] * $sale;
							echo "<tbody>
							<tr>
							<th class='pl-0 border-light' scope='row'>
							<div class='media align-items-center'><a class='reset-anchor d-block animsition-link' href='detail.php?productid=". base64_encode($row3["id"]) ."'><img src='". $rmedia['path'] ."' alt='photo' width='70'/></a>
							<div class='media-body ml-3'><strong class='h6'><a class='reset-anchor animsition-link' href='detail.php?productid=". base64_encode($row3["id"]) ."'><div class='media-body ml-3'>
							<strong class='h6'><a class='reset-anchor animsition-link' href='detail.php?productid=". base64_encode($row3["id"]) ."'>".$row1["name"]."</a></div>
							<td class='align-middle border-light'><p class='mb-0 small'>$".$row2["price"]."</p></td>
							
							<td class='align-middle border-light'><p class='mb-0 small'>$".$row4["price"]."</p>
							</td>
							<td class='align-middle border-light'><a class='reset-anchor' href='remove-from-wishlist.php?productid=" . base64_encode($row3["id"]) ."'><i class='fas fa-trash-alt small text-muted' name='delete_button'></i></a>
							</td>
							</tr>
							</tbody>";
						}
						}
						echo "</table>";
						}
				?>
                  </tbody>
                </table>
              </div>
              <!-- CART NAV-->
              <div class="bg-light px-4 py-3">
                <div class="row align-items-center text-center">
                  <div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href="shop.php"><i class="fas fa-long-arrow-alt-left mr-2"> </i>Continue shopping</a></div>
                </div>
              </div>
            </div>
            <!-- ORDER TOTAL-->
            <div class="col-lg-4">
              <div class="card border-0 rounded-0 p-lg-4 bg-light">
                <div class="card-body">
                  <h5 class="text-uppercase mb-4">List total</h5>
                  <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Initial Total</strong><span class="text-muted small">
					<?php 
					  //require_once("conn.php");
					  $result = mysqli_query($con, "SELECT sum(products.price) as total from products,wishlist where products.isDeleted=0 and products.id=wishlist.products_id and wishlist.users_id='$userid' ");
					  $row = mysqli_fetch_array($result);
					  echo $row["total"];
					  ?>
					</span></li>
                    <li class="border-bottom my-2"></li>
                    <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span>
					<?php 
					 // require_once("conn.php");
					  $total=0;
					  $result = mysqli_query($con, "SELECT products.price from products,wishlist where products.isDeleted=0 and products.id=wishlist.products_id and wishlist.users_id='$userid' ");
							if (mysqli_num_rows($result) == false) {
							echo "$0";
							} else {
							while ($row = mysqli_fetch_array($result)) {
							$row["price"]=$row["price"] * $sale;
							$total=$total+$row["price"];
							}
							echo $total;
							}
							
					  ?>
					</span></li>
                    <!--<li>
                      <form action="#">
                        <div class="form-group mb-0">
                          <input class="form-control" type="text" placeholder="Enter your coupon">
                          <button class="btn btn-dark btn-sm btn-block" type="submit"> <i class="fas fa-gift mr-2"></i>Apply coupon</button>
                        </div>
                      </form>
                    </li>-->
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