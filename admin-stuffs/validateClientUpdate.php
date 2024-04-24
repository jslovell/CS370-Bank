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
$theClient = getTicketUpdate($theTicket);


$_SESSION['signUpError'] = false;
// Grab User submitted information
$username = $_POST['user'];
$password = $_POST['pass'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$emailer = $_POST['emailer'];
$phonenumber = $_POST['pnum'];
$streetnumber = $_POST['streetnum'];
$street = $_POST['street'];
$city = $_POST['city'];

$oldUser = $_POST['oldUser'];


$username = stripcslashes($username);
$password = stripcslashes($password);
$firstname = stripcslashes($firstname);
$lastname = stripcslashes($lastname);
$emailer = stripcslashes($emailer);
$phonenumber = stripcslashes($phonenumber);
$streetnumber = stripcslashes($streetnumber);
$street = stripcslashes($street);
$city = stripcslashes($city);

$oldUser = stripcslashes($oldUser);



$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);
$firstname = mysqli_real_escape_string($conn, $firstname);
$lastname = mysqli_real_escape_string($conn, $lastname);
$emailer = mysqli_real_escape_string($conn, $emailer);
$phonenumber = mysqli_real_escape_string($conn, $phonenumber);
$streetnumber = mysqli_real_escape_string($conn, $streetnumber);
$street = mysqli_real_escape_string($conn, $street);
$city = mysqli_real_escape_string($conn, $city);

$oldUser = mysqli_real_escape_string($conn, $oldUser);


//Executing the Admin Priveledge to Update Account Info
$stmt = $conn->prepare("UPDATE client SET username=?, password=?, f_name=?, l_name=?, email=?, phone_num=?, street_num=?, street=?, city=? WHERE client.username=?");
if ($stmt === false) {
    die('Error: ' . $conn->error); // Handle prepare error
}

$stmt->bind_param("ssssssssss", $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city, $oldUser);
if ($stmt === false) {
    die('Error: ' . $stmt->error); // Handle bind_param error
}

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}



///The section Below Handles with the deletion of Tickets (This query takes the ticket request from alteredUser & deletes it as its reqest has been fufilled)
$stmt = $conn->prepare("DELETE FROM altereduser WHERE ticket_id= ?");
$stmt->bind_param("s", $theTicket);
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

///The section Below Handles with the deletion of Tickets
$stmt = $conn->prepare("DELETE FROM ticket WHERE ticket.ticket_id = ?");
$stmt->bind_param("s", $theTicket);
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}



header('Location: ../admin.php');
?>