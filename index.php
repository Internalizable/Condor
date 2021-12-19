<?php 
require_once("controllers/database/connection.php");
	  
$con = openCon();
session_start();

if (!isset($_SESSION['id']))
$userid=-1;
else $userid=$_SESSION['id'];
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
      <?php 
	  //require_once("conn.php");
	$result = mysqli_query($con, "SELECT * from products where isDeleted=0 order by dateAdded desc");
	$media = mysqli_query($con, "select media_path as path from products_media, products where products.isDeleted=0 and products.id=products_media.products_id order by products.dateAdded desc");		
	//$id=$_GET['productid'];
	if (mysqli_num_rows($result) == false) {
	echo "Error there's no products!";
	} else {
	while ($row = mysqli_fetch_array($result) and $rmedia= mysqli_fetch_array($media)) {
	$rating = mysqli_query($con, "select avg(rating) as avgrating from reviews join products on products.id=reviews.products_id where products.id=$row[id]");
    $rrating = mysqli_fetch_array($rating)["avgrating"];
	echo "<div class='modal fade' id='productView".$row['id']."' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-lg modal-dialog-centered' role='document'>
          <div class='modal-content'>
            <div class='modal-body p-0'>
				<div class='row align-items-stretch'>
                <div class='col-lg-6 p-lg-0'><a class='product-view d-block h-100 bg-cover bg-center' style='background: url(".$rmedia['path'].")' href='".$rmedia['path']."' data-lightbox='productview' title='".$row['name']."'></a><a class='d-none' href='".$rmedia['path']."' title='".$row['name']."' data-lightbox='productview'></a></div>
                <div class='col-lg-6'>
                  <button class='close p-4' type='button' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
                  <div class='p-5 my-md-4'>
                    <ul class='list-inline mb-2'>";
              $i = 0;
              for ($x = 1; $x <= $rrating; $x++) {
                echo "<li class='list-inline-item m-0'><i class='fas fa-star text-warning'></i></li>";
                $i++;
              }
              if (fmod($rrating, 1.0) != 0) {
                echo "<li class='list-inline-item m-0'><i class='fas fa-star-half-alt text-warning'></i></li>";
                $i++;
              }
              while ($i < 5) {
                echo "<li class='list-inline-item m-0'><i class='far fa-star text-warning'></i></li>";
                $i++;
              }
                    echo"</ul>
                    <h2 class='h4'>".$row["name"]."</h2>
                    <p class='text-muted'>$".$row["price"]."</p>
                    <p class='text-small mb-4'>".$row["description"]."</p>
                    <div class='row align-items-stretch mb-4'>
                      <div class='col-sm-7 pr-sm-0'>
                      </div>
                    </div><a class='btn btn-link text-dark p-0' href='add-to-wishlist.php?productid=".base64_encode($row['id'])."'><i class='far fa-heart mr-2'></i>Add to wish list</a>
                  </div>
                </div
              </div>
            </div>
			</div>
          </div>
        </div>
      </div>";
	}
	}
	  ?>
      <!-- HERO SECTION-->
      <div class="container">
        <section class="hero pb-3 bg-cover bg-center d-flex align-items-center" style="background: url(img/front/hero-banner-alt.jpg)">
          <div class="container py-5">
            <div class="row px-4 px-lg-5">
              <div class="col-lg-6">
                <p class="text-muted small text-uppercase mb-2">New Inspiration 2021</p>
                <h1 class="h2 text-uppercase mb-3">20% off on new season</h1><a class="btn btn-dark" href="shop.php">Browse collections</a>
              </div>
            </div>
          </div>
        </section>
        <!-- CATEGORIES SECTION-->
        <section class="pt-5">
          <header class="text-center">
            <p class="small text-muted small text-uppercase mb-1">Carefully created collections</p>
            <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
          </header>
          <div class="row">
		  <?php
            echo "<div class='col-md-4 mb-4 mb-md-0'><a class='category-item' href='shop-categories.php?categorie_id=4'><img class='img-fluid' src='img/front/cat-img-1.jpg' alt='Photo'><strong class='category-item-title'>Category 1-1</strong></a></div>
            <div class='col-md-4 mb-4 mb-md-0'><a class='category-item mb-4' href='shop-categories.php?categorie_id=7'><img class='img-fluid' src='img/front/cat-img-2.jpg' alt='photo'><strong class='category-item-title'>Category 2-1</strong></a><a class='category-item' href='shop-categories.php?categorie_id=5'><img class='img-fluid' src='img/front/cat-img-3.jpg' alt='photo'><strong class='category-item-title'>Category 1-2</strong></a></div>
            <div class='col-md-4'><a class='category-item' href='shop-categories.php?categorie_id=10'><img class='img-fluid' src='img/front/cat-img-4.jpg' alt='photo'><strong class='category-item-title'>Category 3-1</strong></a></div>";
          ?>
		  </div>
        </section>
        <!-- TRENDING PRODUCTS-->
        <section class="py-5">
          <header>
            <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
            <h2 class="h5 text-uppercase mb-4">Newest products</h2>
          </header>
          <div class="row">
            <!-- PRODUCT-->
			<?php
				//require_once("conn.php");
					  $result = mysqli_query($con, "SELECT * from products where isDeleted=0");		
							if (mysqli_num_rows($result) == false) {
							echo "Error there's no products!";
							} else {
						$rows_per_page = 8;	
						$sql = "SELECT * FROM products where isDeleted=0 order by dateAdded desc LIMIT $rows_per_page";
						$r1 = mysqli_query($con, $sql);
						$media = mysqli_query($con, "select media_path as path from products_media, products where products.isDeleted=0 and products.id=products_media.products_id order by products.dateAdded desc LIMIT $rows_per_page");
							while ($row = mysqli_fetch_array($r1)) {
								$rmedia= mysqli_fetch_array($media);
								echo "<div class='col-xl-3 col-lg-4 col-sm-6'>
								<div class='product text-center'>
								<div class='mb-3 position-relative'>
								<div class='badge text-white badge-'></div><a class='d-block' href='detail.php?productid=" .base64_encode($row["id"]) ."'><img class='img-fluid w-100' src='" . $rmedia["path"] . "' alt='photo'></a>
								<div class='product-overlay'>
								<ul class='mb-0 list-inline'>
								<li class='list-inline-item m-0 p-0'><a class='btn btn-sm btn-outline-dark' href='add-to-wishlist.php?productid=".base64_encode($row['id'])."'><i class='far fa-heart'></i></a></li>
								
								<li class='list-inline-item mr-0'><a  class='btn btn-sm btn-outline-dark' href='#productView".$row['id']."' data-toggle='modal'><i class='fas fa-expand'></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class='reset-anchor' href='detail.php?productid=" . base64_encode($row["id"]) ."'>".$row['name']."</a></h6>
                      <p class='small text-muted'>$".$row['price']."</p>
                    </div>
                  </div>
				  ";
							}
							echo "</div>";
							}
			?>
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row text-center">
              <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="d-inline-block">
                  <div class="media align-items-end">
                    <svg class="svg-icon svg-icon-big svg-icon-light">
                      <use xlink:href="#delivery-time-1"> </use>
                    </svg>
                    <div class="media-body text-left ml-3">
                      <h6 class="text-uppercase mb-1">Free shipping</h6>
                      <p class="text-small mb-0 text-muted">Free shipping worlwide</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="d-inline-block">
                  <div class="media align-items-end">
                    <svg class="svg-icon svg-icon-big svg-icon-light">
                      <use xlink:href="#helpline-24h-1"> </use>
                    </svg>
                    <div class="media-body text-left ml-3">
                      <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                      <p class="text-small mb-0 text-muted">Free shipping worlwide</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="d-inline-block">
                  <div class="media align-items-end">
                    <svg class="svg-icon svg-icon-big svg-icon-light">
                      <use xlink:href="#label-tag-1"> </use>
                    </svg>
                    <div class="media-body text-left ml-3">
                      <h6 class="text-uppercase mb-1">Festival offer</h6>
                      <p class="text-small mb-0 text-muted">Free shipping worlwide</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- NEWSLETTER-->
     
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