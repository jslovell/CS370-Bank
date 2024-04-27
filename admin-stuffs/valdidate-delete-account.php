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




//This is gathing the Information from the ticket & the account details to delete from database
$acctToDel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id, ticket_owner, priority, description, timestamp FROM ticket WHERE ticket_id ='".$theTicket."'"))['description'];

//Executing the Admin Priveledge to Update Account Info
$stmt = $conn->prepare("DELETE FROM account where account_id= ?");
if ($stmt === false) {
    die('Error: ' . $conn->error); // Handle prepare error
}

$stmt->bind_param("s", $acctToDel);
if ($stmt === false) {
    die('Error: ' . $stmt->error); // Handle bind_param error
}

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}



$stmt = $conn->prepare("CALL ExecuteTwoQueries(?)"); //Working PROCEDURE ;)
if ($stmt === false) {
    die('Error: ' . $conn->error); // Handle prepare error
}

$stmt->bind_param("s", $acctToDel);
if ($stmt === false) {
    die('Error: ' . $stmt->error); // Handle bind_param error
}

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}





///The section Below Handles with the deletion of Tickets (This query takes the ticket request from alteredUser & deletes it as its reqest has been fufilled)
$stmt = $conn->prepare("DELETE FROM ticket WHERE ticket.ticket_id = ?");
$stmt->bind_param("s", $theTicket);
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

header('Location: ../admin.php');
?>