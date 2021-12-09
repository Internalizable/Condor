<?php
require_once("database/connection.php");

session_start();

date_default_timezone_set("Asia/Beirut");

if(isset($_POST["submit"]) && isset($_SESSION['id'])){
    $con = openCon();

    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $bio = trim($_POST["bio"]);

    $userId = $_SESSION['id'];

    $allowedExts = array("jpg", "jpeg", "gif", "png", "swf", "mp3", "txt", "pdf", "doc", "docx");
    $allowedTypes = array("image/jpeg", "image/jpeg", "image/gif", "image/png", "application/x-shockwave-flash", "audio/mpeg", "text/plain","application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document");

    $profilePhotoPath = uploadImage("user_photo", $allowedTypes, $allowedExts, "avatars/");
    $bannerPhotoPath = uploadImage("user_cover_photo", $allowedTypes, $allowedExts, "banners/");

    $query = mysqli_query($con, "SELECT profile_path, banner_path FROM USERS WHERE id='$userId';");

    while($row = mysqli_fetch_array($query)) {

        if($row['profile_path'] != 'img/avatars/default.png' && $row['banner_path'] != 'img/banners/default.png') {
            unlink('../' . $row['profile_path']);
            unlink('../' . $row['banner_path']);
        }

    }

    mysqli_query($con, "UPDATE USERS SET firstname='$fname', lastname='$lname', bio='$bio', profile_path='$profilePhotoPath', banner_path='$bannerPhotoPath' WHERE id='$userId';");

    closeCon($con);

    header("location: ../user/profile?id=" . base64_encode($userId));
} else {
    header("location: ../error.php?code=404");
}

function uploadImage($field, $allowedTypes, $allowedExts, $targetFolder) {
    $array = explode(".", $_FILES[$field]["name"]);
    $extension = end($array);
    $extensionCheck = array_search(mime_content_type($_FILES[$field]["tmp_name"]), $allowedTypes) == array_search(strtolower($extension), $allowedExts);

    if (in_array($_FILES[$field]["type"], $allowedTypes) && ($_FILES[$field]["size"] < 20000000) && in_array(strtolower($extension), $allowedExts) && $extensionCheck == 1) {
        if ($_FILES[$field]["error"] > 0) {
            header("location: ../error.php?code=404");
            exit;
        } else {
            //If all successful, move the file to the folder 'uploads'
            $imgNewName = generateRandomString() . date('H-i-s') . "." . $extension;
            $target = "../img/" . $targetFolder . $imgNewName;

            move_uploaded_file($_FILES[$field]["tmp_name"], $target);

            return "img/" . $targetFolder . $imgNewName;
        }
    } else {
        header("location: ../error.php?code=404");
        exit;
    }
}
function generateRandomString($length = 35) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
