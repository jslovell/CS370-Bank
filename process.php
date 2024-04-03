<?php

// Grab User submitted information
$username = $_POST["user"];
$password = $_POST["pass"];



// Create connection #servername, username, password, db 
$conn = mysqli_connect("localhost", "root", "","csspring24");
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

//mysql_select_db("class",$con);

$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);


//$sql = "SELECT username, password  FROM user_info where username='$username' and password= '$password'";
//$result = $conn->query($sql);
//$check =mysqli_fetch_array($result);
$stmt = $conn->prepare("SELECT username, password FROM user_info WHERE username=? and password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->bind_result($username, $password);
$stmt->store_result();

if($stmt->num_rows == 1 && $stmt->fetch()){
	
	echo 'success';
}

else
{
	echo 'failure';
}




?>