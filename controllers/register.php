<?php

include ('database/connection.php');
require_once 'captcha/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

define("RECAPTCHA_V3_SECRET_KEY", '6LeWZNocAAAAAHTc8R3IH_NN28nmq20sdIsYd2vW');

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = array();

    $conn = openCon();

    $fname = testInput($_POST['fname'], $conn);
    $lname = testInput($_POST['lname'], $conn);
    $username = testInput($_POST['username'], $conn);
    $city = testInput($_POST['city'], $conn);
    $country = testInput($_POST['country'], $conn);
    $zip = testInput($_POST['zip'], $conn);
    $email = testInput($_POST['email'], $conn);
    $password = testInput($_POST['password'], $conn);
    $confirmPassword = testInput($_POST['confirmPassword'], $conn);

    $token = $_POST['token'];
    $action = $_POST['action'];

    if (empty($fname)) {
        $data['success'] = false;
        $data['name'] = 'fname';
        $data['message'] = 'First name cannot be empty.';
    } else if (empty($lname)) {
        $data['success'] = false;
        $data['name'] = 'lname';
        $data['message'] = 'Last name cannot be empty.';
    } else if (empty($username)) {
        $data['success'] = false;
        $data['name'] = 'lname';
        $data['message'] = 'Username cannot be empty.';
    } else if (empty($city)) {
        $data['success'] = false;
        $data['name'] = 'city';
        $data['message'] = 'City cannot be empty.';
    } else if (empty($country)) {
        $data['success'] = false;
        $data['name'] = 'country';
        $data['message'] = 'Country cannot be empty.';
    } else if (empty($zip)) {
        $data['success'] = false;
        $data['name'] = 'zip';
        $data['message'] = 'Zip code cannot be empty.';
    } else if (empty($email)) {
        $data['success'] = false;
        $data['name'] = 'email';
        $data['message'] = 'Email cannot be empty.';
    } else if (empty($password)) {
        $data['success'] = false;
        $data['name'] = 'password';
        $data['message'] = 'Password cannot be empty.';
    } else if (empty($confirmPassword)) {
        $data['success'] = false;
        $data['name'] = 'confirmPassword';
        $data['message'] = 'Confirm Password cannot be empty.';
    } else if (preg_match('/^[a-zA-Z0-9._-]{2,}@[a-zA-Z0-9.-]{2,}\.[a-zA-Z]{2,}$/', $email) != 1) {
        $data['success'] = false;
        $data['name'] = 'email';
        $data['message'] = 'Email is not well formatted';
    } else if ($password !== $confirmPassword) {
        $data['success'] = false;
        $data['name'] = 'confirmPassword';
        $data['message'] = 'Password is not the same';
    } else {

        $recaptcha = new \ReCaptcha\ReCaptcha(RECAPTCHA_V3_SECRET_KEY);
        $resp = $recaptcha->setExpectedAction($action)
            ->setScoreThreshold(0.5)
            ->verify($token, $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            $duplicate = mysqli_query($conn, "SELECT * FROM USERS WHERE username='$username'");

            if (mysqli_num_rows($duplicate) > 0) {
                $data['success'] = false;
                $data['name'] = 'username';
                $data['message'] = 'Username already exists!';
            } else {
                $duplicate = mysqli_query($conn, "SELECT * FROM USERS WHERE email='$email'");

                if (mysqli_num_rows($duplicate) > 0) {
                    $data['success'] = false;
                    $data['name'] = 'email';
                    $data['message'] = 'Email already exists!';
                } else {

                    $isAdmin = mysqli_query($conn, "SELECT COUNT(*) AS userCount FROM USERS;");

                    $userBit = 0;

                    if ($row = mysqli_fetch_array($isAdmin))
                        if($row['userCount'] == 0)
                            $userBit = 1;

                    $verifCode = substr(md5(mt_rand()),0,15);

                    $password = md5($password);
                    $password = sha1($password);
                    $salt = "ka12n3cma993834canzk4la";

                    $password = crypt($password,$salt);
                    $currentDate = date('Y-m-d');

                    $sql = "INSERT INTO USERS VALUES (0, '$username','$email','$password','$fname','$lname', 'I am new here!', '$city','$country','$zip', '$verifCode', 0, NULL, NULL, 'img/avatars/default.png', 'img/banners/default.png', '$userBit', '$currentDate');";

                    if (mysqli_query($conn, $sql)) {
                        $userId = mysqli_insert_id($conn);

                        $currentTime = date("Y-m-d H:i:s");

                        $insertToTimeline = mysqli_query($conn, "INSERT INTO users_timeline VALUES('$userId', 'I just registered to Condor! Hello world!', '$currentTime');");

                        $data['success'] = true;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['verified'] = false;
                        $_SESSION['id'] = $userId;
                        $_SESSION['admin'] = boolval($userBit);

                        sendEmail($email, $userId, $verifCode);
                    }
                }
            }
        } else {
            $data['success'] = false;
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

function sendEmail($email, $userId, $verifCode) {
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'econdor.webdev@gmail.com';
    $mail->Password = 'webdev123$';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('sender@condor.net', 'Condor');
    $mail->addReplyTo('reply@condor.net', 'Condor');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Activation Code for Condor';

    $bodyContent = '<p>Your activation code is '.$verifCode.' <br><br> Please click on the following <a href="http://localhost/condor/user/verification?id=' . $userId . '&code=' . $verifCode . '"> link </a> to activate your account.</p>';
    $mail->Body = $bodyContent;

    $mail->send();
}
?>
