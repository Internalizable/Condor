<?php
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || !isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
        header("location: ../error?code=403");
        exit;
    } else {
        include ('../controllers/database/connection.php');

        $conn = openCon();
        $userId = $_SESSION['id'];
        $query = mysqli_query($conn, "SELECT firstname, lastname, username, profile_path FROM USERS WHERE id='$userId';");

        $name = '';
        $username = '';
        $profilepath = '';

        if($row = mysqli_fetch_array($query)) {
            $name = $row['firstname'] . ' ' . $row['lastname'];
            $username = $row['username'];
            $profilepath = '../' . $row['profile_path'];
        }

        closeCon($conn);
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Condor - Admin Panel</title>
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
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a class="sidebar-toggler text-gray-500 me-4 me-lg-5 lead" href="#"><i class="fas fa-align-left"></i></a><a class="navbar-brand fw-bold text-uppercase text-base" href="index.html"><span class="d-none d-brand-partial">Condor </span><span class="d-none d-sm-inline">Dashboard</span></a>
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
              <div class="dropdown-divider"></div><a class="dropdown-item" href="../user/settings">Settings</a><a class="dropdown-item" href="#">Activity log</a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="../user/logout">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <div class="sidebar py-3" id="sidebar">
        <h6 class="sidebar-heading">Main</h6>
        <ul class="list-unstyled">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted active" href="">
                      <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
                      </svg><span class="sidebar-link-title">Dashboard</span></a></li>
        </ul>
      </div>
      <div class="page-holder bg-gray-100">
        <div class="container-fluid px-lg-4 px-xl-5">
          <section class="mb-3 mb-lg-5">
            <div class="row">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-widget h-100">
                  <div class="card-widget-body">
                    <div class="dot me-3 bg-indigo"></div>
                    <div class="text">
                      <h6 class="mb-0">Total Products Ordered</h6><span class="text-gray-500">
                            <?php
                                $conn = openCon();
                                $query = mysqli_query($conn, "SELECT SUM(quantity) AS total FROM ORDERS;");

                                if($row = mysqli_fetch_array($query))
                                    if($row['total'] == null)
                                        echo  '0 products';
                                    else
                                        echo $row['total'] . ' products';

                                closeCon($conn);
                            ?>
                        </span>
                    </div>
                  </div>
                  <div class="icon text-white bg-indigo"><i class="fas fa-shopping-cart"></i></div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-widget h-100">
                  <div class="card-widget-body">
                    <div class="dot me-3 bg-green"></div>
                    <div class="text">
                      <h6 class="mb-0">Open cases</h6><span class="text-gray-500">32</span>
                    </div>
                  </div>
                  <div class="icon text-white bg-green"><i class="far fa-clipboard"></i></div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-widget h-100">
                  <div class="card-widget-body">
                    <div class="dot me-3 bg-blue"></div>
                    <div class="text">
                      <h6 class="mb-0">Work orders</h6><span class="text-gray-500">400</span>
                    </div>
                  </div>
                  <div class="icon text-white bg-blue"><i class="fa fa-dolly-flatbed"></i></div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-widget h-100">
                  <div class="card-widget-body">
                    <div class="dot me-3 bg-red"></div>
                    <div class="text">
                      <h6 class="mb-0">New invoices</h6><span class="text-gray-500">123</span>
                    </div>
                  </div>
                  <div class="icon text-white bg-red"><i class="fas fa-receipt"></i></div>
                </div>
              </div>
            </div>
          </section>
          <section class="mb-4 mb-lg-5">
            <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Finances 💰</h2>
            <div class="row">
              <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="card h-100">
                  <div class="card-header">
                    <h4 class="card-heading">Your Account Balance</h4>
                  </div>
                  <div class="card-body">
                    <div class="chart-holder w-100">
                      <canvas id="lineChart1"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="h-50 pb-4 pb-lg-2">
                  <div class="card h-100">
                    <div class="card-body d-flex">
                      <div class="row w-100 align-items-center">
                        <div class="col-sm-5 mb-4 mb-sm-0">
                          <h2 class="mb-0 d-flex align-items-center"><span>86.4</span><span class="dot bg-green d-inline-block ms-3"></span></h2><span class="text-muted text-uppercase small">Work hours</span>
                          <hr><small class="text-muted">Hours worked this month</small>
                        </div>
                        <div class="col-sm-7">
                          <canvas id="pieChartHome1"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="h-50 pt-lg-2">
                  <div class="card h-100">
                    <div class="card-body d-flex">
                      <div class="row w-100 align-items-center">
                        <div class="col-sm-5 mb-4 mb-sm-0">
                          <h2 class="mb-0 d-flex align-items-center"><span>325</span><span class="dot bg-indigo d-inline-block ms-3"></span></h2><span class="text-muted text-uppercase small">Tasks Completed</span>
                          <hr><small class="text-muted">Tasks Completed this months</small>
                        </div>
                        <div class="col-sm-7">
                          <canvas id="pieChartHome2"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="mb-4 mb-lg-5">
            <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Updates 🆕 </h2>
            <div class="row">
              <div class="col-lg-7 col-xl-6 mb-5 mb-lg-0">
                <div class="card h-100">
                  <div class="card-header">
                    <h4 class="card-heading">Transaction history</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-gray-500 mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="icon icon-lg shadow me-3 text-gray-700"><i class="fab fa-dropbox"></i></div>
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Dropbox Inc.</span><span class="dot dot-sm ms-2 bg-indigo"></span></h6><small class="text-gray-500">Account renewal</small>
                        </div>
                      </div>
                      <div class="right ms-5 ms-sm-0 ps-3 ps-sm-0">
                        <h5>-$20</h5>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="icon icon-lg shadow me-3 text-gray-700"><i class="fab fa-apple"></i></div>
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>App Store.</span><span class="dot dot-sm ms-2 bg-green"></span></h6><small class="text-gray-500">Software cost</small>
                        </div>
                      </div>
                      <div class="right ms-5 ms-sm-0 ps-3 ps-sm-0">
                        <h5>-$20</h5>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="icon icon-lg shadow me-3 text-gray-700"><i class="fas fa-shopping-basket"></i></div>
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Supermarket.</span><span class="dot dot-sm ms-2 bg-blue"></span></h6><small class="text-gray-500">Shopping</small>
                        </div>
                      </div>
                      <div class="right ms-5 ms-sm-0 ps-3 ps-sm-0">
                        <h5>-$20</h5>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="icon icon-lg shadow me-3 text-gray-700"><i class="fab fa-android"></i></div>
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Play Store.</span><span class="dot dot-sm ms-2 bg-red"></span></h6><small class="text-gray-500">Software cost</small>
                        </div>
                      </div>
                      <div class="right ms-5 ms-sm-0 ps-3 ps-sm-0">
                        <h5>-$20</h5>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="icon icon-lg shadow me-3 text-gray-700"><i class="fab fa-dropbox"></i></div>
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Dropbox Inc.</span><span class="dot dot-sm ms-2 bg-primary"></span></h6><small class="text-gray-500">Account renewal</small>
                        </div>
                      </div>
                      <div class="right ms-5 ms-sm-0 ps-3 ps-sm-0">
                        <h5>-$20</h5>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="icon icon-lg shadow me-3 text-gray-700"><i class="fab fa-apple"></i></div>
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>App Store.</span><span class="dot dot-sm ms-2 bg-blue"></span></h6><small class="text-gray-500">Software cost</small>
                        </div>
                      </div>
                      <div class="right ms-5 ms-sm-0 ps-3 ps-sm-0">
                        <h5>-$20</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 col-xl-6">
                <div class="row h-100">
                  <div class="col-xxl-6">
                    <div class="card-widget mb-4">
                      <div class="card-widget-body">
                        <div class="dot me-3 bg-indigo"></div>
                        <div class="text">
                          <h6 class="mb-0">Completed cases</h6><span class="text-gray-500">127 new cases</span>
                        </div>
                      </div>
                      <div class="icon text-white bg-indigo"><i class="fas fa-clipboard-check"></i></div>
                    </div>
                  </div>
                  <div class="col-xxl-6">
                    <div class="card-widget mb-4">
                      <div class="card-widget-body">
                        <div class="dot me-3 bg-green"></div>
                        <div class="text">
                          <h6 class="mb-0">New Quotes</h6><span class="text-gray-500">214 new quotes</span>
                        </div>
                      </div>
                      <div class="icon text-white bg-green"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                  </div>
                  <div class="col-xxl-6">
                    <div class="card-widget mb-4">
                      <div class="card-widget-body">
                        <div class="dot me-3 bg-blue"></div>
                        <div class="text">
                          <h6 class="mb-0">New clients</h6><span class="text-gray-500">25 new clients</span>
                        </div>
                      </div>
                      <div class="icon text-white bg-blue"><i class="fas fa-user-friends"></i></div>
                    </div>
                  </div>
                  <div class="col-12 order-xxl-1">
                    <div class="card h-100">
                      <div class="card-body">
                        <h2 class="mb-0 d-flex align-items-center"><span>86.4</span><span class="dot bg-red d-inline-block ms-3"></span></h2><span class="text-muted">Daily Profile Visitors</span>
                        <div class="chart-holder w-100">
                          <canvas id="lineChart3"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="mb-4">
            <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Latest Users 👩‍💻</h2>
            <div class="row">
              <div class="col-sm-6 col-xl-12"><a class="message card px-5 py-3 mb-4 bg-hover-gradient-primary text-decoration-none text-reset" href="#">
                  <div class="row">
                    <div class="col-xl-3 d-flex align-items-center flex-column flex-xl-row text-center text-md-left"><strong class="h5 mb-0">24<sup class="text-xs text-gray-500 font-weight-normal ms-1">Apr</sup></strong><img class="avatar avatar-md p-1 mx-3 my-2 my-xl-0" src="img/avatar-1.jpg" alt="..." style="max-width: 3rem">
                      <h6 class="mb-0">Jason Maxwell</h6>
                    </div>
                    <div class="col-xl-9 d-flex align-items-center flex-column flex-xl-row text-center text-md-left">
                      <div class="bg-gray-200 rounded-pill px-4 py-1 me-0 me-xl-3 mt-3 mt-xl-0 text-sm text-dark exclude">User testing</div>
                      <p class="mb-0 mt-3 mt-lg-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                    </div>
                  </div></a></div>
              <div class="col-sm-6 col-xl-12"><a class="message card px-5 py-3 mb-4 bg-hover-gradient-primary text-decoration-none text-reset" href="#">
                  <div class="row">
                    <div class="col-xl-3 d-flex align-items-center flex-column flex-xl-row text-center text-md-left"><strong class="h5 mb-0">24<sup class="text-xs text-gray-500 font-weight-normal ms-1">Nov</sup></strong><img class="avatar avatar-md p-1 mx-3 my-2 my-xl-0" src="img/avatar-2.jpg" alt="..." style="max-width: 3rem">
                      <h6 class="mb-0">Sam Andy</h6>
                    </div>
                    <div class="col-xl-9 d-flex align-items-center flex-column flex-xl-row text-center text-md-left">
                      <div class="bg-gray-200 rounded-pill px-4 py-1 me-0 me-xl-3 mt-3 mt-xl-0 text-sm text-dark exclude">Web Developer</div>
                      <p class="mb-0 mt-3 mt-lg-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                    </div>
                  </div></a></div>
              <div class="col-sm-6 col-xl-12"><a class="message card px-5 py-3 mb-4 bg-hover-gradient-primary text-decoration-none text-reset" href="#">
                  <div class="row">
                    <div class="col-xl-3 d-flex align-items-center flex-column flex-xl-row text-center text-md-left"><strong class="h5 mb-0">17<sup class="text-xs text-gray-500 font-weight-normal ms-1">Aug</sup></strong><img class="avatar avatar-md p-1 mx-3 my-2 my-xl-0" src="img/avatar-3.jpg" alt="..." style="max-width: 3rem">
                      <h6 class="mb-0">Margret Peter</h6>
                    </div>
                    <div class="col-xl-9 d-flex align-items-center flex-column flex-xl-row text-center text-md-left">
                      <div class="bg-gray-200 rounded-pill px-4 py-1 me-0 me-xl-3 mt-3 mt-xl-0 text-sm text-dark exclude">Analysis Agent</div>
                      <p class="mb-0 mt-3 mt-lg-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                    </div>
                  </div></a></div>
              <div class="col-sm-6 col-xl-12"><a class="message card px-5 py-3 mb-4 bg-hover-gradient-primary text-decoration-none text-reset" href="#">
                  <div class="row">
                    <div class="col-xl-3 d-flex align-items-center flex-column flex-xl-row text-center text-md-left"><strong class="h5 mb-0">15<sup class="text-xs text-gray-500 font-weight-normal ms-1">Sep</sup></strong><img class="avatar avatar-md p-1 mx-3 my-2 my-xl-0" src="img/avatar-4.jpg" alt="..." style="max-width: 3rem">
                      <h6 class="mb-0">Jason Doe</h6>
                    </div>
                    <div class="col-xl-9 d-flex align-items-center flex-column flex-xl-row text-center text-md-left">
                      <div class="bg-gray-200 rounded-pill px-4 py-1 me-0 me-xl-3 mt-3 mt-xl-0 text-sm text-dark exclude">User testing</div>
                      <p class="mb-0 mt-3 mt-lg-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                    </div>
                  </div></a></div>
            </div>
          </section>
        </div>
        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-start fw-bold">
                <p class="mb-2 mb-md-0 fw-bold">Condor &copy; 2021</p>
              </div>
              <div class="col-md-6 text-center text-md-end text-gray-400">
                <p class="mb-0">Version 1.1.1</p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="../vendor/back/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Init Charts on Homepage-->
    <script src="../vendor/back/chart.js/Chart.min.js"></script>
    <script src="../js/back/charts-defaults.js"></script>
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
            $.ajax({
                url: "../controllers/charts.php",
                dataType: 'json',
                success: function(response) {

                    console.log(response);

                    var lineChart1 = new Chart(document.getElementById("lineChart1"), {
                        type: "line",
                        options: {
                            tooltips: {
                                mode: "index",
                                intersect: false,
                                callbacks: {
                                    label: function (tooltipItems, data) {
                                        return "$" + tooltipItems.yLabel.toString();
                                    },
                                },
                            },
                            hover: {
                                mode: "nearest",
                                intersect: true,
                            },
                            scales: {
                                xAxes: [
                                    {
                                        gridLines: {
                                            display: false,
                                            drawBorder: false,
                                        },
                                    },
                                ],
                                yAxes: [
                                    {
                                        gridLines: {
                                            display: false,
                                            drawBorder: false,
                                        },
                                    },
                                ],
                            },

                            legend: {
                                display: false,
                            },
                        },
                        data: {
                            labels: response.labels,
                            datasets: [
                                {
                                    label: "Your Account Balance",
                                    fill: true,
                                    lineTension: 0.4,
                                    backgroundColor: "transparent",
                                    borderColor: window.colors.blue,
                                    pointBorderColor: window.colors.blue,
                                    pointHoverBackgroundColor: window.colors.blue,
                                    borderCapStyle: "butt",
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: "miter",
                                    borderWidth: 3,
                                    pointBackgroundColor: "blue",
                                    pointBorderWidth: 5,
                                    pointHoverRadius: 5,
                                    pointHoverBorderColor: "#fff",
                                    pointHoverBorderWidth: 1,
                                    pointRadius: 0,
                                    pointHitRadius: 1,
                                    data: response.chartData,
                                    spanGaps: false,
                                },
                            ],
                        },
                    });
                }
            });
        });


    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>
