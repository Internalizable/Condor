<?php
	require_once("../controllers/database/connection.php");
	  $con = openCon();
      $product_id=base64_decode($_GET["id"]);

      $delete_query=mysqli_query($con,"update products set isDeleted=1 where id=".$product_id);


		header("Location:view-products.php");
	




?>