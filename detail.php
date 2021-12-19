<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Boutique</title>
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
  <!-- Tweaks for older IEs-->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  <script src="js/jquery-3.1.0.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

</head>
<style>
  .inactiveLink {
    pointer-events: none;
    cursor: default;
  }
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

<body>
  <?php
  //session_start();
  date_default_timezone_set("Asia/Beirut");
  $id = base64_decode($_GET["productid"]);
  //$users_id=1;
  include("controllers/database/connection.php");
  $con=openCon();
  session_start();
  if (!isset($_SESSION['id']))
  $users_id=-1;
  else $users_id=$_SESSION['id'];
  $product = mysqli_query($con, "select * from products where id=$id");
  if (mysqli_num_rows($product) == false) {
  } else {
    $rproduct = mysqli_fetch_array($product);
    $quantity = $rproduct["quantity"];

    $category = mysqli_query(
      $con,
      "select name, id from categories join products_categories on categories.id= products_categories.categories_id where products_categories.products_id = $id"
    );
    $rcategory = mysqli_fetch_array($category);
    $product_category = $rcategory["id"];


    $tags = mysqli_query(
        $con,
        "select tags_tag from products_tags where products_id=$id"
      );

    $reviews = mysqli_query(
      $con,
      "select users.firstname, users.lastname, users.profile_path, reviews.* from users join reviews on reviews.users_id=users.id where reviews.products_id=$id order by reviews.reviewDate desc
      "
    );


    $media = mysqli_query($con, "select media_path, products.name from products,products_media where products_media.products_id=$id and products.id=$id");

    //most reviewed
    $related_products = mysqli_query($con, "select * from products, products_media, products_categories where products.id= products_categories.products_id and products_categories.categories_id = $product_category and products.id<>$id and products_media.products_id=products.id and products.quantity<>0  order by products.price asc  limit 4");

    $rating = mysqli_query($con, "select avg(rating) as avgrating from reviews join products on products.id=reviews.products_id where products.id=$id;");
    $rrating = mysqli_fetch_array($rating)["avgrating"];

    $isbought = mysqli_query(
      $con,		"select ordersid from orders where users_id=$users_id AND products_id=$id"
    );
  }
  ?>
  <div class="page-holder bg-light">
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
                <li class='nav-item'><a class='nav-link' href='wishlist1.php'> <i class='far fa-heart mr-1'></i><small class='text-gray'>";
				$resultss = mysqli_query($con, "SELECT count(*) as total from wishlist where users_id='$users_id'");
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
    <section class="py-5">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-6">
            <div class="row m-sm-0">
              <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0">
                <div class="owl-thumbs d-flex flex-row flex-sm-column" data-slider-id="1">
                  <?php
                  $media_count = mysqli_num_rows($media);

                  while ($rmedia = mysqli_fetch_array($media)) {
                    $i = 0;
                    if ($i != $media_count - 1) {
                      echo "<div class='owl-thumb-item flex-fill mb-2 mr-2 mr-sm-0'><img class='w-100' src='" . $rmedia["media_path"] . "' alt='...'></div>";
                    } else
                      echo "<div class='owl-thumb-item flex-fill mb-2'><img class='w-100' src='" . $rmedia["media_path"] . "' alt='...'></div> ";
                  }

                  ?>
                </div>
              </div>
              <div class="col-sm-10 order-1 order-sm-2">
                <div class="owl-carousel product-slider" data-slider-id="1">

                  <?php
                  mysqli_data_seek($media, 0);
                  while ($rmedia2 = mysqli_fetch_array($media)) {
                    echo "<a class='d-block' href='" . $rmedia2["media_path"] . "' data-lightbox='product' title='" . $rmedia2["name"] . "'>
                  <img class='img-fluid' src='" . $rmedia2["media_path"] . "' alt='...'></a>";
                  };

                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="list-inline mb-2">
              <?php
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
              ?>
            </ul>
            <h1><?php
                echo $rproduct["name"];

                $date_1 = $rproduct["dateAdded"];
                $date1 = date_create($date_1);
                $date_2 = new DateTime();
                $date_2->modify('-' . 14 . ' day');
                $date2 = $date_2->format('Y/m/d H:i:s');

                $diff = date_diff($date_2, $date1);
                //  echo $diff->format("%R%a");

                if ($diff->format("%R%a") <= 14 && $diff->format("%R%a") >= 0) {
                  echo "<span><b><i>&nbsp &nbsp &nbsp &nbspNewly Added!</b></i></span>";
                }

                if ($quantity == 0) {
                  echo "<span style='color:red'><b><i>&nbsp &nbsp &nbsp &nbspSold Out!</b></i></span>";
                }
                ?></h1>
            <p class="text-muted lead">
              $<?php if (
                  ($rproduct["salePercentage"]!=0)
                ) {
                  $sale = 1 - $rproduct["salePercentage"] / 100;
                  echo "<s>" .
                    $rproduct["price"] .
                    "</s>&nbsp &nbsp &nbsp &nbsp <b>" .
                    "$" . $rproduct["price"] * $sale .
                    "</b>";
                } else {
                  echo $rproduct["price"];
                } ?>
            </p>
            <p class="text-small mb-4"><?php echo $rproduct["description"]; ?></p>
            <div class="row align-items-stretch mb-4">
              <div class="col-sm-5 pr-sm-0" id="id1">
                <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white"><span class="small text-uppercase text-gray mr-4 no-select" id="quantity_add_to_cart">
                    <?php
                    $quantity = $rproduct["quantity"];
                    if ($quantity != 0) {
                      echo "Quantity";
                    } else {
                      echo "<span style='font-size:0.9rem'><i><b>Sold Out</b></i></span>";
                    }
                    ?>
                  </span>
                  <div class="quantity">
                    <button class="p-0"><i class="fas fa-caret-left" id="quantity_button_left"></i></button>
                    <input class="form-control border-0 shadow-0 p-0" type="number" value=0 id="quantity">

                    <button class="p-0"><i class="fas fa-caret-right" id="quantity_button_right"></i></button>
                  </div>


                </div>
              </div>
              <div class="col-sm-3 pl-sm-0"><a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" id="add_to_cart" href="#" >Add to cart</a></div>
              <div id="toappend"></div>

              <script>
                var quantity = <?php echo $quantity; ?>;
                $(document).ready(function() {


                  var users_id = <?php echo $users_id;?>;
                  if (users_id == -1){
                    $("#add_to_cart").css("opacity", "0.4");
                    $('#wishlist1').remove();
                  }

                  console.log(users_id);
                  console.log(parseInt($("#quantity").val()));
                  var valueup=0;
                  $("#quantity_button_right").on('click',function() {
                    $("#quantity_button_left").show();
                    valueup=parseInt($("#quantity").val())+1;
                    $("#quantity").val(valueup);
                    console.log($("#quantity").val());

                    if ($("#quantity").val() == quantity){
                      $("#quantity_button_right").hide();

                    }
                  });
                  $("#quantity_button_left").click(function() {
                    var valuedown = parseInt($("#quantity").val())-1;
                    if (parseInt($("#quantity").val())<=0){
                      $("#quantity").val(0);
                      $("#quantity_button_left").hide();
                    }
                    else
                    $("#quantity").val(valuedown);
                    $("#quantity_button_right").show();
                  });

                  if (quantity == 0) {
                    $("#quantity_button_left, #quantity_button_right").remove();
                    $("#add_to_cart").remove();
                    $("#quantity").attr('value', '');
                    $("#quantity").attr("disabled", true);
                    $("#quantity").css("background-color", "white");
                  }
                  $("#add_to_cart").on('click', function() {
                    if (users_id==-1){
                      $('#toappend').append("<div id='txtVal'><span>You must login to add to cart.</span></div>");
                      setTimeout(function(){
                            $('#toappend').remove();
                                        }, 2000);
                      return;
                    };


                    var id = <?php echo $id;?>;

                    console.log('----');
                    console.log($("#quantity").val());
                    console.log(users_id);
                    console.log(id);
                      if ($("#quantity").val()!=0){
                        console.log('hi');
                        $.ajax({
                          type: "POST",
                          url:'addtocart.php',
                          data:{
                            'users_id': users_id,
                            'products_id': id,
                            'quantity': $("#quantity").val(),
                            'totalquantity':quantity,
                          },
                          datatype: 'text',
                          success:function(data) {
                            $('#toappend').append(data);
                          },
                          error: function() {
                            //$("#txtVal").html("error");
                          },
                        })
                      }
                      else {
                        $('#toappend').append("<div id='txtVal'><span>Plese select a non null quantity.</span></div>");                      }
                      setTimeout(function(){
                            $('#txtVal').remove();
                                        }, 2000);
                  });

                });
              </script>
            </div id="wishlist"><a class="btn btn-link text-dark p-0 mb-4" <?php echo "href='add-to-wishlist.php?productid=".base64_encode($id)."' id='wishlist1'>"?> <i class="far fa-heart mr-2"></i>Add to wish list</a><br>
            <ul class="list-unstyled small d-inline-block">
              <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Category:</strong>
                <?php echo "<a class='reset-anchor ml-2' href='shop-categories.php?categorie_id=".$rcategory["id"]."'>" .
                  $rcategory["name"]; ?>
                </a></li>
              <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Tags:</strong>
                <?php while ($rtags = mysqli_fetch_array($tags)) {
                  echo "<a class='reset-anchor ml-2' href='#'>" .
                    $rtags["tags_tag"] . " ";
                } ?></a></li>
            </ul>
          </div>
        </div>
        <!-- DETAILS TABS-->
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">

          <li class="nav-item"><a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab">Reviews</a></li>
        </ul>
        <div class="tab-content mb-5" id="myTabContent">

          <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
            <div class="p-4 p-lg-5 bg-white">
              <div class="row">
                <div class="col-lg-8">
                  <?php
                  if (mysqli_num_rows($reviews) == false) {
                    echo "No Reviews Yet!";
                  } else {
                    while ($rreviews = mysqli_fetch_array($reviews)) {
                      echo "<div class='media mb-3'><a  href='user/profile.php?id=".base64_encode($rreviews["users_id"])."'><img class='rounded-circle' src='" .
                        $rreviews["profile_path"] .
                        "' alt='' width='50'></a>
                        <div class='media-body ml-3'> <h6 class='mb-0 text-uppercase'>" .
                        $rreviews["firstname"] .
                        " " .
                        $rreviews["lastname"] .
                        "</h6> <p class='small text-muted mb-0 text-uppercase'>" .
                        $rreviews["reviewDate"] .
                        "</p>  <ul class='list-inline mb-1 text-xs'>";
                      $i = 0;
                      for ($x = 1; $x <= $rreviews["rating"]; $x++) {
                        echo "<li class='list-inline-item m-0'><i class='fas fa-star text-warning'></i></li>";
                        $i++;
                      }
                      if (fmod($rreviews["rating"], 1.0) != 0) {
                        echo "<li class='list-inline-item m-0'><i class='fas fa-star-half-alt text-warning'></i></li>";
                        $i++;
                      }
                      while ($i < 5) {
                        echo "<li class='list-inline-item m-0'><i class='far fa-star text-warning'></i></li>";
                        $i++;
                      }

                      echo " <p class='text-small mb-0 text-muted'>" .
                        $rreviews["content"] .
                        "</p></div></div>";
                    }
                  } ?>
                </div>
                <?php

			if($users_id != -1 && mysqli_num_rows($isbought) > 0) {
        $isreviewed = mysqli_query($con, "select * from reviews where users_id = $users_id and products_id=$id");
        if (mysqli_num_rows($isreviewed)==false){

		  ?>
		  <form method="POST">
			  <?php
				if (mysqli_num_rows($isbought)) {
				echo "<a class='btn btn-link text-dark p-0' name='review' id='review'><input name='reviewcontent' id='reviewcontent' class='form-control' type='text' placeholder='Enter your review' size='1000'></a> 
				<input  type='number' placeholder='Enter rating' size='10' name='rating' id='rating' max='5'>
				<div class='col-sm-3 pl-sm-0'><input type='submit' name='review' id='review' class='btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0' value='Add Review' /></div>";
				}
      }
        else {
          echo '';
        }
			  ?>
			  <?php
				if(isset($_POST["review"]))
				{
					$id_user=$users_id;
					$id_product=$id;
					$date=date("Y/m/d");
					$rating=$_POST["rating"];
					$review=$_POST["reviewcontent"];
					mysqli_query($con, "INSERT INTO reviews(users_id,products_id,reviewDate,rating,content) VALUES('$id_user','$id_product','$date','$rating','$review')");
					mysqli_close($con);
                    echo "<meta http-equiv='refresh' content='0'>";
				}
				?>
			</form>
			<?php
				}
			?>
              </div>
            </div>
          </div>
        </div>
        <?php
        if (mysqli_num_rows($related_products) == false) {
        } else {
          echo "<h2 class='h5 text-uppercase mb-4'>Related products</h2>
            <div class='row'>";
          while ($rrelated_products = mysqli_fetch_array($related_products)) {
            $old_price = $rrelated_products["price"];
            if ($rrelated_products["salePercentage"]!=0) {
              $sale = 1 - $rrelated_products["salePercentage"] / 100;
              $new_price = $rrelated_products["price"] * $sale;
            } else {
              $new_price = $rrelated_products["price"];
            }
            echo "
            <div class='col-lg-3 col-sm-6'>
            <div class='product text-center skel-loader'>
            <div class='d-block mb-3 position-relative'><a class='d-block' href='detail.php?productid=".base64_encode($rrelated_products["id"])."'><img class='img-fluid w-100' src='" . $rrelated_products['media_path'] . "' alt='...'></a>
              <div class='product-overlay'>
                <ul class='mb-0 list-inline'>
                  
                  <li class='list-inline-item m-0 p-0'><a class='btn btn-sm btn-dark' href='detail.php?productid=".base64_encode($rrelated_products["id"])."'>Visit Page</a></li>
                  
                </ul>
              </div>
            </div>
            <h6> <a class='reset-anchor' href='detail.php?productid=".base64_encode($rrelated_products["id"])."'>
              " . $rrelated_products['name'] . "
            </a></h6>
            <p class='small text-muted'>";
            if ($old_price == $new_price) {;
              echo $old_price;
            } else {
              echo "<s>$" . $old_price . "</s> &nbsp &nbsp$" . $new_price;
            }
            echo "</p>
          </div>
          </div>";
          }
          echo "</div>";
        }
        ?>
        <!-- </div> -->
      </div>
    </section>
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
