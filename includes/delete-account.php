<?php
session_start();
require_once 'db.php';

require_once('functions.php');
if (!isset($_SESSION['user'])) header('Location: index.php');
$user = $_SESSION['user'];
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: ./index.php');
}


// Grab User submitted information
$acctToDel = $_POST['send']; //important -- //$account_type = $_POST["send"];

$user = stripcslashes($user);
$acctToDel = stripcslashes($acctToDel);


$user = mysqli_real_escape_string($conn, $user);
$acctToDel = mysqli_real_escape_string($conn, $acctToDel);

//////////////////////////// Everything below WORKS AND IS SAFE FOR PRCESSING AND Process safety from SQL injection
$_SESSION['signUpError'] = false;



echo "This is the Account Type:";
echo $acctToDel;
echo "This is the BALANCE:";

$prior = "3"; //This is the Priority ID for Delete Account
$theDescr = "Delete Account";

$hasNulls = false;
//Determine if there are even any tickets in the Queue
$numOfTickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ticket_id) as ticket_count FROM ticket"))['ticket_count']; //? does it work?

if($numOfTickets == 0) {
	$transaction_id = (int)$numOfTickets + 1; //$transaction_id = (int)$numOfTickets + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));
    $stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $transaction_id, $user, $prior, $acctToDel, $date); //$theDescr
    if (!$stmt->execute()) {
        array_push($errors, 'Delete account insert failed');
    }
}
//IF statment below is handling making the next ID increment by +1
else {
    $latestTicket = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id from latestticket"))['ticket_id'];
	$transaction_id = (int)$latestTicket + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));

		echo "MY USERNAME";
		echo $user; 
		echo $transaction_id;
		$stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $transaction_id, $user, $prior, $acctToDel, $date);
		$stmt->execute();

		$conn->commit();
}

header('Location: ../client.php');
?>