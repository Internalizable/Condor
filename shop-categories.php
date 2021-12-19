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
	$result = mysqli_query($con, "SELECT * from products where isDeleted=0;");
	$media = mysqli_query($con, "select media_path as path from products,products_media where products.isDeleted=0  and products.id=products_media.products_id ");
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
     <!-- <div class="modal fade" id="productView?productid=$_GET[productid]" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="row align-items-stretch">
                <div class="col-lg-6 p-lg-0"><a class="product-view d-block h-100 bg-cover bg-center" style="background: url(img/product-5.jpg)" href="img/product-5.jpg" data-lightbox="productview" title="Red digital smartwatch"></a><a class="d-none" href="img/product-5-alt-1.jpg" title="Red digital smartwatch" data-lightbox="productview"></a><a class="d-none" href="img/product-5-alt-2.jpg" title="Red digital smartwatch" data-lightbox="productview"></a></div>
                <div class="col-lg-6">
                  <button class="close p-4" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <div class="p-5 my-md-4">
                    <ul class="list-inline mb-2">
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                    </ul>
                    <h2 class="h4">Red digital smartwatch</h2>
                    <p class="text-muted">$250</p>
                    <p class="text-small mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p>
                    <div class="row align-items-stretch mb-4">
                      <div class="col-sm-7 pr-sm-0">
                        <div class="border d-flex align-items-center justify-content-between py-1 px-3"><span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                          <div class="quantity">
                            <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control border-0 shadow-0 p-0" type="text" value="1">
                            <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-5 pl-sm-0"><a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="cart.html">Add to cart</a></div>
                    </div><a class="btn btn-link text-dark p-0" href="wishlist1.php"><i class="far fa-heart mr-2"></i>Add to wish list</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>-->
      <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Shop</h1>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <div class="container p-0">
            <div class="row">
              <!-- SHOP SIDEBAR-->
              <div class="col-lg-3 order-2 order-lg-1">
                <h5 class="text-uppercase mb-4">Categories</h5>
				<?php
				//require_once("conn.php");
				$result = mysqli_query($con, "SELECT name,id from categories where isDeleted=0 and parent_id is null");
				if (mysqli_num_rows($result) == false) {
				echo "<div class='py-2 px-4 bg-dark text-white mb-3 '/div>No results found";
				} else {
				while ($row = mysqli_fetch_array($result)) {
					//class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">
				echo "<div><strong class='small text-uppercase font-weight-bold'>";
				echo "<div class='py-2 px-4 bg-dark text-white mb-3 '/div>".$row["name"];
				echo "</strong></div></div>";
				$result1=mysqli_query($con, "SELECT name,id from categories where parent_id=$row[id] and isDeleted=0");
				while ($row1 = mysqli_fetch_array($result1)){
					echo "<ul class='list-unstyled small text-muted pl-lg-4 font-weight-normal'>
                  <li class='mb-2'><a class='reset-anchor' href='shop-categories.php?categorie_id=".$row1['id']."'>";
				  echo "<li class='mb-2 '/ul>".$row1["name"];
				  echo"</a></li>
                </ul>";
				}
				}
				}
				?>
                <!--<h6 class="text-uppercase mb-4">Price range</h6>
                <div class="price-range pt-4 mb-5">
                  <div id="range"></div>
                  <div class="row pt-2">
                    <div class="col-6"><strong class="small font-weight-bold text-uppercase">From</strong></div>
                    <div class="col-6 text-right"><strong class="small font-weight-bold text-uppercase">To</strong></div>
                  </div>
                </div>
                <h6 class="text-uppercase mb-3">Show only</h6>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck1" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck1">Returns Accepted</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck2" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck2">Returns Accepted</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck3" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck3">Completed Items</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck4" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck4">Sold Items</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck5" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck5">Deals &amp; Savings</label>
                </div>
                <div class="custom-control custom-checkbox mb-4">
                  <input class="custom-control-input" id="customCheck6" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck6">Authorized Seller</label>
                </div>
                <h6 class="text-uppercase mb-3">Buying format</h6>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio1">All Listings</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio2" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio2">Best Offer</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio3" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio3">Auction</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio4" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio4">Buy It Now</label>
                </div>-->
              </div>
              <!-- SHOP LISTING-->
              <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row mb-3 align-items-center">
                  <div class="col-lg-6 mb-2 mb-lg-0">
                    <p class="text-small text-muted mb-0">Showing
					<?php
					if (!isset($_GET['screen'])){
						$_GET['screen'] = 1;
						}
					if (isset($_GET['screen'])){
					$screen = $_GET['screen'];
					$rows_per_page = 6;
					$result2 = mysqli_query($con, "SELECT * FROM products where isDeleted=0");
					$total_records = mysqli_num_rows($result2);
					$pages = ceil($total_records / $rows_per_page);
					mysqli_free_result($result2);
					$start = ($screen-1) * $rows_per_page;
					echo ($screen*$rows_per_page)-$rows_per_page+1;
					}
					?>–<?php
					//require_once("conn.php");
				$result = mysqli_query($con, "SELECT count(*) as total1 from products_categories where categories_id=".$_GET['categorie_id']."");
				if (mysqli_num_rows($result) == false) {
				echo "error";
				} else {
				while ($row = mysqli_fetch_array($result)) {
				echo " ".$row["total1"]." products";
					}
				}
						?> of
					<?php
				//require_once("conn.php");
				$result = mysqli_query($con, "SELECT count(*) as total1 from products where isDeleted=0");
				if (mysqli_num_rows($result) == false) {
				echo "error";
				} else {
				while ($row = mysqli_fetch_array($result)) {
				echo " ".$row["total1"]." products";
					}
				}
				?>
					</p>
                  </div>
                  <!--<div class="col-lg-6">
                    <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                      <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th-large"></i></a></li>
                      <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th"></i></a></li>
                      <li class="list-inline-item">
                        <select class="selectpicker ml-auto" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                          <option value="default">Default sorting</option>
                          <option value="popularity">Popularity</option>
                          <option value="low-high">Price: Low to High</option>
                          <option value="high-low">Price: High to Low</option>
                        </select>
                      </li>
                    </ul>
                  </div>-->
                </div>
                <div class="row">
                  <!-- PRODUCT-->
				   <?php
					  //require_once("conn.php");
					  $result = mysqli_query($con, "SELECT * from products where isDeleted=0");
							if (mysqli_num_rows($result) == false) {
							echo "Error there's no products!";
							} else {
						$rows_per_page = 6;
						$result2 = mysqli_query($con, "SELECT * FROM products where isDeleted=0");
						$total_records = mysqli_num_rows($result2);
						$pages = ceil($total_records / $rows_per_page);
						mysqli_free_result($result2);
						//$id=$_GET['productid'];
						if (mysqli_num_rows($result) == false) {
						echo "Error there's no products!";
						} else {

						if (!isset($_GET['screen'])){
						$_GET['screen'] = 1;
						}
						if (isset($_GET['screen'])){
						$screen = $_GET['screen'];
						$cat=$_GET['categorie_id'];
						$start = ($screen-1) * $rows_per_page;
						$sql = "SELECT * FROM products,products_categories where  products.isDeleted=0 and products_categories.categories_id=$cat and products.id=products_categories.products_id  LIMIT $start, $rows_per_page ";
						//$sql1 = "SELECT products_id FROM products_categories LIMIT $start, $rows_per_page where categories_id=$cat";
						$r1 = mysqli_query($con, $sql);
						$rows = mysqli_num_rows($r1);
						$media = mysqli_query($con, "select media_path as path from products,products_media,products_categories where products.isDeleted=0 and products.id=products_categories.products_id and products_categories.categories_id=$cat and products.id=products_media.products_id  LIMIT $start, $rows_per_page");
						for ($i = 0; $i < $rows; $i++){
							while ($row = mysqli_fetch_array($r1)) {
								$rmedia= mysqli_fetch_array($media);
								echo "<div class='col-lg-4 col-sm-6'>
								<div class='product text-center'>
								<div class='mb-3 position-relative'>
								<div class='badge text-white badge-'></div><a class='d-block' href='detail.php?productid=" . base64_encode($row["id"]) ."'><img class='img-fluid w-100' src='" . $rmedia["path"] . "' alt='photo'></a>
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
							}
							echo "</div>";
							}
				 /* echo "<div class='modal fade' id='productView" . $row["id"] ."' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-lg modal-dialog-centered' role='document'>
          <div class='modal-content'>
            <div class='modal-body p-0'>
				<div class='row align-items-stretch'>
                <div class='col-lg-6 p-lg-0'><a class='product-view d-block h-100 bg-cover bg-center' style='background: url(img/product-5.jpg)' href='img/product-5.jpg' data-lightbox='productview' title='Red digital smartwatch'></a><a class='d-none' href='img/product-5-alt-1.jpg' title='Red digital smartwatch' data-lightbox='productview'></a><a class='d-none' href='img/product-5-alt-2.jpg' title='Red digital smartwatch' data-lightbox='productview'></a></div>
                <div class='col-lg-6'>
                  <button class='close p-4' type='button' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
                  <div class='p-5 my-md-4'>
                    <ul class='list-inline mb-2'>
                      <li class='list-inline-item m-0'><i class='fas fa-star small text-warning'></i></li>
                      <li class='list-inline-item m-0'><i class='fas fa-star small text-warning'></i></li>
                      <li class='list-inline-item m-0'><i class='fas fa-star small text-warning'></i></li>
                      <li class='list-inline-item m-0'><i class='fas fa-star small text-warning'></i></li>
                      <li class='list-inline-item m-0'><i class='fas fa-star small text-warning'></i></li>
                    </ul>
                    <h2 class='h4'>Red digital smartwatch</h2>
                    <p class='text-muted'>$250</p>
                    <p class='text-small mb-4'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p>
                    <div class='row align-items-stretch mb-4'>
                      <div class='col-sm-7 pr-sm-0'>
                        <div class='border d-flex align-items-center justify-content-between py-1 px-3'><span class='small text-uppercase text-gray mr-4 no-select'>Quantity</span>
                          <div class='quantity'>
                            <button class='dec-btn p-0'><i class='fas fa-caret-left'></i></button>
                            <input class='form-control border-0 shadow-0 p-0' type='text' value='1'>
                            <button class='inc-btn p-0'><i class='fas fa-caret-right'></i></button>
                          </div>
                        </div>
                      </div>
                      <div class='col-sm-5 pl-sm-0'><a class='btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0' href'cart.html'>Add to cart</a></div>
                    </div><a class='btn btn-link text-dark p-0' href='wishlist1.php'><i class='far fa-heart mr-2'></i>Add to wish list</a>
                  </div>
                </div>
              </div>
            </div>
			</div>
          </div>
        </div>
      </div>";*/
							}
							}
					  ?>

                  <!--<div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.php"><img class="img-fluid w-100" src="img/product-1.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Kui Ye Chen’s AirPods</a></h6>
                      <p class="small text-muted">$250</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                 <!-- <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-2.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Air Jordan 12 gym red</a></h6>
                      <p class="small text-muted">$300</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                  <!--<div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-primary">New</div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-3.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Cyan cotton t-shirt</a></h6>
                      <p class="small text-muted">$25</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                 <!-- <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-4.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Timex Unisex Originals</a></h6>
                      <p class="small text-muted">$351</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                 <!-- <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-info">Sale</div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-5.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Red digital smartwatch</a></h6>
                      <p class="small text-muted">$250</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                 <!-- <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-6.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Nike air max 95</a></h6>
                      <p class="small text-muted">$300</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                  <!--<div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-7.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Joemalone Women prefume</a></h6>
                      <p class="small text-muted">$25</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                <!--  <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-8.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Apple Watch</a></h6>
                      <p class="small text-muted">$351</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                 <!-- <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-danger">Sold</div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-9.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Men silver Byron Watch</a></h6>
                      <p class="small text-muted">$351</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                 <!-- <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-primary">New</div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-10.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Ploaroid one step camera</a></h6>
                      <p class="small text-muted">$351</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                  <!--<div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-11.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Gray Nike running shoes</a></h6>
                      <p class="small text-muted">$351</p>
                    </div>
                  </div>
                  <!-- PRODUCT-->
                  <!--<div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div><a class="d-block" href="detail.html"><img class="img-fluid w-100" src="img/product-12.jpg" alt="..."></a>
                        <div class="product-overlay">
                          <ul class="mb-0 list-inline">
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#"><i class="far fa-heart"></i></a></li>
                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a></li>
                            <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">Black DSLR lense</a></h6>
                      <p class="small text-muted">$351</p>
                    </div>
                  </div>
                </div> -->
                <!-- PAGINATION-->
                <?php
				echo "<nav aria-label='Page navigation example'>
				<ul class='pagination justify-content-center justify-content-lg-end'>";
				if ($screen != 1) {
		echo "<li class='page-item'><a class='page-link' href='shop.php?screen=1'>First</a></li>";
	}
	if ($screen > 1) {
	  echo "<li class='page-item'><a class='page-link' href='shop.php?screen=" . ($screen - 1) . "' aria-label='Previous'>«</a></li> ";
	}
	if ($screen < 3) {
		for($i = 1; $i<6; $i++){
			if($screen == $i){
				echo "<li class='page-item'><a class='page-link'><b>$i</b></a><li>";
			} else if ($i <= $pages){
				echo " <li class='page-item'><a class='page-link' href='shop.php?screen=" . $i . "'>$i</a></li> ";
			}
		}
	} else {
		for($i = $screen-2; $i<$screen+3; $i++){
			if($screen == $i){
				echo "<li class='page-item'><a class='page-link'><b>$i</b></a><li>";
			} else if ($i <= $pages){
				echo " <li class='page-item'><a class='page-link' href='shop.php?screen=" . $i . "'>$i</a></li> ";
			}
		}
	}
	if ($screen < $pages) {
	  echo "<li class='page-item'><a class='page-link' href='shop.php?screen=" . ($screen + 1) . "' aria-label='Next'>»</a></li>  ";
	}
	if ($screen != $pages) {
		echo "<li class='page-item'><a class='page-link' href='shop.php?screen=" . $pages . "'> Last</a></li> ";
	}
	echo "</ul></nav>";
	?>
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
      <!-- Nouislider Config-->
      <script>
        var range = document.getElementById('range');
        noUiSlider.create(range, {
            range: {
                'min': 0,
                'max': 2000
            },
            step: 5,
            start: [100, 1000],
            margin: 300,
            connect: true,
            direction: 'ltr',
            orientation: 'horizontal',
            behaviour: 'tap-drag',
            tooltips: true,
            format: {
              to: function ( value ) {
                return '$' + value;
              },
              from: function ( value ) {
                return value.replace('', '');
              }
            }
        });

      </script>
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
