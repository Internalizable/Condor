<?php
require_once("controllers/database/connection.php");
$con = openCon();	
	
session_start();

if (!isset($_SESSION['id'])){
	header('location: user/login');
	exit;
}
$userid=$_SESSION['id'];
$pid=base64_decode($_GET["productid"]);
	mysqli_query($con, "DELETE from wishlist where users_id=$userid and products_id=$pid") or die("Error: " . mysqli_error($con));
	closeCon($con);
	header("Location: wishlist1.php");
?>