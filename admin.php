<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    require_once('includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: index.php');
    if ($_SESSION['user'] != "admin") header('Location: client.php');
    if(isset($_POST['logout'])) {
        session_destroy();
        header('Location: index.php');
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>
<body>
    <h1>Admin Control Panel</h1>
    <br>
    <form method="post">
        <input type="submit" name="logout" value="Logout" />
    </form>
</body>
</html>
