<?php

if (isset($_POST["users_id"]) && isset($_POST["products_id"]) ){
include("controllers/database/connection.php");
  $con=openCon();
  $users_id = $_POST["users_id"];
  $products_id = $_POST["products_id"];
  mysqli_query($con,"delete from cart where users_id = $users_id and products_id = $products_id");
}

?>