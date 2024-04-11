<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    require_once('includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: index.php');
    $user = $_SESSION['user'];
    $accounts = getAccounts($user);
    if(isset($_GET['logout'])) {
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
    <h1>Welcome, <?php echo mysqli_fetch_assoc(getClientInfo($user))['f_name'] ?></h1>
    <div class="nav">
        <a href="personal-info.php">Info</a>
        <a href="history.php">History</a>
        <a href="transfer.php">Transfer</a>
        <a href="?logout=true">Logout</a>
    </div>
    <div class="wrapper"><div class="table">
        <table>
            <tr>
                <td>ID</td>
                <td>Type</td>
                <td>Balance</td>
            </tr>
            <tr>
                <?php
                while ($row = mysqli_fetch_assoc($accounts)) {
                ?>
                <td><?php echo $row['account_id']; ?></td>
                <td><?php echo $row['account_type']; ?></td>
                <td><?php echo $row['balance']; ?></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div></div>
</body>
</html>
