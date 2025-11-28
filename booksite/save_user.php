<?php
session_start();
include("db_connect.php");

// Get values safely
$name     = mysqli_real_escape_string($conn, $_POST['name']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$email    = mysqli_real_escape_string($conn, $_POST['email']);
$phone    = mysqli_real_escape_string($conn, $_POST['phone']);
$address  = mysqli_real_escape_string($conn, $_POST['address'] ?? "");

// CHECK: username already exists?
$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('❌ Username already exists. Try another'); window.location='registration.php';</script>";
    exit;
}

// INSERT user
$sql = "INSERT INTO users (name, username, password, email, phone, address)
        VALUES ('$name', '$username', '$password', '$email', '$phone', '$address')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('✅ Registration successful! Please login.'); 
          window.location='login.php';</script>";
} else {
    echo "<script>alert('❌ Error while saving user'); window.location='registration.php';</script>";
}
?>
