<?php
session_start();
// Grab user-submitted information
$send_ac = $_POST["send"];
$rec_ac = $_POST["rec"];
$transfer = $_POST["amount"];

// Create a connection to the database
$conn = mysqli_connect("localhost", "root", "", "bank");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the transaction
$conn->autocommit(FALSE);

// Initialize an array to store errors
$errors = [];

//Validate inputs
$sendBal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT account_owner, account_type, balance FROM account WHERE account_id='".$send_ac."'"))['balance'];
$stmtA = $conn->prepare("SELECT account_id FROM account WHERE account_id=?");
$stmtA->bind_param("s", $rec_ac);
$stmtA->execute();
$stmtA->bind_result($rec_ac);
$stmtA->store_result();
$stmtB = $conn->prepare("SELECT account_id FROM account WHERE account_id=?");
$stmtB->bind_param("s", $send_ac);
$stmtB->execute();
$stmtB->bind_result($send_ac);
$stmtB->store_result();
if (!$stmtA->num_rows == 1 || !$stmtA->fetch() || !$stmtB->num_rows == 1 || !$stmtB->fetch() || $transfer <= 0 || $transfer > $sendBal) {
    array_push($errors, 'Invalid inputs');
}

// Update the balance of the debit account
$send_query = "UPDATE account SET balance = balance - ? WHERE account_id = ?";
$stmt = $conn->prepare($send_query);
$stmt->bind_param("ds", $transfer, $send_ac);
if (!$stmt->execute()) {
    array_push($errors, 'Debit transaction failed');
}

// Update the balance of the credit account
$rec_query = "UPDATE account SET balance = balance + ? WHERE account_id = ?";
$stmt = $conn->prepare($rec_query);
$stmt->bind_param("ds", $transfer, $rec_ac);
if (!$stmt->execute()) {
    array_push($errors, 'Credit transaction failed');
}

// Insert transaction entry
$transaction_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT transaction_id FROM transaction ORDER BY transaction_id DESC LIMIT 1;"))['transaction_id'];
$transaction_id = (int)$transaction_id + 1;
$date = date("Y-m-d h:i:s", strtotime("now"));
$transfer_query = "INSERT INTO transaction VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($transfer_query);
$stmt->bind_param("sssds", $transaction_id, $send_ac, $rec_ac, $transfer, $date);
if (!$stmt->execute()) {
    array_push($errors, 'Transfer insert failed');
}

// Check for errors and commit or rollback the transaction
if (!empty($errors)) {
    $conn->rollback();
    echo "Transaction Unsuccessful! Errors: " . implode(", ", $errors);
    $_SESSION['transferError'] = "ERROR";
    $_SESSION['transferSuccess'] = false;
} else {
    $conn->commit();
    echo "Transaction Successful!";
    unset($_SESSION['transferError']);
    $_SESSION['transferSuccess'] = true;
}

$conn->close();
echo " Transaction Finished";
header('Location: ../client.php');
?>
