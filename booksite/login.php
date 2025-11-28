<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body style="font-family:Arial;padding:20px;">

<h2>Login</h2>

<form method="post" action="do_login.php">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

</body>
</html>
