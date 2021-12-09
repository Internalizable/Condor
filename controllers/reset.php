<?php
include ('database/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $data = array();
    $conn = openCon();

    $email = testInput($_POST['email'], $conn);

    if(empty($email)) {
        $data['success'] = false;
        $data['name'] = 'email';
        $data['message'] = 'Email cannot be empty.';
    } else {
        $duplicate = mysqli_query($conn, "SELECT id FROM USERS WHERE email='$email'");

        if (mysqli_num_rows($duplicate) == 1) {

            $resetCode = substr(md5(mt_rand()),0,15);

            while ($row = mysqli_fetch_array($duplicate)) {
                $id = $row['id'];
                $expiryTime = time() + (3600 * 6);

                $query = mysqli_query($conn, "UPDATE USERS SET resetToken='$resetCode', resetExpiry='$expiryTime' WHERE id='$id'");

                sendEmail($email, $id, $resetCode);

                $data['success'] = true;
            }
        } else {
            $data['success'] = false;
            $data['name'] = 'email';
            $data['message'] = 'Email is invalid';
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

function sendEmail($email, $userId, $resetCode) {
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

    $mail->Subject = 'Reset Code for Condor';

    $bodyContent = '<p>Your reset code for your account is '.$resetCode.' <br><br> Please click on the following <a href="http://localhost/condor/user/reset?id=' . $userId . '&code=' . $resetCode . '"> link </a> to reset your account\'s password.</p>';
    $mail->Body = $bodyContent;

    $mail->send();
}
?>
