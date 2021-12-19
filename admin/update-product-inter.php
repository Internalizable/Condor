<?php
	require_once("../controllers/database/connection.php");
	  $con = openCon();
	date_default_timezone_set("Asia/Beirut");
	if(isset($_POST["submit"])){


        $product_id=$_POST['productId'];
		$product_name=$_POST['productName'];
        $product_desc=$_POST['productDesc'];
		$product_category =$_POST['productCat'];
        $product_main_price=$_POST['productMainPrice'];
        $product_percentage=$_POST['productPercentage'];
        $product_quantity=$_POST['productQuantity'];
        $product_tags =      explode(',', $_POST['productTags']);


        $val_tag_array="";


        $getProdValues = mysqli_query($con, "SELECT * from products WHERE id =".$product_id);
		$val_prod = mysqli_fetch_array($getProdValues);

        $getCatValues=mysqli_query($con, "SELECT * from products_categories WHERE products_id =".$product_id);
        $val_cat= mysqli_fetch_array($getCatValues);

        $getTagValues=mysqli_query($con, "SELECT * from products_tags WHERE products_id =".$product_id);
        while($val_tag= mysqli_fetch_array($getTagValues))
        {
            $val_tag_array.=$val_tag['tags_tag'].",";

        }
        $val_tag_array=substr($val_tag_array, 0, -1); //existing values in the db


        $getMediaValues=mysqli_query($con, "SELECT * from products_media WHERE products_id =".$product_id);
        $val_media= mysqli_fetch_array($getMediaValues);


		if(mysqli_num_rows($getProdValues)<0){

			echo"<p>error</p>";
		}
		else
        {
            $prodValues = "";
            $tagValues = "";
            $mediaValues = "";

            if($product_name !=$val_prod["name"])
            {
                $prodValues .="name = '$product_name',";
            }
            if($product_desc !=$val_prod["description"])
            {
                $prodValues .="description = '$product_desc',";
            }
            if($product_category !=$val_cat["categories_id"])
            {
                $product_category=$product_category;
            }
            if($product_main_price !=$val_prod["price"])
            {
                $prodValues .="price = '$product_main_price',";
            }
            if($product_percentage !=$val_prod["salePercentage"])
            {
                $prodValues .="salePercentage = '$product_percentage',";
            }
            if($product_quantity !=$val_prod["quantity"])
            {
                $prodValues .="quantity = '$product_quantity',";
            }
            if($product_tags !=$val_tag_array)
            {
                $tagValues =$val_tag_array;
            }



			/*insertion into products*/
             $prodValues=substr($prodValues, 0, -1);
			mysqli_query($con, "UPDATE products set $prodValues where id=".$product_id);

			/*insertion into products_categories*/
            //$product_id=mysqli_insert_id($con);
			 mysqli_query($con,"UPDATE products_categories SET categories_id=$product_category where products_id =".$product_id);


			/*insertion into media*/

			/******uploading section********/

			  $uploadsDir = "../img/back/product/";
              $allowedFileType = array('jpg','png','jpeg');

        // Velidate if files exist
        if (!empty(array_filter($_FILES["productImg"]["name"]))) {

            // Loop through file items
            foreach($_FILES["productImg"]["name"] as $id=>$val){
                // Get files upload path
                $random=rand();
                $fileName        = $_FILES["productImg"]["name"][$id];
                $tempLocation    = $_FILES["productImg"]['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $new_img_name=$uploadsDir."product-".  $product_id."-".$random.".".$fileType;



                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation,  $new_img_name)){
                            $sqlVal = "img/back/product/product-".  $product_id."-".$random.".".$fileType;


                        }
                }

              if(!empty($sqlVal)) {
                //    $insert = mysqli_query($con,"INSERT INTO media VALUES ('$sqlVal');");
                   $insert2=mysqli_query($con,"INSERT INTO products_media VALUES ( '$product_id','$sqlVal');");

            }
            }//end of foreach








}

			/********************************/

            /*insertion into tags*/

           // $product_tags is coming from post

                if($product_tags != $val_tag_array ) //if the admin changed sth
                {




           $sqltag="";
           $sqlprodtag="";
           foreach ($product_tags as $tag_name){
                //modify below to add $id along with $tag_name
                  $sqltag.="('{$tag_name}'),";
                  $sqlprodtag.="('{$product_id}','{$tag_name}'),";


            }//end of foreach

                if($sqltag!="" &&   $sqlprodtag!="" ){
                        //rtrim to remove last ',' from string.
                          $sqltag=substr($sqltag, 0, -1);
                          $sqlprodtag=substr( $sqlprodtag, 0, -1);


                 }

                 /*$checkTag=mysqli_query($con,"select * from tags where tag in ('". implode(',', $product_tags) . "')");

                 if(mysqli_num_rows($checkTag)==0){
                      $sqltag="INSERT INTO tags VALUES {$sqltag};";
				 }*/

                     //delete the existing tags (in products_tags only)
                 $deleteOld="DELETE from products_tags where products_id=".$product_id;
                 $deleteRes=mysqli_query($con, $deleteOld);

               //  and insert the new ones
            $sqlprodtag="INSERT INTO products_tags VALUES {$sqlprodtag};";
            $insert_into_tag=mysqli_query($con,$sqltag);
            $insert_into_prod_tag=mysqli_query($con, $sqlprodtag);
        }









			closeCon($con);
            //echo"SQLTAG: $sqltag   SQLPRODTAGS: $sqlprodtag ";
            //echo" product_tags:".implode(',', $product_tags);


         /*   while($resss=mysqli_fetch_array($checkTag))
            {
            echo" check_tag_query:".$resss['tag'] ;

            }
          */

         header("Location:view-products.php");



        }
    }


else {
		header("Location:update-product.php?error=2");
	}




?>
