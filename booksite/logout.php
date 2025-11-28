<?php
include("db_connect.php");
$_SESSION = [];
session_destroy();
echo "<script>window.top.location.href='home.php';</script>";
?>
