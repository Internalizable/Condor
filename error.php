<!DOCTYPE html>
<html>
<head>
 <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
 <style>
@import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");
*,
*:after,
*:before {
  box-sizing: border-box;
}

body {
  background-color: #313942;
  font-family: "Montserrat", sans-serif;
}

main {
  align-items: center;
  display: flex;
  flex-direction: column;
  height: 100vh;
  justify-content: center;
  text-align: center;
}

h1 {
  color: #e7ebf2;
  font-size: 12.5rem;
  letter-spacing: 0.1em;
  margin: 0.025em 0;
  text-shadow: 0.05em 0.05em 0 rgba(0, 0, 0, 0.25);
  white-space: nowrap;
}
@media (max-width: 30rem) {
  h1 {
    font-size: 8.5rem;
  }
}
h1 > span {
  -webkit-animation: spooky 2s alternate infinite linear;
          animation: spooky 2s alternate infinite linear;
  color: #528cce;
  display: inline-block;
}

h2 {
  color: #e7ebf2;
  margin-bottom: 0.4em;
}

p {
  color: #ccc;
  margin-top: 0;
}

@-webkit-keyframes spooky {
  from {
    transform: translatey(0.15em) scaley(0.95);
  }
  to {
    transform: translatey(-0.15em);
  }
}

@keyframes spooky {
  from {
    transform: translatey(0.15em) scaley(0.95);
  }
  to {
    transform: translatey(-0.15em);
  }
}
</style>
</head>

<?php
    if(!isset($_GET['code']))
        $_GET['code'] = 404;
?>
<body>

<main>
  <h1><span><i class="fas fa-ghost"></i></span></h1>
  <h2>Error: <?php echo $_GET['code'] ?></h2>

  <p>
      <?php
        switch($_GET['code']) {
            case 404:
                echo 'The requested page could not be found.';
                break;
            case 403:
                echo 'You are not allowed to access this page.';
                break;
        }
      ?>
  </p>
</main>


</body>
</html>

