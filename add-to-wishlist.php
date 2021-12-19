<?php 
require_once("controllers/database/connection.php");
$con = openCon();
session_start();

if (!isset($_SESSION['id'])){
	header('location: user/login');
	exit;
}
$userid=$_SESSION['id'];
	$product=base64_decode($_GET['productid']);
	$result = mysqli_query($con, "select * from wishlist where users_id=$userid and products_id = $product");
	if (mysqli_num_rows($result)==false){
	mysqli_query($con, "INSERT into wishlist values('$userid','$product')") or die("Error: " . mysqli_error($con));
}
	closeCon($con);
	header("Location: wishlist1.php");

	  ?>