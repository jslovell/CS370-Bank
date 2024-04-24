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

//WAS IN PROCESS OF MODIFYING

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


//KEEP this for Debugging --> I was tampering around 
//THe Update Function!!!!!
/*
$stmt = $conn->prepare("UPDATE client SET username=?, password=?, f_name=?, l_name=?, email=?, phone_num=?, street_num=?, street=?, city=? WHERE client.username=?");
if ($stmt === false) {
    die('Error: ' . $conn->error); // Handle prepare error
}

$stmt->bind_param("ssssssssss", $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city, $user);
if ($stmt === false) {
    die('Error: ' . $stmt->error); // Handle bind_param error
}

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}
*/



//Makes a ticket
//$ticketID = "10101";
/////////////////////////////////////Above is good
$prior = "2";
$theDescr = "Update Client Info";

$hasNulls = false;
//Determine if there are even any tickets in the Queue
$numOfTickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ticket_id) as ticket_count FROM ticket"))['ticket_count']; //Find the last Ticket ID #

if($numOfTickets == 0) {
	//The Use of Josh's Beautiful Transaction Code
	$transaction_id = (int)$numOfTickets + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));
    $stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $transaction_id, $username, $prior, $theDescr, $date);
    if (!$stmt->execute()) {
        array_push($errors, 'Transfer insert failed');
    }

	$stmt = $conn->prepare("INSERT INTO altereduser (ticket_id, username, password, f_name, l_name, email, phone_num, street_num, street, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	//$stmt->execute();
	if (!$stmt->execute()) {
		$conn->rollback();
    }
	else {
		$conn->commit();
	}
}
//IF statment below is handling making the next ID increment by +1
//else if (!$hasNulls) {
else {
    //Orig//$transaction_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT transaction_id FROM transaction ORDER BY transaction_id DESC LIMIT 1;"))['transaction_id'];
    $latestTicket = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id from latestticket"))['ticket_id'];
	echo $latestTicket . "\n";
	$transaction_id = (int)$latestTicket + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));
	//Below Comment Was I was making Modifications --> Keep this
	/*
    $stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
    //$stmt->bind_param("sssss", $transaction_id, $username, $prior, $transaction_id, $date);
	$stmt->bind_param("sssss", $transaction_id, $user, $prior, $transaction_id, $date);
	$stmt->execute();*/
	/*
    if (!$stmt->execute()) {
        array_push($errors, 'Transfer insert failed');
    }
	*/
	$stmt = $conn->prepare("INSERT INTO altereduser (ticket_id, username, password, f_name, l_name, email, phone_num, street_num, street, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	//$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	echo "Already have requested to update Client Information!!!";
	echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
	if (!$stmt->execute()) {
		$conn->rollback();
    }
	else {
		$stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
		//$stmt->bind_param("sssss", $transaction_id, $username, $prior, $transaction_id, $date);
		$stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
		$stmt->execute();/*
		if (!$stmt->execute()) {
			//echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
			$conn->rollback();
		}*/
		$conn->commit();
	}
}


$_SESSION['loginError'] = true;
header('Location: ../index.php');
?>