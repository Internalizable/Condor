<?php
	require_once("../controllers/database/connection.php");
	  $conn = openCon();
	date_default_timezone_set("Asia/Beirut");
	if(isset($_POST["submit"])){
			
		  
		if ($_POST['parentCat'] === "")
                    {
                        $_POST['parentCat'] = 'NULL';
                    }

		$category_name=$_POST['categoryName'];
		$parent_category =$_POST['parentCat'];

       
		$categoryCheck = mysqli_query($conn,"Select name from categories WHERE name='$category_name';");

		if(mysqli_num_rows($categoryCheck)>0){
			
			header("Location:e-commerce-category-new.php?error=1");
		}
		else
        {
	
			/*insertion into categories*/
			mysqli_query($conn, "INSERT INTO categories VALUES(0,'$category_name', $parent_category,0);"
			);
		
			

		







			closeCon($conn);

            header("Location:e-commerce-category-new.php?success");


        }
    }
    

else {
		header("Location:e-commerce-category-new.php");
	}




?>