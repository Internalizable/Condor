<?php
	require_once("../controllers/database/connection.php");
    $conn = openCon();
	date_default_timezone_set("Asia/Beirut");
	if(isset($_POST["submit"])){
		$product_name=$_POST['productName'];
        $product_desc=$_POST['productDesc'];
        $product_categor =$_POST['productCat'];
        $product_main_price=$_POST['productMainPrice'];
        $product_percentage=$_POST['productPercentage'];
        $product_quantity=$_POST['productQuantity'];
        $product_category=$_POST['productCat'];
		$productCheck = mysqli_query($conn,"Select name from products WHERE name='$product_name';");

		if(mysqli_num_rows($productCheck)>0){
			header("Location:e-commerce-product-new.php?error=1");
		}
		else
        {


			mysqli_query($conn, "INSERT INTO products(id, name, price, desc, quantity, salePercentage) VALUES(0, '$product_name', '$product_main_price', '$product_desc', '$product_quantity', '$product_percentage');"
			);
           // $product_id=mysqli_insert_id($conn);
           /* mysqli_query($conn,"INSERT INTO products_categories (products_id, categories_id)
            VALUES ('$product_id', '$product_category');");*/

			closeCon($conn);

            header("Location:e-commerce-product-new.php?success");


        }

	}

else {
		header("Location:e-commerce-product-new.php");
	}




?>
