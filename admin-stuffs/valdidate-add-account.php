<?php
session_start();
require_once '../includes/db.php';

require_once('../includes/functions.php');
if (!isset($_SESSION['user'])) header('Location: index.php');
$user = $_SESSION['user'];
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}

//Getting Ticket ID from ? in URL
$theTicket;
$theTicket = $_GET['ticket'];
$theClient = getAccountTicket($theTicket);


$_SESSION['signUpError'] = false;



//This is gathing the Information from the ticket & the account details to add
$acct_owner = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id, account_owner, account_type, balance FROM alteredaccount WHERE ticket_id ='".$theTicket."'"))['account_owner'];
$acct_type =mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id, account_owner, account_type, balance FROM alteredaccount WHERE ticket_id ='".$theTicket."'"))['account_type'];
$bal =mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id, account_owner, account_type, balance FROM alteredaccount WHERE ticket_id ='".$theTicket."'"))['balance'];

$latestAccount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT account_id from lastestaccount"))['account_id'];
$latestAccount = (int)$latestAccount + 1;


//Executing the Admin Priveledge to Update Account Info
$stmt = $conn->prepare("INSERT INTO account (account_id, account_owner, account_type, balance) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die('Error: ' . $conn->error); // Handle prepare error
}

$stmt->bind_param("sssd", $latestAccount, $acct_owner, $acct_type, $bal);
if ($stmt === false) {
    die('Error: ' . $stmt->error); // Handle bind_param error
}

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}



///The section Below Handles with the deletion of Tickets (This query takes the ticket request from alteredUser & deletes it as its reqest has been fufilled)
$stmt = $conn->prepare("DELETE FROM alteredaccount WHERE ticket_id= ?");
$stmt->bind_param("s", $theTicket);
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}


$stmt = $conn->prepare("DELETE FROM ticket WHERE ticket.ticket_id = ?");
$stmt->bind_param("s", $theTicket);
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}


header('Location: ../admin.php');
?>