<?php
	require_once("../controllers/database/connection.php");
	  $conn = openCon();
	date_default_timezone_set("Asia/Beirut");
	if(isset($_POST["submit"])){
			
		  

		$product_name=$_POST['productName'];
        $product_desc=$_POST['productDesc'];
		$product_category =$_POST['productCat'];
        $product_main_price=$_POST['productMainPrice'];
        $product_percentage=$_POST['productPercentage'];
        $product_quantity=$_POST['productQuantity'];
        $product_tags_array = explode(',', $_POST['productTags']);
		$productCheck = mysqli_query($conn,"Select name from products WHERE name='$product_name';");

		if(mysqli_num_rows($productCheck)>0){
			
			header("Location:e-commerce-product-new.php?error=1");
		}
		else
        {
	
			/*insertion into products*/
			mysqli_query($conn, "INSERT INTO products VALUES(0,'$product_name', '$product_main_price' , '$product_desc', '$product_quantity' , CURRENT_TIMESTAMP , '$product_percentage',0);");

			/*insertion into products_categories*/
            $product_id=mysqli_insert_id($conn);
			 mysqli_query($conn,"INSERT INTO products_categories
            VALUES ('$product_id', '$product_category');");
			

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
                            $sqlVal = "product-".  $product_id."-".$random.".".$fileType;
                           
                            
                            
                        } 
                    
                }
              if(!empty($sqlVal)) {
                    //$insert = mysqli_query($conn,"INSERT INTO media VALUES ('$sqlVal');");
                   $insert2=mysqli_query($conn,"INSERT INTO products_media VALUES ( '$product_id','$sqlVal');");
                 
                   
                  
            }
            }//end of foreach


   

  
  


}

			/*******************************/

            /*insertion into tags*/

      
           $sqltag=""; 
           $sqlprodtag="";   
           foreach($product_tags_array as $tag_name){
                //modify below to add $id along with $tag_name
                  $sqltag.="('{$tag_name}'),";
                  $sqlprodtag.="('{$product_id}','{$tag_name}'),";
              
            


                

            }//end of foreach
            
                if($sqltag!="" &&   $sqlprodtag!="" ){
                        //rtrim to remove last ',' from string. 
                          $sqltag=substr($sqltag, 0, -1);
                          $sqlprodtag=substr( $sqlprodtag, 0, -1);
                 
                 
                 }

                 $checkTag=mysqli_query($conn,"select * from tags where tag in (" . implode(',', $product_tags_array) . ")");
                 if(mysql_num_rows($checkTag)==0){
                      $sqltag="INSERT INTO tags VALUES {$sqltag};";
				 }
          
            $sqlprodtag="INSERT INTO products_tags VALUES {$sqlprodtag};";
            $insert_into_tag=mysqli_query($conn,$sqltag);
            $insert_into_prod_tag=mysqli_query($conn, $sqlprodtag);










			closeCon($conn);

            header("Location:e-commerce-product-new.php?success");


        }
    }
    

else {
		header("Location:e-commerce-product-new.php");
	}




?>