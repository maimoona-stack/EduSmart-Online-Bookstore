<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "booksite");

$session = session_id();

if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    mysqli_query($conn, "INSERT INTO cart(session_id, book_id) VALUES('$session', '$book_id')");
}

$sql = "SELECT cart.id, books.title, books.price 
        FROM cart 
        JOIN books ON cart.book_id = books.id 
        WHERE cart.session_id='$session'";

$result = mysqli_query($conn, $sql);

echo "<h2>Your Cart</h2>";

$total = 0;

while($row = mysqli_fetch_assoc($result)) {
    echo $row['title'] . " - $" . $row['price'] . "<br>";
    $total += $row['price'];
}

echo "<br><b>Total = $" . $total . "</b>";
?>
