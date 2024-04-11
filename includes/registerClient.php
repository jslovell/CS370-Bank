<?php
session_start();
require_once 'db.php'; //?
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


$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);
$firstname = mysqli_real_escape_string($conn, $firstname);
$lastname = mysqli_real_escape_string($conn, $lastname);
$emailer = mysqli_real_escape_string($conn, $emailer);
$phonenumber = mysqli_real_escape_string($conn, $phonenumber);
$streetnumber = mysqli_real_escape_string($conn, $streetnumber);
$street = mysqli_real_escape_string($conn, $street);
$city = mysqli_real_escape_string($conn, $city);




/*
$stmt = $conn->prepare("SELECT username, password FROM client WHERE username=? and password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->bind_result($username, $password);
$stmt->store_result();
*/
//my test
$stmt = $conn->prepare("SELECT username, email FROM client WHERE username=? OR email=?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();

$stmt->bind_result($username, $email);
$stmt->store_result();

//$username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber

if ($stmt->num_rows == 1 && $stmt->fetch()) {
	$_SESSION['loginError'] = true;
	header('Location: ../index.php');
} else if ($username == "admin" && $password == "admin") {
	$_SESSION['loginError'] = true;
	header('Location: ../index.php');
} else {
	$stmt = $conn->prepare("INSERT INTO client (username, password, f_name, l_name, email, phone_num, street_num, street, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssssssss", $username, $password, $firstname, $lastname, $emailer, $phonenumber, $streetnumber, $street, $city);
	$stmt->execute();
	$_SESSION['user'] = $username;
	$_SESSION['loginError'] = false;
	header('Location: ../client.php');
}

?>