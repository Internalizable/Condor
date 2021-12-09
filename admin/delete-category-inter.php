<?php
	require_once("../controllers/database/connection.php");
	  $con = openCon();
      $category_id=base64_decode($_GET["id"]);

	  $check_if_parent=mysqli_query($con,"select * from categories where id=".$category_id);
	  while($row=mysqli_fetch_array( $check_if_parent))
	  {
				if($row['parent_id']==null)
				{
					mysqli_query($con,"update categories set isDeleted=1 where parent_id=".$category_id);
				}
	  }

      $delete_query=mysqli_query($con,"update categories set isDeleted=1 where id=".$category_id);

	 


		header("Location:view-categories.php");
	




?>