<?php
session_start();
include("db_connect.php");

// USER MUST LOGIN
if (empty($_SESSION['user'])) {
    echo "<script>alert('Please login to view your cart'); window.location='login.php';</script>";
    exit;
}

$user = mysqli_real_escape_string($conn, $_SESSION['user']);

// REMOVE ITEM
if (isset($_GET['remove'])) {
    $cid = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM cart WHERE id=$cid AND username='$user'");
    echo "<script>window.location.href='cart.php';</script>";
    exit;
}

// UPDATE QTY
if (isset($_POST['update_qty'])) {
    $cid = intval($_POST['cart_id']);
    $new_qty = max(1, intval($_POST['new_qty']));  // min qty = 1

    mysqli_query($conn, "UPDATE cart SET qty=$new_qty WHERE id=$cid AND username='$user'");
    echo "<script>window.location.href='cart.php';</script>";
    exit;
}

// FETCH CART ITEMS
$sql = "SELECT cart.id AS cart_id, cart.qty, books.title, books.price, books.image
        FROM cart 
        JOIN books ON cart.book_id = books.id
        WHERE cart.username='$user'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<body style="font-family:Arial; padding:20px;">

<h2><?php echo htmlspecialchars($_SESSION['name']); ?>'s Cart</h2>
<hr><br>

<?php if (mysqli_num_rows($result) == 0): ?>

    <p>Your cart is empty.</p>

<?php else: ?>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse; width:100%;">
    <tr style="background:#f2f2f2; text-align:center;">
        <th>Image</th>
        <th>Book</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Action</th>
    </tr>

    <?php 
    $grand_total = 0;
    while ($row = mysqli_fetch_assoc($result)):
        $total = $row['price'] * $row['qty'];
        $grand_total += $total;
    ?>

    <tr>
        <td align="center">
            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
                 width="70" height="90" 
                 style="object-fit:cover; border-radius:5px;">
        </td>

        <td><?php echo htmlspecialchars($row['title']); ?></td>

        <td>$<?php echo number_format($row['price'], 2); ?></td>

        <td align="center">
            <!-- QUANTITY UPDATE FORM -->
            <form method="post" action="cart.php">
                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                <input type="number" name="new_qty" value="<?php echo $row['qty']; ?>" 
                       min="1" style="width:60px; text-align:center;">
                <button type="submit" name="update_qty"
                        style="padding:3px 8px; margin-top:4px; background:#1a73e8; color:white; border:none; border-radius:4px;">
                    Update
                </button>
            </form>
        </td>

        <td>$<?php echo number_format($total, 2); ?></td>

        <td>
            <a href="cart.php?remove=<?php echo $row['cart_id']; ?>" 
               onclick="return confirm('Remove this item from cart?');"
               style="color:red;">
               Remove
            </a>
        </td>
    </tr>

    <?php endwhile; ?>

    <tr style="background:#e8e8e8;">
        <td colspan="4" align="right"><b>Grand Total:</b></td>
        <td colspan="2"><b>$<?php echo number_format($grand_total, 2); ?></b></td>
    </tr>

</table>

<?php endif; ?>

<br><br>

<a href="checkout.php" target="right" 
   style="font-size:18px; background:green; color:white; padding:8px 15px; 
          border-radius:6px; text-decoration:none;">
   Proceed to Checkout
</a>

</body>
</html>
