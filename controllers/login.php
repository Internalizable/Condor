<?php
include ('database/connection.php');

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $data = array();
    $conn = openCon();

    $username = testInput($_POST['username'], $conn);
    $password = testInput($_POST['password'], $conn);

    if(empty($username)) {
        $data['success'] = false;
        $data['name'] = 'username';
        $data['message'] = 'Username cannot be empty.';
    } else if(empty($password)) {
        $data['success'] = false;
        $data['name'] = 'password';
        $data['message'] = 'Password cannot be empty.';
    } else {
        $duplicate = mysqli_query($conn, "SELECT id, username, pwd, verified, admin FROM USERS WHERE username='$username'");

        if (mysqli_num_rows($duplicate) == 1) {
            while ($row = mysqli_fetch_array($duplicate)) {
                $password = md5($password);
                $password = sha1($password);
                $salt = "ka12n3cma993834canzk4la";

                $password = crypt($password,$salt);

                $data['oldpass'] = $password;
                $data['newpass'] = $row["pwd"];

                if($password == $row["pwd"]) {
                    $data['success'] = true;

                    $_SESSION['loggedin'] = true;
                    $_SESSION['verified'] = boolval($row["verified"]);
                    $_SESSION['id'] = $row["id"];
                    $_SESSION['admin'] = boolval($row['admin']);

                } else {
                    $data['success'] = false;
                    $data['name'] = 'password';
                    $data['message'] = 'Password is invalid';
                }
            }
        } else {
            $data['success'] = false;
            $data['name'] = 'username';
            $data['message'] = 'Username is invalid';
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
