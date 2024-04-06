<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    if (!isset($_SESSION['loginError'])) $_SESSION['loginError'] = false;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>
<body>
    <div id="frm">
        <form autocomplete="off" method="post" action="includes/login.php">
            <h1>Very Legitimate Bank Inc.</h1>
            <p>
                <label>Username</label>
                <input type="text" name="user" id="user" />
                <label>Password</label>
                <input type="text" name="pass" id="pass" />
                <input type="submit" id="btn" value="Login"/>
            </p>
        </form>
        <?php if ($_SESSION['loginError'] == true) { ?>
            <p style='color: red;'>Incorrect Username/Password!</p>
        <?php } ?>
    </div>
</body>
</html>
