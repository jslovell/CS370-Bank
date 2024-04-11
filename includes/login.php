<?php
session_start();
require_once 'db.php';

// Grab User submitted information
$username = $_POST['user'];
$password = $_POST['pass'];

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
	$_SESSION['user'] = $username;
	$_SESSION['loginError'] = false;
	header('Location: ../client.php');
} else if ($username == "admin" && $password == "admin") {
	$_SESSION['user'] = $username;
	$_SESSION['loginError'] = false;
	header('Location: ../admin.php');
} else {
	$_SESSION['loginError'] = true;
	header('Location: ../index.php');
}
?>
