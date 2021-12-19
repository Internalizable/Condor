<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
  header("location: ../error?code=403");
  exit;
}

   require_once("../controllers/database/connection.php");
            $con=openCon();
            $order_id=$_GET['order'];
            $row_total=0;
            $order_total=0;
            $billing_id='';


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Condor - CMS</title>
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
    <link rel="shortcut icon" href="../img/back/logo.png">
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a class="navbar-brand fw-bold text-uppercase text-base" href="index.php"><span class="d-none d-brand-partial">Condor </span></a>
        <ul class="ms-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item dropdown">
            <form class="ms-auto me-4 d-none d-lg-block" id="searchForm">
              <div class="input-group input-group-sm input-group-navbar">
                <input class="form-control" id="searchInput" type="search" placeholder="Search">
                <button class="btn" type="button"> <i class="fas fa-search"></i></button>
              </div>
            </form>
            <div class="dropdown-menu dropdown-menu-animated text-sm" id="searchDropdownMenu">
              <h6 class="dropdown-header text-uppercase fw-normal">Recent pages</h6><a class="dropdown-item py-1" href="cms-post.html"> <i class="far fa-file me-2"> </i>Posts</a><a class="dropdown-item py-1" href="widgets-stats.html"> <i class="far fa-file me-2"> </i>Widgets</a><a class="dropdown-item py-1" href="pages-profile.html"> <i class="far fa-file me-2"> </i>Profile</a>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header text-uppercase fw-normal">Users</h6><a class="dropdown-item py-1" href="pages-profile.html"> <img class="avatar avatar-xs p-1 me-2" src="../img/avatars/default.png" alt="Jason Doe"><span>Jason Doe</span></a><a class="dropdown-item py-1" href="pages-profile.html"> <img class="avatar avatar-xs p-1 me-2" src="../img/avatars/default.png" alt="Frank Williams"><span>Frank Williams</span></a><a class="dropdown-item py-1" href="pages-profile.html"> <img class="avatar avatar-xs p-1 me-2" src="img/avatars/default.png" alt="Ashley Wood"><span>Ashley Wood</span></a>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header text-uppercase fw-normal">Filters</h6><a class="dropdown-item py-1" href="#!"> <span class="badge me-2 badge-success-light">Posts</span><span class="text-xs">Search all posts</span></a><a class="dropdown-item py-1" href="#!"> <span class="badge me-2 badge-danger-light">Users</span><span class="text-xs">Only in users</span></a><a class="dropdown-item py-1" href="#!"> <span class="badge me-2 badge-warning-light">Campaigns</span><span class="text-xs">Only in campaigns</span></a>
            </div>
          </li>
          <li class="nav-item dropdown me-2"><a class="nav-link nav-link-icon text-gray-400 px-1" id="notifications" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <svg class="svg-icon svg-icon-md svg-icon-heavy">
                    <use xlink:href="../icons/back/orion-svg-sprite.svg#sales-up-1"> </use>
                  </svg><span class="notification-badge bg-green"></span></a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated text-sm" aria-labelledby="notifications"><a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="icon icon-sm bg-indigo text-white"><i class="fab fa-twitter"></i></div>
                  <div class="text ms-2">
                    <p class="mb-0">You have 2 followers</p>
                  </div>
                </div></a><a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                <div class="icon icon-sm bg-green text-white"><i class="fas fa-envelope"></i></div>
                  <div class="text ms-2">
                    <p class="mb-0">You have 6 new messages</p>
                  </div>
                </div></a><a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="icon icon-sm bg-blue text-white"><i class="fas fa-upload"></i></div>
                  <div class="text ms-2">
                    <p class="mb-0">Server rebooted</p>
                  </div>
                </div></a><a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="icon icon-sm bg-indigo text-white"><i class="fab fa-twitter"></i></div>
                  <div class="text ms-2">
                    <p class="mb-0">You have 2 followers</p>
                  </div>
                </div></a>
              <div class="dropdown-divider"></div><a class="dropdown-item text-center" href="#"><small class="fw-bold text-uppercase">View all notifications</small></a>
            </div>
          </li>
          <!-- Messages-->
          <li class="nav-item dropdown me-2 me-lg-3"> <a class="nav-link nav-link-icon text-gray-400 px-1" id="messages" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <svg class="svg-icon svg-icon-md svg-icon-heavy">
                    <use xlink:href="../icons/back/orion-svg-sprite.svg#paper-plane-1"> </use>
                  </svg><span class="notification-badge notification-badge-number bg-primary">10</span></a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated text-sm" aria-labelledby="messages"><a class="dropdown-item d-flex align-items-center p-3" href="#"> <img class="avatar avatar-sm p-1 me-2" src="../img/avatars/default.png" alt="Jason Doe">
                <div class="pt-1">
                  <h6 class="fw-bold mb-0">Jason Doe</h6><span class="text-muted text-sm">Sent you a message</span>
                </div></a><a class="dropdown-item d-flex align-items-center p-3" href="#"> <img class="avatar avatar-sm p-1 me-2" src="../img/avatars/default.png" alt="Frank Williams">
                <div class="pt-1">
                  <h6 class="fw-bold mb-0">Frank Williams</h6><span class="text-muted text-sm">Sent you a message</span>
                </div></a><a class="dropdown-item d-flex align-items-center p-3" href="#"> <img class="avatar avatar-sm p-1 me-2" src="../img/avatars/default.png" alt="Ashley Wood">
                <div class="pt-1">
                  <h6 class="fw-bold mb-0">Ashley Wood</h6><span class="text-muted text-sm">Sent you a message</span>
                </div></a>
              <div class="dropdown-divider"></div><a class="dropdown-item text-center" href="#"> <small class="fw-bold text-uppercase">View all messages                          </small></a>
            </div>
          </li>
          <li class="nav-item dropdown ms-auto"><a class="nav-link pe-0" id="userInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar p-1" src="../img/avatars/default.png" alt="Jason Doe"></a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="userInfo">
              <div class="dropdown-header text-gray-700">
                <h6 class="text-uppercase font-weight-bold">Mark Stephen</h6><small>Web Developer</small>
              </div>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity log       </a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="../user/logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>

    <div class="d-flex align-items-stretch">
    <div class="sidebar py-3" id="sidebar">
        <h6 class="sidebar-heading">Main</h6>
        <ul class="list-unstyled">

        <li class="sidebar-list-item"><a class="sidebar-link text-muted active" href="index.php">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="../icons/back/orion-svg-sprite.svg#real-estate-1"> </use>
                      </svg><span class="sidebar-link-title">Dashboard</span></a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted active" href="#" data-bs-target="#e-commerceDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="../icons/back/orion-svg-sprite.svg#delivery-truck-1"> </use>
                      </svg><span class="sidebar-link-title">E-commerce </span></a>
                <ul class="sidebar-menu list-unstyled collapse show" id="e-commerceDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="view-categories.php">Categories</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="e-commerce-category-new.php">New Category</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="view-products.php">Products</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link  text-muted" href="e-commerce-product-new.php">New Product</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link active text-muted" href="track-orders.php">Orders</a></li>
                </ul>
              </li>
               </ul>
             </div>
      <div class="page-holder bg-gray-100">
        <div class="container-fluid px-lg-4 px-xl-5">
              <!-- Breadcrumbs -->
              <div class="page-breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="track-orders.php">Orders</a></li>
                  <li class="breadcrumb-item active">Order   </li>
                </ul>
              </div>
          <!-- Page Header-->
          <div class="page-header d-md-flex justify-content-between">
            <div>
              <h1 class="page-heading">Order # <?php echo "$order_id"; ?></h1>

            </div>

          </div>
          <div class="row mb-5">
            <div class="col-lg-12">
              <div class="card card-table mb-4">
                <div class="card-header">
                  <h5 class="card-heading"> Order details</h5>
                      <div class="card-header-more">
                        <div class="dropdown-menu dropdown-menu-end text-sm"><a class="dropdown-item" href="#!"><i class="fas fa-expand-arrows-alt me-2"></i>Expand</a><a class="dropdown-item" href="#!"><i class="far fa-window-minimize me-2"></i>Minimize</a><a class="dropdown-item" href="#!"><i class="fas fa-redo me-2"></i> Reload</a><a class="dropdown-item" href="#!"><i class="far fa-trash-alt me-2"></i> Remove        </a></div>
                      </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table  class="table table-hover table-borderless mb-0">
                      <thead class="light">
                        <tr>
                          <th style="min-width: 400px;">Product</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Row Total</th>
                          <th>Discount</th>
                          <th class="text-end">Row Net Total</th>
                        </tr>
                      </thead>
                      <tbody>

                          <?php

                          $order_query=mysqli_query($con,"select * from orders where ordersid=".$order_id);

                          while($row=mysqli_fetch_array($order_query))
                          {
                            $coupon_code_query=mysqli_query($con,"select distinct coupons_coupon from orders where ordersid=".$order_id);
                            $coupon_code_row=mysqli_fetch_array( $coupon_code_query);
                            $coupon_code= $coupon_code_row['coupons_coupon'];

                            echo"<tr class='align-middle'>";
                            $billing_id=$row['billing_information_id'];
                            $image_path=mysqli_query($con,"select  media_path from products_media where products_id=".$row['products_id']);

                            $product_query=mysqli_query($con,"select * from  products where id=".$row['products_id']);
                            while($row2=mysqli_fetch_array($product_query))
                            {
                            echo"<td>";
                            if(mysqli_num_rows( $image_path)==0)
                            {
                              echo"<img class='card-table-img img-fluid me-3' src='../img/back/product/default.jpg'". " width='80'>";
                            }
                            else
                            {
                           while($row3=mysqli_fetch_array($image_path))
                            {
                              if(!file_exists('../' . $row3['media_path']))
                              {
                                echo"<img class='card-table-img img-fluid me-3' src='../img/back/product/default.jpg'". " width='80'>";
                              }
                              else{
                            echo "<img class='card-table-img img-fluid me-3' src='../".$row3['media_path']."' width='80'>";
                              }
                            break; // this is to display only 1 image for each product
                            }
                          }
                            echo"<span class='card-table-text'><a class='text-reset text-decoration-none' href='product-details.php?id=".base64_encode($row['products_id'])."'".">";
                            echo"<strong>".$row2['name']."</strong><br>";
                            echo"</a></span></td>";
                            echo"<td>". $row['quantity']."</td>";
                            echo "<td>".$row['unitPrice']."</td>";
                            echo "<td>".$row['quantity']*$row['unitPrice']."</td>";
                            $discount_value=$row['discountPerc']* $row['quantity']*$row['unitPrice']*0.01;
                            $row_total=$row['quantity']*$row['unitPrice']-$discount_value;
                            echo "<td>".$discount_value."</td>";
                            echo"<td class='text-end'>". $row_total."</td>";
                            $order_total+=$row_total;
                            echo"</tr>";
                          }
                         }

                          ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row gy-4">
                <div class="col-lg-6">
                  <div class="card">


                  <div class="card-header">
                      <h5 class="card-heading"> Order Total               $ </h5>
                          <div class="card-header-more">
                          </div>
                    </div>
                    <?php
                    $coupon_query=mysqli_query($con,"select * from coupons where coupon='".$coupon_code."'");
                    $coupon_row=mysqli_fetch_array($coupon_query);
                    ?>
                        <div class="card-body">
                    <p class="card-text "> <b> Original Total  =   <b><?php echo"$order_total  "; ?> </b></b >     </p>
                    <p class="card-text "> <b>Coupon :   <b><?php echo  $coupon_row['coupon'] ; ?> </b></b >     </p>

               <p class="card-text "> <b>Discount Value :   <b><?php echo $order_total*$coupon_row['percentage']*0.01; ?> </b></b >     </p>
                 <p class="card-text "> </p>
                 <hr></hr>
                    <p class="card-text "> <b> Net Total =   <b><?php echo $order_total-($order_total*$coupon_row['percentage']*0.01)  ; ?> </b></b >     </p>
                      <p class="card-text "> </p>
                    </div>





                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-heading"> Billing Information </h5>
                          <div class="card-header-more">
                          </div>
                    </div>
                    <div class="card-body">
                      <?php
                        $billing_query=mysqli_query($con,"select * from billing_information where id=". $billing_id);
                        while($billing_row=mysqli_fetch_array($billing_query))
                      {
                        echo"<p class='card-text text-muted'>" .$billing_row['first_name']. "  " . $billing_row['last_name']."";
                        echo "<br>";
                        echo $billing_row['email'];
                        echo "<br>";
                        echo $billing_row['phone_number'];
                        echo "<br>";
                        echo $billing_row['company_name'];
                        echo "<br>";
                        echo $billing_row['country'];
                        echo "<br>";
                        echo $billing_row['city'];
                        echo "<br>";
                        echo $billing_row['address'];
                        echo "<br>";
                        echo $billing_row['address2'];
                        echo "<br>";
                        echo $billing_row['zip'];
                      }
                        ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card card-table">


            </div>
          </div>
        </div>
        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-start fw-bold">
                <p class="mb-2 mb-md-0 fw-bold">Condor &copy; 2021</p>
              </div>
              <div class="col-md-6 text-center text-md-end text-gray-400">
                <p class="mb-0">Version 1.1.0</p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="js/theme.js"></script>
    <!-- Prism for syntax highlighting-->
    <script src="../vendor/back/prismjs/prism.js"></script>
    <script src="../vendor/back/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js"></script>
    <script src="../vendor/back/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="../vendor/back/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <script type="text/javascript">
      // Optional
      Prism.plugins.NormalizeWhitespace.setDefaults({
      'remove-trailing': true,
      'remove-indent': true,
      'left-trim': true,
      'right-trim': true,
      });

    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>
