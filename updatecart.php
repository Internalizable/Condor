<?php
    if (isset($_POST['id']) && isset($_POST['quantity'])){
        include("controllers/database/connection.php");
        $con=openCon();
        mysqli_query($con, "update cart set quantity=$_POST[quantity] where products_id=$_POST[id]");
        $product = mysqli_query($con, "select * from products where products_id=$_POST[id]");
        $product = mysqli_fetch_array($product);

    }


?>