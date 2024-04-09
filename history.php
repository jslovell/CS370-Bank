<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    require_once('includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: index.php');
    $user = $_SESSION['user'];
    $transactions = getTransactions($user);
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
    <h1>Transaction history for <?php echo mysqli_fetch_assoc(getClientInfo($user))['f_name'] ?></h1>
    <div id="table">
        <table>
            <tr>
                <td>ID</td>
                <td>Sender</td>
                <td>Reciever</td>
                <td>Amount</td>
                <td>Timestamp</td>
            </tr>
            <tr>
                <?php
                while ($row = mysqli_fetch_assoc($transactions)) {
                ?>
                <td><?php echo $row['transaction_id']; ?></td>
                <td><?php echo $row['send_account']; ?></td>
                <td><?php echo $row['rec_account']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <br>
    <form method="post">
        <input type="submit" name="logout" value="Logout" />
    </form>
    <br>
    <a href="client.php">Back</a>
    <br>
</body>
</html>
