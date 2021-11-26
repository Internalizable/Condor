<?php
include ('database/connection.php');

session_start();

if(isset($_POST['message']) && isset($_SESSION['id'])){

    $data = array();
    $conn = openCon();

    $message = testInput($_POST['message'], $conn);
    $userId = $_SESSION['id'];

    if(empty($message)) {
        $data['success'] = false;
        $data['message'] = 'Message empty.';
    } else {
        $currentTime = date("Y-m-d H:i:s");
        $insertToTimeline = mysqli_query($conn, "INSERT INTO users_timeline VALUES('$userId', '$message', '$currentTime');");

        $data['success'] = true;
    }

    closeCon($conn);
    echo json_encode($data);
}

function testInput($data, $conn) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return mysqli_real_escape_string($conn, $data);
}
?>
