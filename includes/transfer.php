<?php
session_start();
require_once 'db.php';
require_once('functions.php');

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
$stmt->bind_result($unused);
$stmt->store_result();

if ($stmt->num_rows == 1 && $stmt->fetch() && $send != "select") {;
    $sendBal = mysqli_fetch_assoc(getOneAccount($send))['balance'];
    if (is_numeric($amount) && $amount > 0 && $sendBal >= $amount) {
        $recBal = mysqli_fetch_assoc(getOneAccount($rec))['balance'];
        $newSendBal = $sendBal - $amount;
        $newRecBal = $recBal + $amount;

        $sqlA = "UPDATE account SET balance=".$newSendBal." WHERE account_id='".$send."'";
        mysqli_query($conn, $sqlA);
        $sqlB = "UPDATE account SET balance=".$newRecBal." WHERE account_id='".$rec."'";
        mysqli_query($conn, $sqlB);

        unset($_SESSION['transferError']);
        $_SESSION['transferSuccess'] = true;
        header('Location: ../client.php');
    } else {
        $_SESSION['transferError'] = "ERROR: invalid amount";
        $_SESSION['transferSuccess'] = false;
        header('Location: ../client.php');
    }
} else {
    $_SESSION['transferError'] = "ERROR: invalid to/from";
    $_SESSION['transferSuccess'] = false;
    header('Location: ../client.php');
}
?>
