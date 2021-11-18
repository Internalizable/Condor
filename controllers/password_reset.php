<?php
include ('database/connection.php');

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $data = array();
    $conn = openCon();

    $token = testInput($_POST['token'], $conn);
    $password = testInput($_POST['password'], $conn);
    $confirmPassword = testInput($_POST['confirmPassword'], $conn);

    if(empty($token)) {
        $data['success'] = false;
        $data['name'] = 'token';
        $data['message'] = 'Token cannot be empty.';
    } else if(empty($password)) {
        $data['success'] = false;
        $data['name'] = 'resetPassword';
        $data['message'] = 'Password cannot be empty.';
    } else if(empty($confirmPassword)) {
        $data['success'] = false;
        $data['name'] = 'confirmPassword';
        $data['message'] = 'Password cannot be empty.';
    } else if($password != $confirmPassword) {
        $data['success'] = false;
        $data['name'] = 'confirmPassword';
        $data['message'] = 'Passwords do not match';
    } else {
        $duplicate = mysqli_query($conn, "SELECT id FROM USERS WHERE resetToken='$token'");

        if (mysqli_num_rows($duplicate) == 1) {
            if ($row = mysqli_fetch_array($duplicate)) {
                $id = $row['id'];

                $password = md5($password);
                $password = sha1($password);
                $salt = "ka12n3cma993834canzk4la";

                $password = crypt($password,$salt);
-
                $query = mysqli_query($conn, "UPDATE USERS SET resetToken=NULL, resetExpiry=NULL, pwd='$password' WHERE id='$id'");

                session_destroy();
                setcookie('pwdReset', "", time() - 3600);

                $data['success'] = true;
            }
        } else {
            $data['success'] = false;
            $data['name'] = 'token';
            $data['message'] = 'Token is invalid';
        }
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
