<?php
$orderid = $_GET['id'];
$billing_id = $_GET['b_id'];
include("controllers/database/connection.php");
$con=openCon();


header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=Order_".$orderid."_condor.csv");


ob_end_clean(); // gets rid of all output buffers

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

$orders = mysqli_query ($con, "Select * from orders where ordersid = $orderid");

$users = mysqli_query ($con, "Select * from billing_information where id=$billing_id");
$rusers = mysqli_fetch_assoc($users);

// output the column headings
fputcsv($output, array('Condor'));
fputcsv($output, array(''));
fputcsv($output, array('Order', $orderid));
fputcsv($output, array(''));
fputcsv($output, array('First Name', 'Last Name', 'Phone Number', 'Address'));
fputcsv ($output, array($rusers['first_name'],$rusers['last_name'], $rusers['phone_number'], $rusers['address']));
fputcsv($output, array(''));
fputcsv($output, array(''));

fputcsv($output, array('Product', 'Price','Discount', 'Quantity', 'Total'));

$total=0;
$coupon = null;

while ($rorders=mysqli_fetch_array($orders)){
    $coupon = $rorders["coupons_coupon"];
    $totalperproduct = 0;
    $price=0;
    $price = $rorders["unitPrice"]*(1-($rorders["discountPerc"]/100));
    $totalperproduct = $price * $rorders["quantity"];
    $total = $total + $totalperproduct;
    $products = mysqli_query($con, "select name from products where id = $rorders[products_id]");
    $rproducts = mysqli_fetch_array($products);

    fputcsv($output, array($rproducts['name'], $price,$rorders["discountPerc"], $rorders['quantity'], $totalperproduct));
}
$finaltotal = $total;

if ($coupon!=null){
    $cpn = mysqli_query($con, "select * from coupons where coupon = $coupon");
    $rcpn = mysqli_fetch_array($cpn);
    $finaltotal = $total*(1-($rcpn['percentage']/100));
    fputcsv($output, array('Coupon', $coupon, 'Percentage (%)', $rcpn['percentage']));
    fputcsv($output, array('Total without coupon', $total));

  }
  fputcsv($output, array(''));

    fputcsv($output, array('Total', $finaltotal));
    fputcsv($output, array(''));
    fputcsv($output, array(''));
    fputcsv($output, array('Email','Country','City','Zip'));

    fputcsv ($output, array($rusers['email'],$rusers['country'], $rusers['city'], $rusers['zip']));



// fetch the data
//$rows = mysqli_query($con,"SELECT CompanyName, ContactName, ContactTitle, City from customers WHERE CompanyName LIKE \"%a%\"");

// loop over the rows, outputting them
// while ($row = mysqli_fetch_assoc($rows)){ 
// 	//fputcsv($output, $row);
// 	fputcsv($output, array($row['CompanyName'], $row['ContactName'], $row['ContactTitle'], $row['City']));
// }
exit();
?>