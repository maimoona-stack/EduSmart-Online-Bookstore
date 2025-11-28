<?php
session_start();
include("db_connect.php");

// Get selected department
$dept = isset($_GET['dept']) ? mysqli_real_escape_string($conn, $_GET['dept']) : "";
?>

<!DOCTYPE html>
<html>
<body style="font-family:Arial; padding:20px;">

<?php
// IF NO DEPARTMENT SELECTED → SHOW DEPARTMENT OPTIONS
if ($dept == "") {
?>

<h2>Select Department</h2>
<hr><br>

<a href="catalogue.php?dept=IT" target="right" style="font-size:20px;">Information Technology (IT)</a><br><br>
<a href="catalogue.php?dept=CSE" target="right" style="font-size:20px;">Computer Science (CSE)</a><br><br>
<a href="catalogue.php?dept=ECE" target="right" style="font-size:20px;">Electronics (ECE)</a><br><br>
<a href="catalogue.php?dept=EEE" target="right" style="font-size:20px;">Electrical (EEE)</a><br><br>
<a href="catalogue.php?dept=CIVIL" target="right" style="font-size:20px;">Civil Engineering (CIVIL)</a><br><br>

<?php
    exit;
}
?>


<?php
// IF DEPARTMENT SELECTED → SHOW BOOKS
echo "<h2>" . htmlspecialchars($dept) . " Books</h2><hr><br>";

// Fetch books for this department
$sql = "SELECT * FROM books WHERE dept='$dept'";
$result = mysqli_query($conn, $sql);

// If no books found
if (mysqli_num_rows($result) == 0) {
    echo "<p>No books found for this department.</p>";
    exit;
}
?>

<!-- BOOK GRID -->
<div style="display:flex; flex-wrap:wrap; gap:20px;">

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>

    <div style="width:200px; border:1px solid #ccc; padding:12px; text-align:center; border-radius:8px;">
        <img src="images/<?php echo htmlspecialchars($row['image']); ?>"
             style="width:120px; height:150px; object-fit:cover; border-radius:5px;"><br><br>

        <b><?php echo htmlspecialchars($row['title']); ?></b><br>
        <small>By <?php echo htmlspecialchars($row['author']); ?></small><br><br>

        <div style="font-weight:bold; color:#1a73e8;">
            $<?php echo number_format($row['price'], 2); ?>
        </div><br>

        <!-- QUANTITY BOX -->
        <form method="GET" action="add_to_cart.php" target="right">
            <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">

            <label>Qty:</label>
            <input type="number" name="qty" value="1" min="1" max="10"
                   style="width:50px; text-align:center; margin-bottom:10px;"><br>

            <?php if (!empty($_SESSION['user'])) { ?>
                <button type="submit"
                        style="padding:6px 10px; background:#1a73e8; color:white; border:none; border-radius:5px;">
                    Add to Cart
                </button>
            <?php } else { ?>
                <button type="button"
                        onclick="alert('Please login or register to add books to cart');"
                        style="padding:6px 10px; background:#888; color:white; border:none; border-radius:5px;">
                    Add to Cart
                </button>
            <?php } ?>

        </form>
    </div>

<?php
}
?>
</div>

</body>
</html>
