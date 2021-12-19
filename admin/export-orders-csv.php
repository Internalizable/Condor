<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CSV</title>
</head>

<body>
<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=order#'.$_GET['order'].'.csv');
require_once("../controllers/database/connection.php");
$con = openCon();
$order_id=$_GET['order'];
$user_id=$_GET['user'];
$original_total=0;
$result = mysqli_query($con, "select * from orders where ordersid=".$order_id);
if (mysqli_num_rows ($result)==false)
{
	echo"No results found!";
}
else{
ob_end_clean(); // gets rid of all output buffers
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
fputcsv($output, array('Order ID: ',$order_id));
fputcsv($output, array(''));
//$row = mysqli_fetch_array($result);
$user_query=mysqli_query($con,"select * from users where id=".$user_id);
$user_row=mysqli_fetch_array($user_query);

fputcsv($output, array('Customer Name : ',$user_row['firstname'].' '.$user_row['lastname']));
fputcsv($output, array(''));
fputcsv($output, array('Product Name', 'Unit Price', 'Quantity', 'Total', 'Discount', 'Total after Discount'));

while($row = mysqli_fetch_array($result))
{
$coupon_query=mysqli_query($con,"select * from coupons where coupon='".$row['coupons_coupon']."'");
$coupon_row=mysqli_fetch_array($coupon_query);

$product_query=mysqli_query($con,"select * from products where id=".$row['products_id']);
$product_row=mysqli_fetch_array($product_query);
$discount_value=$row["unitPrice"]*$row["quantity"]*0.01*$row['discountPerc'];
$total=($row["unitPrice"]*$row["quantity"])-$discount_value; 
fputcsv($output, array($product_row["name"], $row["unitPrice"], $row["quantity"],($row["unitPrice"]*$row["quantity"]),( $discount_value ),$total)); 
$original_total+=$total;
}
fputcsv($output, array(''));
fputcsv($output, array('Original Total = ',$original_total));
fputcsv($output, array('Applied Coupon : ',$coupon_row['coupon']));
$coupon_discount_value=$coupon_row['percentage']*0.01*$original_total;
fputcsv($output, array('Coupon Discount = ',$coupon_discount_value));
fputcsv($output, array('Net Total = ',$original_total-$coupon_discount_value));
mysqli_close($con);
}
exit();


?>
</body>
</html>