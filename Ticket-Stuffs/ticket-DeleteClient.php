<?php
session_start();
require_once '../includes/db.php';

require_once('../includes/functions.php');
if (!isset($_SESSION['user'])) header('Location: ../index.php');
$user = $_SESSION['user'];
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}

//Acquiring the ticket_id from ?
$theTicket;
$theTicket = $_GET['ticket'];
echo $theTicket;
$theClientInfo = getOneTicket($theTicket);

//Getting the username of whom requested this ticket
$theClient = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ticket_owner FROM ticket WHERE ticket.ticket_id='".$theTicket."'"))['ticket_owner'];
echo $theClient;
$_SESSION['signUpError'] = false;





$stmt = $conn->prepare("DELETE FROM client WHERE client.username=?");
if ($stmt === false) {
    die('Error: ' . $conn->error); // Handle prepare error
}

$stmt->bind_param("s", $theClient);
if ($stmt === false) {
    die('Error: ' . $stmt->error); // Handle bind_param error
}

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}


header('Location: ../admin.php');
?>