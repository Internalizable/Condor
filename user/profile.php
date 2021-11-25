<?php
session_start();

if(!isset($_GET['id'])) {
    header("location: ../error?code=403");
    exit;
} else {
    include ('../controllers/database/connection.php');

    $conn = openCon();

    $userId = base64_decode($_GET['id']);

    $isOwner = false;

    if(isset($_SESSION['id']) && $_SESSION['id'] == $userId)
        $isOwner = true;

    $query = mysqli_query($conn, "SELECT * FROM USERS WHERE id='$userId';");

    $name = '';
    $username = '';
    $profilepath = '';
    $bannerpath = '';
    $bio = '';
    $location = '';
    $join = '';

    if(mysqli_num_rows($query) == 0) {
        header("location: ../error?code=404");
        exit;
    } else if($row = mysqli_fetch_array($query)) {
        $name = $row['firstname'] . ' ' . $row['lastname'];
        $username = $row['username'];
        $bio = $row['bio'];
        $profilepath = '../' . $row['profile_path'];
        $bannerpath = '../' . $row['banner_path'];
        $location = $row['city'] . ', ' . $row['country'];
        $join = $row['joinDate'];
    }

    function format_interval(DateInterval $interval) {
        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        if ($interval->m) { $result .= $interval->format("%m months "); }
        if ($interval->d) { $result .= $interval->format("%d days "); }
        if ($interval->h) { $result .= $interval->format("%h hours "); }
        if ($interval->i) { $result .= $interval->format("%i minutes "); }
        if ($interval->s) { $result .= $interval->format("%s seconds "); }

        $result .= " ago";

        return $result;
    }

    closeCon($conn);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bubbly - Boootstrap 5 Admin template by Bootstrapious.com</title>
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
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a class="sidebar-toggler text-gray-500 me-4 me-lg-5 lead" href="#"></a><a class="navbar-brand fw-bold text-uppercase text-base" href="index.html"><span class="d-none d-brand-partial">User </span><span class="d-none d-sm-inline">Profile</span></a>
        <ul class="ms-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item dropdown ms-auto"><a class="nav-link pe-0" id="userInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="avatar p-1" src=
                    <?php
                        echo "'$profilepath' alt='$name'";
                    ?>
            ></a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="userInfo">
              <div class="dropdown-header text-gray-700">
                <h6 class="text-uppercase font-weight-bold">
                    <?php
                        echo "$name";
                    ?>
                </h6>
                <small>
                    <?php
                        echo "$username";
                      ?>
                </small>
              </div>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="">Settings</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="./logout">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <div class="page-holder bg-gray-100">
        <div class="container-fluid px-lg-4 px-xl-5">
              <!-- Breadcrumbs -->
              <div class="page-breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../">Home</a></li>
                  <li class="breadcrumb-item active">Profile</li>
                </ul>
              </div>
              <!-- Page Header-->
              <div class="page-header">
                <h1 class="page-heading">Profile</h1>
              </div>
          <section>
            <div class="row">
              <div class="col-lg-4">
                <div class="card card-profile mb-4">
                  <div class="card-header" style="background-image: url(<?php echo $bannerpath; ?>);"> </div>
                  <div class="card-body text-center"><img class="card-profile-img" src="<?php echo $profilepath; ?>" alt="<?php echo $username;?>">
                    <h3 class="mb-3"><?php echo $name; ?></h3>
                    <p class="mb-4"><?php echo $bio?></p>
                      <p class="mb-4"><i class="fas fa-map-pin"></i>   Location: <?php echo $location;?></p>
                      <p class="mb-4"><i class="fas fa-sign-in-alt"></i>   Join Date: <?php echo $join;?></p>
                  </div>
                </div>
                <?php
                    if($isOwner) {
                        echo '<form class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-heading">My Profile</h4>
                    </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-auto d-flex align-items-center"><img class="avatar avatar-lg p-1" src="img/avatar-7.jpg" alt="Avatar"></div>
                      <div class="col">
                        <label class="form-label">Name</label>
                        <input class="form-control" placeholder="Your name">
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Bio</label>
                      <textarea class="form-control" rows="8">\'$bio\'</textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control" placeholder="you@domain.com">
                    </div>
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" value="password">
                  </div>
                  <div class="card-footer text-end">
                    <button class="btn btn-primary">Save</button>
                  </div>
                </form>';
                    }
                ?>
              </div>
              <div class="col-lg-8">
                <div class="card overflow-hidden mb-4">
                  <?php
                    if($isOwner) {
                        echo '<div class="card-header">
                    <div class="input-group">
                      <input class="form-control" type="text" placeholder="Message">
                      <button class="btn btn-outline-secondary" type="button"><i class="fa fa-paper-plane"></i></button>
                    </div>
                  </div>';
                    }

                    echo '<div class="list-group rounded-0">';

                    $conn = openCon();
                    $query = mysqli_query($conn, "SELECT * FROM users_timeline WHERE user_id='$userId' ORDER BY date DESC;");
                    $currentDate = new DateTime("now");

                    $i = 0;

                    while($row = mysqli_fetch_array($query)) {
                        $fetchedDate = new DateTime($row['date']);

                        $interval = format_interval($currentDate->diff($fetchedDate));

                        if($i == 0) {
                            echo '<div class="list-group-item border-start-0 border-end-0 py-5 border-top-0">';
                            $i++;
                        } else {
                            echo '<div class="list-group-item border-start-0 border-end-0 py-5">';
                        }

                        echo '<div class="d-flex">
                        <div class="flex-shrink-0"><img class="avatar avatar-lg p-1" src="' . $profilepath .'" alt="' . $username . '"></div>
                        <div class="flex-grow-1 ps-3"><small class="float-right">' . $interval . '</small>
                          <h5 class="fw-bold">' . $name . '</h5>
                          <div class="text-muted text-sm">' . $row['info'] . '</div>
                        </div>
                      </div>';

                        echo '</div>';
                    }

                    echo '</div>';
                  ?>
              </div>
            </div>
          </section>
        </div>
        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-start fw-bold">
                <p class="mb-2 mb-md-0 fw-bold">Your company &copy; 2021</p>
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
    <script src="../vendor/back/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="../js/back/theme.js"></script>
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous">
  </body>
</html>
