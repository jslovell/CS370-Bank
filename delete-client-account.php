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
    <h1>Account deletion for: <?php echo mysqli_fetch_assoc(getClientInfo($user))['f_name'] ?></h1>
    <div class="nav">
        <a href="client.php">Back</a>
        <a href="?logout=true">Logout</a>
    </div>
    <div class="frm">
        <form autocomplete="off" method="post" action="includes/delete-account.php">
            <label>What type of account do you want to DELETE?</label>
            <select name="send" id="send">
                <option value="select">Select Account</option>
                <?php
                while ($row = mysqli_fetch_assoc($accounts)) {
                ?>
                <option value=<?php echo $row['account_id']; ?>><?php echo $row['account_id']; ?></option>
                <?php
                }
                ?>
            </select>
            <input type="submit" id="btn" value="Submit"/>
        </form>
        
    </div>
</body>
</html>