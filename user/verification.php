<?php
session_start();

include('../controllers/database/connection.php');

if(isset($_GET['id']) && isset($_GET['code']) && !empty($_GET['id']) && !empty($_GET['code'])) {
    if(isset($_SESSION['verified']) && $_SESSION['verified'] === false) {
        $conn = openCon();

        $userId = $_GET['id'];
        $sql = "SELECT verifCode FROM USERS WHERE id=" . $userId . ";";
        $query = mysqli_query($conn, $sql);

        while($row= mysqli_fetch_array($query)){
	       if($row['verifCode'] == $_GET['code']) {

               $updateSQL = "UPDATE USERS SET verified=1 WHERE id=" . $userId . ";";
               mysqli_query($conn, $updateSQL);

               $currentTime = date("Y-m-d H:i:s");
               $insertToTimeline = mysqli_query($conn, "INSERT INTO users_timeline VALUES('$userId', 'I just verified my account through my email! :)', '$currentTime');");

               $_SESSION['verified'] = true;

               header('location: ../');
               return;
           }
        }

        closeCon($conn);
    }
}
header('location: ../error.php?code=404');
exit;
?>
