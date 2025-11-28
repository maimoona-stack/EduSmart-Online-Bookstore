<?php
session_start();
include("db_connect.php");

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) == 1) {
    
    $row = mysqli_fetch_assoc($res);

    // store session
    $_SESSION['user'] = $row['username'];
    $_SESSION['name']  = $row['name'];

    // INSERT INTO login_logs table
    mysqli_query($conn, 
        "INSERT INTO login_logs (username, login_time) 
         VALUES ('$username', NOW())"
    );

    echo "<script>window.location.href='mvsr_info.php';</script>";

} else {
    echo "<script>alert('Invalid username/password'); window.location='login.php';</script>";
}
?>