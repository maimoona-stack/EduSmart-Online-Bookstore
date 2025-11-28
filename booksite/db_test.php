<?php
$conn = mysqli_connect("localhost", "root", "", "booksite");

if($conn){
    echo "Database Connected Successfully!";
} else {
    echo "Connection Failed!";
}
?>
