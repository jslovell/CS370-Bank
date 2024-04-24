<?php
session_start();
require_once 'db.php'; //?

//////////////////////////////////////////////////THIS IS CURRENTLY A WIP AS OF 4-24-24
//THUS I AM NOT MAKING ANY CHANGES To CLEAN THIS AS IT MIGHT HELP W DEBUGGING AND/OR SOLUTION

require_once('functions.php');
if (!isset($_SESSION['user'])) header('Location: index.php');
$user = $_SESSION['user'];

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: ./index.php');
}


// Grab User submitted information
//$send_ac = $_POST["send"];
$account_type = $_POST["send"]; //important
$initBalance = (double)$_POST["amount"]; //impotant ???////?????//

$user = stripcslashes($user);
$account_type = stripcslashes($account_type);
$initBalance = stripcslashes($initBalance);

$user = mysqli_real_escape_string($conn, $user);
$account_type = mysqli_real_escape_string($conn, $account_type);
$initBalance = mysqli_real_escape_string($conn, $initBalance);

//////////////////////////// Everything below WORKS AND IS SAFE FOR PRCESSING AND Process safety from SQL injection
$_SESSION['signUpError'] = false;



echo "This is the Account Type:";
echo $account_type;
echo "This is the BALANCE:";
echo $initBalance;
//Makes a ticket
//$ticketID = "10101";
/////////////////////////////////////Above is good
$prior = "4";
$theDescr = "Request to make an account";

$hasNulls = false;
//Determine if there are even any tickets in the Queue
$numOfTickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ticket_id) as ticket_count FROM ticket"))['ticket_count']; //? does it work?

if($numOfTickets == 0) {
	//Orig//$transaction_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT transaction_id FROM transaction ORDER BY transaction_id DESC LIMIT 1;"))['transaction_id'];
    //$latestTicket = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_id from latestticket"))['ticket_id'];

	$transaction_id = (int)1; //$transaction_id = (int)$numOfTickets + 1;
    $date = date("Y-m-d h:i:s", strtotime("now"));
    $stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
    if (!$stmt->execute()) {
        array_push($errors, 'Transfer insert failed');
    }

	//Going to have a table for making an account
	$stmt = $conn->prepare("INSERT INTO alteredaccount (ticket_id, account_owner, account_type, balance) VALUES (?, ?, ?, ?)");
	//$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	$stmt->bind_param("sssd", $transaction_id, $user, $account_type, $initBalance);
	if (!$stmt->execute()) {
		//echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
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


/*
	$stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
	//$stmt->bind_param("sssss", $transaction_id, $username, $prior, $transaction_id, $date);
	$stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
	//$stmt->execute();
*/













	//$numOfTickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(ticket_id) as ticket_count FROM ticket"))['ticket_count']; //? does it work?



//(ticket_id, account_owner, account_type, balance)
/*
	$stmt = $conn->prepare("INSERT INTO alteredaccount (ticket_id, account_owner, account_type, balance) VALUES (?, ?, ?, ?)");
	echo "WHY GOD";
	echo $latestTicket;
	//$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	$stmt->bind_param("sssd", $transaction_id, $user, $account_type, $initBalance);
	//echo "Already have requested to update Client Information!!!";
	//echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
	if (!$stmt->execute()) {
		//echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
		//echo "DIDNT WORK LOSER";
		$conn->rollback();
		header('Location: ../client.php');
    }*/
	//else { 
		echo "MY USERNAME";
		echo $user; 
		$waaa = mysqli_query($conn, "INSERT INTO ticket VALUES ('".$transaction_id."', '".$user."', '".$prior."', '".$theDescr."', '".$date."')");
		/*$stmt = $conn->prepare("INSERT INTO ticket VALUES (?, ?, ?, ?, ?)");
		//$stmt->bind_param("sssss", $transaction_id, $username, $prior, $transaction_id, $date);
		$stmt->bind_param("sssss", $transaction_id, $user, $prior, $theDescr, $date);
		$stmt->execute();*/
		
		/*
		if (!$stmt->execute()) {
			//echo "<div class=\"nav\"> <a href=\"../client.php\">Back to Your Profile Page!</a></div>";
			$conn->rollback();
		}*/









/*
		$stmt = $conn->prepare("INSERT INTO alteredaccount VALUES (?, ?, ?, ?)");
		echo "WHY GOD";
		echo $latestTicket;
		//$stmt->bind_param("ssssssssss", $transaction_id, $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
		$stmt->bind_param("sssd", $transaction_id, $user, $account_type, $initBalance);
*/




		$conn->commit();












	//}
}

$_SESSION['loginError'] = true;
header('Location: ../index.php');
?>