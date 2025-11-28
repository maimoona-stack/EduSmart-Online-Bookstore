<?php

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "booksite";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die("DB Conn Failed: " . mysqli_connect_error());
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
