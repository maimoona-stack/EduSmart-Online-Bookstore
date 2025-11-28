<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<body style="font-family:Arial;padding:20px;">
<h2>Register</h2>
<form method="post" action="save_user.php" target="right">
    Full Name:<br>
    <input type="text" name="name" required><br><br>

    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    Email:<br>
    <input type="email" name="email"><br><br>

    Phone:<br>
    <input type="text" name="phone"><br><br>

    <input type="submit" value="Register">
</form>
</body>
</html>
