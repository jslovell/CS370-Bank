<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    require_once('includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: index.php');
    $user = $_SESSION['user'];
    $persInfo = getClientInfo($user);
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
    <h1>Client Account Information for <?php echo mysqli_fetch_assoc(getClientInfo($user))['f_name'] ?></h1>
    <div class="nav">
        <a href="client.php">Back</a>
        <a href="?logout=true">Logout</a>
    </div>
    <div class="wrapper"><div class="table">
        <table>
            <tr>
                <td>Username</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Phone Number</td>
                <td>Street Number</td>
                <td>Street</td>
                <td>City</td>
            </tr>
            <tr>
                <?php
                $row = mysqli_fetch_assoc($persInfo)
                ?>
                <td><?php echo $user; ?></td>
                <td><?php echo $row['f_name']; ?></td>
                <td><?php echo $row['l_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone_num']; ?></td>
                <td><?php echo $row['street_num']; ?></td>
                <td><?php echo $row['street']; ?></td>
                <td><?php echo $row['city']; ?></td>
            </tr>
            <?php

            ?>
        </table>
    </div></div>

    <div class="nav">
        <a href="update-client-info.php">Update Information</a>
        <a href="create-client.php">Create new Account</a>
    </div>


</body>
</html>
