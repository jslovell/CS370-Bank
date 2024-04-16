<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    require_once('includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: index.php');
    $user = $_SESSION['user'];
    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    }
    if(!isset($_SESSION['transaction'])) $id = 0;
    else $id = $_SESSION['transaction'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>
<body>
    <h1>Transfer Confirmation</h1>
    <div class="nav">
        <a href="client.php">Home</a>
        <a href="?logout=true">Logout</a>
    </div>
    <div class="frm" style="text-align: center">
        <p style="color: green">SUCCESS</p>
        <p>To: <?php echo mysqli_fetch_assoc(getOneTransaction($id))['rec_account'] ?></p>
        <p>From: <?php echo mysqli_fetch_assoc(getOneTransaction($id))['send_account'] ?></p>
        <p>Amount: $<?php echo mysqli_fetch_assoc(getOneTransaction($id))['amount'] ?></p>
    </div>
</body>
</html>
