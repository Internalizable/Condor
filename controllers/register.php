<?php

include ('database/connection.php');

session_start();

// initializing variables
$fname = "";
$lname = "";
$username = "";
$city = "";
$country = "";
$zip = "";
$email = "";
$password = "";
$confirmPassword = "";

    $data = array();

    $conn = openCon();

    $fname = testInput(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = testInput(mysqli_real_escape_string($conn, $_POST['lname']));
    $username = testInput(mysqli_real_escape_string($conn, $_POST['username']));
    $city = testInput(mysqli_real_escape_string($conn, $_POST['city']));
    $country = testInput(mysqli_real_escape_string($conn, $_POST['country']));
    $zip = testInput(mysqli_real_escape_string($conn, $_POST['zip']));
    $email = testInput(mysqli_real_escape_string($conn, $_POST['email']));
    $password = testInput(mysqli_real_escape_string($conn, $_POST['password']));
    $confirmPassword = testInput(mysqli_real_escape_string($conn, $_POST['confirmPassword']));

    if(empty($fname)) {
        $data['success'] = false;
        $data['name'] = 'fname';
        $data['message'] = 'First name cannot be empty.';
    } else if(empty($lname)) {
        $data['success'] = false;
        $data['name'] = 'lname';
        $data['message'] = 'Last name cannot be empty.';
    } else if(empty($username)) {
        $data['success'] = false;
        $data['name'] = 'lname';
        $data['message'] = 'Username cannot be empty.';
    } else if(empty($city)) {
        $data['success'] = false;
        $data['name'] = 'city';
        $data['message'] = 'City cannot be empty.';
    } else if(empty($country)) {
        $data['success'] = false;
        $data['name'] = 'country';
        $data['message'] = 'Country cannot be empty.';
    } else if(empty($zip)) {
        $data['success'] = false;
        $data['name'] = 'zip';
        $data['message'] = 'Zip code cannot be empty.';
    } else if(empty($email)) {
        $data['success'] = false;
        $data['name'] = 'email';
        $data['message'] = 'Email cannot be empty.';
    } else if(empty($password)) {
        $data['success'] = false;
        $data['name'] = 'password';
        $data['message'] = 'Password cannot be empty.';
    } else if(empty($confirmPassword)) {
        $data['success'] = false;
        $data['name'] = 'confirmPassword';
        $data['message'] = 'Confirm Password cannot be empty.';
    } else if(preg_match('/^[a-zA-Z0-9._-]{2,}@[a-zA-Z0-9.-]{2,}\.[a-zA-Z]{2,}$/', $email) != 1) {
        $data['success'] = false;
        $data['name'] = 'email';
        $data['message'] = 'Email is not well formatted';
    } else if($password !== $confirmPassword) {
        $data['success'] = false;
        $data['name'] = 'confirmPassword';
        $data['message'] = 'Password is not the same';
    } else {
        $duplicate = mysqli_query($conn,"SELECT * FROM USERS WHERE username='$username'");

        if (mysqli_num_rows($duplicate) > 0) {
            $data['success'] = false;
            $data['name'] = 'username';
            $data['message'] = 'Username already exists!';
        } else {
            $duplicate = mysqli_query($conn,"SELECT * FROM USERS WHERE email='$email'");

            if (mysqli_num_rows($duplicate) > 0) {
                $data['success'] = false;
                $data['name'] = 'email';
                $data['message'] = 'Email already exists!';
            } else {
                $sql = "INSERT INTO USERS VALUES (0, '$username','$email','$password','$fname','$lname','$city','$country','$zip');";

                if (mysqli_query($conn, $sql)) {
                    $data['success'] = true;
                }
            }
        }
    }


    closeCon($conn);
	
    echo json_encode($data);

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
