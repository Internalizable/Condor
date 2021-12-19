<?php

if (isset($_POST["users_id"]) && isset($_POST["products_id"]) && isset($_POST["quantity"]) && isset($_POST["totalquantity"])){
include("controllers/database/connection.php");
  $con=openCon();
  $users_id = $_POST["users_id"];
  $products_id = $_POST["products_id"];
  $quantity = $_POST["quantity"];
  $totalquantity = $_POST["totalquantity"];

  $product = mysqli_query($con, "select * from cart where products_id = $products_id and users_id = $users_id");
  if (mysqli_num_rows($product)==false){
  mysqli_query($con, "insert into cart values ($users_id, $products_id, $quantity)");
  echo "<div id='txtVal'><span style='color: green;'>Added to cart</span></div>";
  }
  else{
      $rproduct = mysqli_fetch_array($product);
      if ($rproduct["quantity"]+$quantity>$totalquantity)
        echo "<div id='txtVal'><span style='color: red;'>Not enough quantity in stock.</span></div>";
        else {
      mysqli_query($con, "update cart set quantity = quantity + $quantity where users_id = $users_id and products_id = $products_id");
      echo "<div id='txtVal'><span style='color: green;'>Product already exists in cart, quantity added.</span></div>";
    }
}
}

?>