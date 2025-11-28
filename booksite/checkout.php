<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Please login to checkout'); window.location='login.php';</script>";
    exit;
}

$username = $_SESSION['user'];

// Fetch user details
$user_sql = "SELECT name, email, phone FROM users WHERE username='$username'";
$user_res = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_res);

// Fetch cart items
$sql = "
SELECT c.book_id, c.qty, b.title, b.author, b.price
FROM cart c
JOIN books b ON c.book_id = b.id
WHERE c.username = '$username'
";

$res = mysqli_query($conn, $sql);

// If cart empty
if (mysqli_num_rows($res) == 0) {
    echo "<script>alert('Your cart is empty!'); window.location='catalogue.php';</script>";
    exit;
}

// Calculate total amount
$grand_total = 0;
$cart_items = [];

while ($row = mysqli_fetch_assoc($res)) {
    $row['subtotal'] = $row['qty'] * $row['price'];
    $grand_total += $row['subtotal'];
    $cart_items[] = $row; // store items
}

// Insert into orders table
$session_id = $username; // or session_id();
$order_insert = "
INSERT INTO orders (session_id, total)
VALUES ('$session_id', $grand_total)
";

mysqli_query($conn, $order_insert);

// Get the newly created order ID
$order_id = mysqli_insert_id($conn);

// Insert each cart item into order_items table
foreach ($cart_items as $item) {
    $bid = $item['book_id'];
    $qty = $item['qty'];
    $price = $item['price'];

    $oi_sql = "
    INSERT INTO order_items (order_id, book_id, qty, price)
    VALUES ($order_id, $bid, $qty, $price)
    ";
    mysqli_query($conn, $oi_sql);
}

// Clear cart after successful order
mysqli_query($conn, "DELETE FROM cart WHERE username='$username'");

?>
<!DOCTYPE html>
<html>
<body style="font-family:Arial; padding:20px; line-height:1.6;">

<h2>Order Placed Successfully ✔</h2>

<h3>Order Receipt</h3>
<p><b>Name:</b> <?= $user['name'] ?></p>
<p><b>Email:</b> <?= $user['email'] ?></p>
<p><b>Phone:</b> <?= $user['phone'] ?></p>
<p><b>Order ID:</b> <?= $order_id ?></p>

<hr>

<h3>Your Purchased Items:</h3>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
<tr style="background:#f2f2f2;">
    <th>Book</th>
    <th>Author</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

<?php foreach ($cart_items as $item): ?>
<tr>
    <td><?= $item['title'] ?></td>
    <td><?= $item['author'] ?></td>
    <td>₹ <?= $item['price'] ?></td>
    <td><?= $item['qty'] ?></td>
    <td>₹ <?= $item['subtotal'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<h3 style="margin-top:20px;">Grand Total: <b>₹ <?= $grand_total ?></b></h3>

<hr>

<h2 style="color:green;">🎉 Thank you! Your order has been placed.</h2>
<p>Your books will be delivered to your registered contact information.</p>

</body>
</html>
