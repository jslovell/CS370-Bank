<?php
session_start();
require_once 'db.php';

// Grab User submitted information
$rec = $_POST['rec'];
$send = $_POST['send'];
$amount = $_POST['amount'];

$rec = stripcslashes($rec);
$amount = stripcslashes($amount);
$send = stripcslashes($send);
$rec = mysqli_real_escape_string($conn, $rec);
$amount = mysqli_real_escape_string($conn, $amount);
$send = mysqli_real_escape_string($conn, $send);

$stmt = $conn->prepare("SELECT balance FROM account WHERE account_id=?");
$stmt->bind_param("s", $rec);
$stmt->execute();
$stmt->bind_result($rec);
$stmt->store_result();

if ($stmt->num_rows == 1 && $stmt->fetch() && $send != "select") {
    $query = mysqli_query($conn, "SELECT balance FROM account WHERE account_id='".$send."'");
    $sendBal = mysqli_fetch_assoc($query)['balance'];
    if (is_numeric($amount) && $amount > 0 && $sendBal >= $amount) {
        $query = mysqli_query($conn, "SELECT balance FROM account WHERE account_id='".$rec."'");
        $recBal = mysqli_fetch_assoc($query)['balance'];
        $newSendBal = $sendBal - (float)$amount;
        $newRecBal = $recBal + (float)$amount;

        //$sqlA = "UPDATE account SET balance=".$newSendBal." WHERE account_id='".$send."'";
        //mysqli_query($conn, $sqlA);
        $sqlB = "UPDATE account SET balance=".$newRecBal." WHERE account_id='".$rec."'";
        mysqli_query($conn, $sqlB);

        unset($_SESSION['transferError']);
        $_SESSION['transferSuccess'] = true;
        echo $newRecBal;
        //header('Location: ../client.php');
    } else {
        $_SESSION['transferError'] = "ERROR 2";
        $_SESSION['transferSuccess'] = false;
        header('Location: ../client.php');
    }
} else {
    $_SESSION['transferError'] = "ERROR 1";
    $_SESSION['transferSuccess'] = false;
    header('Location: ../client.php');
}
?>
