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

$theTicket;
$theTicket = $_GET['ticket'];


//The Following are the ranks of priority to which be handeled, Will send req
$theClient = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_owner FROM ticket WHERE ticket.ticket_id='".$theTicket."'"))['ticket_owner'];
$prot = mysqli_fetch_assoc(mysqli_query($conn, "SELECT priority FROM ticket WHERE ticket.ticket_id='".$theTicket."'"))['priority'];



//Deleting the Entire Client User Profile
if($prot == "1") {
    echo "This registers the PRIORITY";
    header("Location: ./ticket-DeleteClient.php?ticket=" . $theTicket);
}
//Updating / Changing Client Personal Info
else if($prot == "2") {
    header("Location: ../admin-stuffs/admin-validateClientUpdate.php?ticket=" . $theTicket);
}
//Deleting a Singular Account
else if($prot == "3") {
    header("Location: ../admin-stuffs/valdidate-delete-account.php?ticket=" . $theTicket);
}
//Adding a singular Account
else if($prot == "4") {
    header("Location: ../admin-stuffs/valdidate-add-account.php?ticket=" . $theTicket);
}
?>