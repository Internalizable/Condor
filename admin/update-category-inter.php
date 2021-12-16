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
		$category_id=$_GET['id'];


		$old_values=mysqli_query($conn,"SELECT * from categories where id=".$category_id);
		$old_values_row=mysqli_fetch_array($old_values);
       
	

	
					if($old_values_row['name']!= $category_name )
					{
						mysqli_query($conn, "UPDATE categories SET name ='".$category_name."' WHERE id=".$category_id);
					}

					if($old_values_row['parent_id']!= $parent_category )
					{
						mysqli_query($conn, "UPDATE categories SET parent_id =$parent_category WHERE id=".$category_id);
					}
	
		
		
			

		







			closeCon($conn);

            header("Location:view-categories.php");


        
    }
    

else {
		//header("Location:e-commerce-category-new.php");
	}




?>