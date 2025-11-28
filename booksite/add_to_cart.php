<?php
session_start();
include("db_connect.php");

if (empty($_SESSION['user'])) {
    echo "<script>alert('Please login first'); window.location='login.php';</script>";
    exit;
}

$user = mysqli_real_escape_string($conn, $_SESSION['user']);
$book_id = intval($_GET['book_id']);
$qty = isset($_GET['qty']) ? intval($_GET['qty']) : 1;

if ($qty < 1) $qty = 1; 

// Check if this book is already in the cart
$check = mysqli_query($conn, "SELECT * FROM cart WHERE username='$user' AND book_id=$book_id LIMIT 1");

if (mysqli_num_rows($check) > 0) {
    // Update existing quantity
    mysqli_query($conn,
        "UPDATE cart SET qty = qty + $qty 
         WHERE username='$user' AND book_id=$book_id"
    );
} else {
    // Insert new cart item
    mysqli_query($conn,
        "INSERT INTO cart (username, book_id, qty) 
         VALUES ('$user', $book_id, $qty)"
    );
}

echo "<script>window.location.href='cart.php';</script>";
?>
