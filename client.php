<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<?php
    require_once('db.php');
    require_once('functions.php');
    $user = $_GET['user'];
    $result = display_data($user);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Bank</title>
</head>
<style>
table, th, td {
    border:1px solid black;
}
</style>
<body>
    <h1>Welcome, <?php echo $user ?></h1>
    <div id="table">
        <table>
            <tr>
                <td>ID</td>
                <td>Type</td>
                <td>Balance</td>
            </tr>
            <tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <td><?php echo $row['account_id']; ?></td>
                <td><?php echo $row['account_type']; ?></td>
                <td><?php echo $row['balance']; ?></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>
</html>
