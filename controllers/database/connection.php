<?php
function openCon() {
    $dbhost = "localhost";
    $dbuser ="root";
    $dbpassword="";
    $db="condor";

    $conn = new mysqli($dbhost, $dbuser, $dbpassword, $db) or die("Connection failed: %s\n" . $conn -> error);

    return $conn;
}

function closeCon($conn) {
    $conn -> close();
}
?>
