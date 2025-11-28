<?php session_start(); ?>

<table border="1" width="100%">
<tr>
    <td width="120" align="center">
        <img src="images/logo.png" width="100">
    </td>

    <td align="center">
        <h2>EduSmart Online Bookstore</h2>
        <small>Your Digital Learning Companion</small>
    </td>

    <td width="250" align="right" style="padding-right:15px;">
        <?php if (isset($_SESSION['user'])) { ?>
            Logged in as <b><?php echo $_SESSION['name']; ?></b>
            &nbsp;|&nbsp;
            <a href="logout.php" target="_top" style="color:red;">Logout</a>
        <?php } else { ?>
            <a href="login.php" target="right">Login</a> |
            <a href="registration.php" target="right">Register</a>
        <?php } ?>
    </td>
</tr>

<tr>
<td colspan="3" align="center" style="padding:8px;">
  <a href="description.php" target="right">Home</a> |
<a href="catalogue.php" target="right">Catalogue</a>
<a href="cart.php" target="right">Cart</a>

</tr>
</table>

<marquee style="color:red; font-size:16px; margin-top:5px;">
✨ New Events: 40+ books added • MVSR Project • Login & Cart Updated • New Features Added
</marquee>
