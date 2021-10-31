<?php
session_start();

include ('controllers/database/connection.php');

if(isset($_GET['id']) && isset($_GET['code']) && !empty($_GET['id']) && !empty($_GET['code'])) {
    if(isset($_SESSION['verified']) && $_SESSION['verified'] === false) {
        $conn = openCon();

        $sql = "SELECT verifCode FROM USERS WHERE id=" . $_GET['id'] . ";";
        $query = mysqli_query($conn, $sql);

        while($row= mysqli_fetch_array($query)){
	       if($row['verifCode'] == $_GET['code']) {

               $updateSQL = "UPDATE USERS SET verified=1 WHERE id=" . $_GET['id'] . ";";
               mysqli_query($conn, $updateSQL);

               $_SESSION['verified'] = true;

               header('location: index.php');
               return;
           }
        }

        closeCon($conn);
    }
}
header('location: error.php');
exit;
?>
