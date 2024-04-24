<?php
session_start();
require_once '../includes/db.php';
//////////////////////////////////////////////////THIS IS CURRENTLY A WIP AS OF 4-24-24
//THUS I AM NOT MAKING ANY CHANGES To CLEAN THIS AS IT MIGHT HELP W DEBUGGING AND/OR SOLUTION

//The parts that are WIP are Priority 3 & 4


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


echo $prot; //Was a test to see if Priority was getting pulled correctly
echo "    YOUR MOTHER ";




//Deleting the Entire Client User Profile
if($prot == "1") {
    //Send it to the deleteClient Code (its php)
    echo "This registers the PRIORITY";
    header("Location: ./ticket-DeleteClient.php?ticket=" . $theTicket);
}
//Updating / Changing Client Personal Info
else if($prot == "2") {
    header("Location: ../admin-stuffs/admin-validateClientUpdate.php?ticket=" . $theTicket);
    //admin-validateClientUpdate
}
//Deleting a Singular Account (WIP)
else if($prot == "3") {

}
//Adding a singular Account (WIP)
else if($prot == "4") {

}
else {
    header('Location: ../admin.php'); //Added on 4-24-24 before 12pm
}
header('Location: ../admin.php'); //Added on 4-24-24 before 12pm
?>