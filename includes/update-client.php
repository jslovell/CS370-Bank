<?php
session_start();
require_once 'db.php';

require_once('functions.php');
if (!isset($_SESSION['user'])) header('Location: index.php');
$user = $_SESSION['user'];
$accounts = getAccounts($user);
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: ./index.php');
}

//////////////////////////// Everything below WORKS AND IS SAFE FOR PRCESSING AND Process safety from SQL injection
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




$username = stripcslashes($username);
$password = stripcslashes($password);
$firstname = stripcslashes($firstname);
$lastname = stripcslashes($lastname);
$emailer = stripcslashes($emailer);
$phonenumber = stripcslashes($phonenumber);
$streetnumber = stripcslashes($streetnumber);
$street = stripcslashes($street);
$city = stripcslashes($city);

$user = stripcslashes($user);


$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);
$firstname = mysqli_real_escape_string($conn, $firstname);
$lastname = mysqli_real_escape_string($conn, $lastname);
$emailer = mysqli_real_escape_string($conn, $emailer);
$phonenumber = mysqli_real_escape_string($conn, $phonenumber);
$streetnumber = mysqli_real_escape_string($conn, $streetnumber);
$street = mysqli_real_escape_string($conn, $street);
$city = mysqli_real_escape_string($conn, $city);

$user = mysqli_real_escape_string($conn, $user);




//Makes a ticket
$prior = "2";
$theDescr = "Update Client Info";

$hasNulls = false;
//Determine if there are even any tickets in the Queue
$numOfTickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ticket_id) as ticket_count FROM ticket"))['ticket_count']; //? does it work?

if($numOfTickets == 0) {
	$transaction_id = (int)$numOfTickets + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));
    $stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $transaction_id, $username, $prior, $theDescr, $date);
    if (!$stmt->execute()) {
        array_push($errors, 'Transfer insert failed');
    }

	$stmt = $conn->prepare("INSERT INTO altereduser (ticket_id, username, password, f_name, l_name, email, phone_num, street_num, street, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);

	if (!$stmt->execute()) {
		$conn->rollback();
    }
	else {
		$conn->commit();
	}
}
//IF statment below is handling making the next ID increment by +1
else {
    $latestTicket = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id from latestticket"))['ticket_id'];
	echo $latestTicket . "\n";
	$transaction_id = (int)$latestTicket + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));


	$stmt = $conn->prepare("INSERT INTO altereduser (ticket_id, username, password, f_name, l_name, email, phone_num, street_num, street, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	echo "Already have requested to update Client Information!!!";
	echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
	if (!$stmt->execute()) {
		$conn->rollback();
    }
	else {
		$stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
		$stmt->execute();/*
		if (!$stmt->execute()) {
			//echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
			$conn->rollback();
		}*/
		$conn->commit();
	}
}

header('Location: ../client.php');
?>
