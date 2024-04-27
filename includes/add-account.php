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
$account_type = $_POST['send']; //important -- //$account_type = $_POST["send"];
$initBalance = (double)$_POST['amount'];

$user = stripcslashes($user);
$account_type = stripcslashes($account_type);
$initBalance = stripcslashes($initBalance);

$user = mysqli_real_escape_string($conn, $user);
$account_type = mysqli_real_escape_string($conn, $account_type);
$initBalance = mysqli_real_escape_string($conn, $initBalance);

//////////////////////////// Everything below WORKS AND IS SAFE FOR PRCESSING AND Process safety from SQL injection
$_SESSION['signUpError'] = false;


//Next 4 Lines were used in Debugging
echo "This is the Account Type:";
echo $account_type;
echo "This is the BALANCE:";
echo $initBalance;

$prior = "4";
$theDescr = "Add account";

$hasNulls = false;
//Determine if there are even any tickets in the Queue
$numOfTickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ticket_id) as ticket_count FROM ticket"))['ticket_count']; //? does it work?

if($numOfTickets == 0) {
	$transaction_id = (int)$numOfTickets + 1; //$transaction_id = (int)$numOfTickets + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));
    $stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
    if (!$stmt->execute()) {
        array_push($errors, 'Transfer insert failed');
    }

	//Going to have a table for making an account
	$stmt = $conn->prepare("INSERT INTO alteredaccount (ticket_id, account_owner, account_type, balance) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("sssd", $transaction_id, $user, $account_type, $initBalance);
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
	$transaction_id = (int)$latestTicket + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));



	$stmt = $conn->prepare("INSERT INTO alteredaccount (ticket_id, account_owner, account_type, balance) VALUES (?, ?, ?, ?)");
	echo "WHY GOD";
	echo $latestTicket;
	$stmt->bind_param("sssd", $transaction_id, $user, $account_type, $initBalance);
	if (!$stmt->execute()) {
		$conn->rollback();
		header('Location: ../client.php');
    }

		echo "MY USERNAME";
		echo $user;
		echo $transaction_id;
		$stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
		$stmt->execute();
		$conn->commit();
}

header('Location: ../client.php');
?>
