<?php
include("controllers/database/connection.php");
$con=openCon();

$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$email = $_POST['email'];
$phone_number = $_POST['phone'];
$company_name= $_POST['company'];
$country = $_POST['country'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$zip = $_POST['zip'];
$usersid = $_POST['usersid'];
$coupon = $_POST['coupon'];
$date = date('Y-m-d H:i:s');

// if ($coupon=='0')
//     $coupon=NULL;

mysqli_query($con,"insert into billing_information (first_name, last_name, email, phone_number, company_name, country, address, address2, city, zip) values('$first_name', '$last_name', '$email', '$phone_number', '$company_name', '$country', '$address', '$address2', '$city', '$zip')");
$billing_id = mysqli_insert_id($con);

$cart = mysqli_query($con, "select * from cart where users_id=$usersid");

$query = mysqli_query($con, "select max(ordersid) as maxid from orders");
if (mysqli_num_rows($query)==false){
    $id = 1;
}
else {
    $rquery= mysqli_fetch_array($query);
    $id=$rquery['maxid']+1;
}

while ($rcart = mysqli_fetch_array($cart)){
    $product = mysqli_query($con, "select * from products where id=$rcart[products_id]");
    while ($rproduct = mysqli_fetch_array($product)){
        // mysqli_query($con,"insert into orders (users_id, products_id, orderDate, quantity, unitPrice, billing_information_id, discountPerc, coupons_coupon) values ($usersid, $rcart[products_id],$date,$rcart[quantity],$rproduct[price],$billing_id,$rproduct[salePercentage],'$coupon')");
        // mysqli_query($con,"insert into orders (users_id, products_id, quantity, unitPrice, billing_information_id, discountPerc) values ($usersid, $rcart[products_id],$rcart[quantity],$rproduct[price],$billing_id,$rproduct[salePercentage])");

        if ($coupon != '0'){
            mysqli_query($con,"insert into orders (ordersid, users_id, products_id, orderDate, quantity, unitPrice, billing_information_id, discountPerc, coupons_coupon) values ($id, $usersid, $rcart[products_id], '$date',$rcart[quantity],$rproduct[price],$billing_id,$rproduct[salePercentage],'$coupon')");
        }
        else {
            mysqli_query($con,"insert into orders (ordersid, users_id, products_id, orderDate, quantity, unitPrice, billing_information_id, discountPerc) values ($id, $usersid, $rcart[products_id], '$date',$rcart[quantity],$rproduct[price],$billing_id,$rproduct[salePercentage])");
        }
    }
    mysqli_query($con, "update products set quantity = quantity - $rcart[quantity] where id = $rcart[products_id]");
}

mysqli_query($con, "delete from cart where users_id = $usersid");


?>
