<?php

require_once("../controllers/database/connection.php");
$con=openCon();
//$prodID=$_GET[id];
$result=mysqli_query($con,"select * from products where id=".$_GET["id"]);
$product = mysqli_fetch_array($result);
$tags_result=mysqli_query($con,"select * from products_tags where products_id=".$_GET['id']);
$category_result=mysqli_query($con,"select * from products_categories where products_id=".$_GET['id']);
$category_row=mysqli_fetch_array($category_result);
$cat_name=mysqli_query($con,"select * from categories where id=".$category_row["categories_id"]);
$cat_name_row=mysqli_fetch_array($cat_name);
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
    <!-- Quill Themes-->
    <link rel="stylesheet" href="../vendor/back/quill/quill.snow.css">
    <!-- VanillaJs Datepicker CSS-->
    <link rel="stylesheet" href="../vendor/back/vanillajs-datepicker/css/datepicker-bs4.min.css">
    <!-- Lightbox gallery-->
    <link rel="stylesheet" href="../vendor/back/glightbox/css/glightbox.min.css">
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

      <?php
		  if(isset($_GET["success"])) {
			  echo "<p style='text-align:center;color:green;font-weight:bold;font-size:20px;'>Successful insertion</p>";
		  }

		  if(isset($_GET["error"]) && $_GET["error"]==1) {
			  echo "<p style='text-align:center;color:red;font-weight:bold;font-size:20px;'>product already exists.</p>";
		  }
      if(isset($_GET["error"]) && $_GET["error"]==2) {
			  echo "<p style='text-align:center;color:red;font-weight:bold;font-size:20px;'>error.</p>";
		  }

           if(isset($_GET["errorImage"]) && $_GET["errorImage"]==1) {
			  echo "<p style='text-align:center;color:red;font-weight:bold;font-size:20px;'>error in image upload</p>";
		  }

   
      
		?>


    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a class="sidebar-toggler text-gray-500 me-4 me-lg-5 lead" href="#"><i class="fas fa-align-left"></i></a><a class="navbar-brand fw-bold text-uppercase text-base" href="../index.html"><span class="d-none d-brand-partial">Condor </span></a>
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
              <h6 class="dropdown-header text-uppercase fw-normal">Users</h6><a class="dropdown-item py-1" href="pages-profile.html"> <img class="avatar avatar-xs p-1 me-2" src="img/avatar-0.jpg" alt="Jason Doe"><span>Jason Doe</span></a><a class="dropdown-item py-1" href="pages-profile.html"> <img class="avatar avatar-xs p-1 me-2" src="img/avatar-1.jpg" alt="Frank Williams"><span>Frank Williams</span></a><a class="dropdown-item py-1" href="pages-profile.html"> <img class="avatar avatar-xs p-1 me-2" src="img/avatar-2.jpg" alt="Ashley Wood"><span>Ashley Wood</span></a>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header text-uppercase fw-normal">Filters</h6><a class="dropdown-item py-1" href="#!"> <span class="badge me-2 badge-success-light">Posts</span><span class="text-xs">Search all posts</span></a><a class="dropdown-item py-1" href="#!"> <span class="badge me-2 badge-danger-light">Users</span><span class="text-xs">Only in users</span></a><a class="dropdown-item py-1" href="#!"> <span class="badge me-2 badge-warning-light">Campaigns</span><span class="text-xs">Only in campaigns</span></a>
            </div>
          </li>
          <li class="nav-item dropdown me-2"><a class="nav-link nav-link-icon text-gray-400 px-1" id="notifications" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <svg class="svg-icon svg-icon-md svg-icon-heavy">
                    <use xlink:href="icons/orion-svg-sprite.svg#sales-up-1"> </use>
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
          <!-- Messages                        -->
          <li class="nav-item dropdown me-2 me-lg-3"> <a class="nav-link nav-link-icon text-gray-400 px-1" id="messages" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <svg class="svg-icon svg-icon-md svg-icon-heavy">
                    <use xlink:href="icons/orion-svg-sprite.svg#paper-plane-1"> </use>
                  </svg><span class="notification-badge notification-badge-number bg-primary">10</span></a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated text-sm" aria-labelledby="messages"><a class="dropdown-item d-flex align-items-center p-3" href="#"> <img class="avatar avatar-sm p-1 me-2" src="img/avatar-0.jpg" alt="Jason Doe">
                <div class="pt-1">
                  <h6 class="fw-bold mb-0">Jason Doe</h6><span class="text-muted text-sm">Sent you a message</span>
                </div></a><a class="dropdown-item d-flex align-items-center p-3" href="#"> <img class="avatar avatar-sm p-1 me-2" src="img/avatar-1.jpg" alt="Frank Williams">
                <div class="pt-1">
                  <h6 class="fw-bold mb-0">Frank Williams</h6><span class="text-muted text-sm">Sent you a message</span>
                </div></a><a class="dropdown-item d-flex align-items-center p-3" href="#"> <img class="avatar avatar-sm p-1 me-2" src="img/avatar-2.jpg" alt="Ashley Wood">
                <div class="pt-1">
                  <h6 class="fw-bold mb-0">Ashley Wood</h6><span class="text-muted text-sm">Sent you a message</span>
                </div></a>
              <div class="dropdown-divider"></div><a class="dropdown-item text-center" href="#"> <small class="fw-bold text-uppercase">View all messages                          </small></a>
            </div>
          </li>
          <li class="nav-item dropdown ms-auto"><a class="nav-link pe-0" id="userInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar p-1" src="img/avatar-6.jpg" alt="Jason Doe"></a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="userInfo">
              <div class="dropdown-header text-gray-700">
                <h6 class="text-uppercase font-weight-bold">Mark Stephen</h6><small>Web Developer</small>
              </div>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity log       </a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="../login.html">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <div class="sidebar py-3" id="sidebar">
        <h6 class="sidebar-heading">Main</h6>
        <ul class="list-unstyled">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../index.html">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
                      </svg><span class="sidebar-link-title">Dashboard</span></a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#cmsDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#reading-1"> </use>
                      </svg><span class="sidebar-link-title">CMS </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="cmsDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="cms-post.html">Posts</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="cms-post-new.html">Add new post</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="cms-category.html">Categories</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="cms-media.html">Media library</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#widgetsDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#statistic-1"> </use>
                      </svg><span class="sidebar-link-title">Widgets </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="widgetsDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="widgets-stats.html">Stats</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="widgets-data.html">Data</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted active" href="#" data-bs-target="#e-commerceDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#delivery-truck-1"> </use>
                      </svg><span class="sidebar-link-title">E-commerce </span></a>
                <ul class="sidebar-menu list-unstyled collapse show" id="e-commerceDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="e-commerce-products.html">Products</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link active text-muted" href="e-commerce-product-new.html">Products - New</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="e-commerce-orders.html">Orders</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="e-commerce-order.html">Order - Detail</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="e-commerce-customers.html">Customers</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#pagesDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#paper-stack-1"> </use>
                      </svg><span class="sidebar-link-title">Pages </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="pagesDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="pages-profile.html">Profile</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="pages-pricing.html">Pricing table</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="pages-contacts.html">Contacts</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="pages-invoice.html">Invoice</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="pages-knowledge-base.html">Knowledge base</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="pages-knowledge-base-topic.html">Knowledge base - Topic</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#userDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#man-1"> </use>
                      </svg><span class="sidebar-link-title">User </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="userDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../login.html">Login page</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="register.html">Register</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="login-2.html">Login v.2 <span class="badge bg-info ms-2 text-decoration-none">New</span></a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="register-2.html">Register v.2 <span class="badge bg-info ms-2 text-decoration-none">New</span></a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#componentsDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#sorting-1"> </use>
                      </svg><span class="sidebar-link-title">Components </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="componentsDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-cards.html">Cards</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-calendar.html">Calendar</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-gallery.html">Gallery</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-loading-buttons.html">Loading buttons</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-map.html">Maps</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-notifications.html">Notifications</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="components-preloader.html">Preloaders</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#chartsDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#pie-chart-1"> </use>
                      </svg><span class="sidebar-link-title">Charts </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="chartsDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="charts.html">Charts</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="charts-gauge-sparkline.html">Gauge + Sparkline</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#formsDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#file-storage-1"> </use>
                      </svg><span class="sidebar-link-title">Forms </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="formsDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="forms.html">Basic forms</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="forms-advanced.html">Advanced forms</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="forms-dropzone.html">Files upload</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="forms-texteditor.html">Text editor</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="forms-validation.html">Validation</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#tablesDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#grid-1"> </use>
                      </svg><span class="sidebar-link-title">Tables </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="tablesDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="tables.html">Bootstrap tables</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="tables-datatable.html">Datatable</a></li>
                </ul>
              </li>
        </ul>
        <h6 class="sidebar-heading">Docs</h6>
        <ul class="list-unstyled">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/introduction.html">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#angle-brackets-1"> </use>
                      </svg><span class="sidebar-link-title">Introduction</span></a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/directory-structure.html">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#table-content-1"> </use>
                      </svg><span class="sidebar-link-title">Directory structure</span></a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/gulp.html">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#keyboard-1"> </use>
                      </svg><span class="sidebar-link-title">Gulp.js</span></a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted " href="#" data-bs-target="#cssDropdown" role="button" aria-expanded="false" data-bs-toggle="collapse">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#design-1"> </use>
                      </svg><span class="sidebar-link-title">CSS </span></a>
                <ul class="sidebar-menu list-unstyled collapse " id="cssDropdown">
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/components-theme.html">CSS Components</a></li>
                  <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/customizing-css.html">Customizing CSS</a></li>
                </ul>
              </li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/credits.html">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#star-medal-1"> </use>
                      </svg><span class="sidebar-link-title">Credits</span></a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted" href="../docs/changelog.html">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#new-1"> </use>
                      </svg><span class="sidebar-link-title">Changelog</span></a></li>
        </ul>
      </div>
      <div class="page-holder bg-gray-100">

        <div class="container-fluid px-lg-4 px-xl-5">
            <!-- here begins the main form-->
            <?php echo"<form id='productInfo' action='update-product-inter.php?id=".$product['id']."' method='post'  enctype='multipart/form-data' >"?>

              <!-- Breadcrumbs -->
              <div class="page-breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
                  <li class="breadcrumb-item"><a href="e-commerce-products.html">Products</a></li>
                  <li class="breadcrumb-item active">Update a Product</li>
                </ul>
              </div>
          <!-- Page Header-->
          <div class="page-header">
            <h1 class="page-heading">Edit a product</h1>

          </div>
          <section>
            <div class="row mb-5">
              <div class="col-lg-8 col-xxl-9 mb-4 mb-lg-0">
                <div class="card mb-4">
                  <div class="card-header">
                    <div class="card-heading">Main Info</div>
                  </div>

                  <div class="card-body">

               
                  
                    <input class="form-control mb-4" id="productId" name="productId" type="text" value="<?php echo $product["id"];?>"  hidden>


                    <label class="form-label" for="postTitle">Product Name</label>
                    <input class="form-control mb-4" id="productName" name="productName" type="text" value="<?php echo $product["name"];?>"  required>

                    <label class="form-label" for="postTitle">Product Description</label>
                    <input class="form-control mb-4" id="productDesc" name="productDesc" type="text" value="<?php echo $product["description"];?>" required>

                    <label class="form-label" for="postTitle">Product Tags</label>

                    <?php

                    $tags_array="";
                    while($tags_row=mysqli_fetch_array($tags_result))
                    {
                        $tags_array.=$tags_row["tags_tag"].",";
                    }
                    $tags_array=substr($tags_array, 0, -1);
                    echo"<input class='form-control mb-4' id='productTags' name='productTags' type='text' value='".$tags_array."' required>";

                    ?>
                          <label class="form-label" for="postTitle">Product Category</label>
                         <select name="productCat" style="width: 250px; height:30px; margin: 2%" >

                         <?php 
                         /* while($category_row=mysqli_fetch_array($category_result))
                          {
                            $cat_name=mysqli_query($con,"select name from categories where id=".$category_row["categories_id"]);

                            while($cat_name_row=mysqli_fetch_array($cat_name))
                            {
                              echo"<option  value='".$cat_name_row["name"]."' selected></option>";
                            }
                            
                          }
                         */
                          ?>
                             <?php
                               $conn = openCon();
                                $old_cat=mysqli_query($conn, "SELECT categories_id From products_categories where products_id=".$_GET['id']);
                                $old_cat_row=mysqli_fetch_array($old_cat);
                               $result = mysqli_query($conn, "SELECT * From categories");  // Use select query here
                               while($row = mysqli_fetch_array($result))
                               {
                                  echo "<option  value='". $row['id'] ."'";
                                
                                  if( $row['id']==$old_cat_row["categories_id"])
                                  {
                                    echo" selected ";
                                  }

                                  if( $row["isDeleted"]== 1)
                                  {
                                    echo" disabled ";
                                  }
                                  echo ">".$row['name'] ."</option>"; 
                                
                                   
                                  
                                  
                               }

                           
                              ?>
                             </select>


                  </div>
                </div>

                <div class="card mb-4">
                  <div class="card-header">
                    <div class="card-heading">Prices & Stock                 </div>
                  </div>
                  <div class="card-body">
                    <div class="row gy-3">
                      <div class="col-12">
                        <label class="form-label fw-bold">Main Price</label>
                        <div class="input-group">
                          <div class="input-group-text">$</div>
                          <input class="form-control" name="productMainPrice"  value="<?php echo $product["price"];?>" required>
                        </div>
                      </div>
                      <div class="col-12 col-lg-6 text-sm">
                        <label class="form-label text-muted">Discount Percentage</label>
                        <div class="form-check form-switch float-end">
                          <label class="form-check-label text-sm sr-only" for="displayDiscount">Display Discount percentage</label>
                          <input class="form-check-input" id="displayRegular" type="checkbox">
                        </div>
                        <div class="input-group">
                          <div class="input-group-text">%                                        </div>
                          <input class="form-control" name="productPercentage" value="<?php echo $product["salePercentage"];?>" required>
                        </div>
                      </div>
                    </div>
                    <hr class="bg-gray-500 my-4">
                    <label class="form-label fw-bold">Quantity in stock</label>
                    <input class="form-control" name='productQuantity' value="<?php echo $product["quantity"];?>" required >
                  </div>
                </div>

                <div class="card mb-4">
                  <div class="card-header">
                    <div class="card-heading">Images                    </div>
                  </div>
                  <div class="card-body">
                      
                    <div class="bg-gray-100 rounded-4" id="demo-upload" action="#">

                    <input name="productImg[]" id="chooseFile" type="file" multiple />

                    </div>

                  </div>
                </div>
              </div>
            </div>
          </section>
                    <input type="submit" value="Submit" name="submit">
                       </form>
        </div>


        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-start fw-bold">
                <p class="mb-2 mb-md-0 fw-bold">Condor &copy; 2021</p>
              </div>
              <div class="col-md-6 text-center text-md-end text-gray-400">
                <p class="mb-0">Version 1.0</p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <!-- JavaScript files-->
    <script src="../vendor/back/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Choices.js-->
    <script src="../vendor/back/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- VanillaJs DatePicker-->
    <script src="../vendor/back/vanillajs-datepicker/js/datepicker-full.min.js"></script>
    <!-- Quill-->
    <script src="../vendor/back/quill/quill.min.js"></script>
    <!-- Lightbox gallery-->
    <script src="../vendor/back/glightbox/js/glightbox.min.js">    </script>
    <!-- Dropzone.js-->
    <script src="../vendor/back/dropzone/dropzone.js">   </script>

    <!-- Add New Product JS-->
    <script src="../js/back/e-commerce-product-new.js">   </script>
    <!-- Main Theme JS File-->
    <script src="../js/back/js/theme.js"></script>
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
<?php 
closeCon($conn);
?>