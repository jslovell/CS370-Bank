<?php
require_once 'db.php';

// Grab User submitted information
$username = $_POST["user"];
$password = $_POST["pass"];

$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$stmt = $conn->prepare("SELECT username, password FROM client WHERE username=? and password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->bind_result($username, $password);
$stmt->store_result();

if ($stmt->num_rows == 1 && $stmt->fetch()) {
	header("Location: client.php?user=".$username);
} else {
	echo 'failure';
}
?>
