<?php
session_start();
//require_once 'db.php';
require_once('../includes/functions.php');
global $conn;

// Handle the button click
if (isset($_GET['sort'])) {
    $sortColumn = $_GET['sort'];

    // Prepare and bind parameters
    $query = "SELECT username, f_name, l_name, email, phone_num, street_num, street, city FROM client ORDER BY $sortColumn";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the sorted data in the table
    $asdw = 0;
    if ($result->num_rows > 0) {
        echo "<tr><td>Username <a onclick=\"sortTable('username')\">Username</a></td><td>F_NAME <a onclick=\"sortTable('f_name')\">f_name</a></td><td>L_NAME <a onclick=\"sortTable('l_name')\">l_name</a></td><td>EMAIL <a onclick=\"sortTable('email')\">email</a></td><td>PHONE_NUM <a onclick=\"sortTable('phone_num')\">phone_num</a></td><td>";
        while ($row = $result->fetch_assoc()) {
            if($asdw != 0) {
                echo "<tr><td> <a href=\"adminOverrideClientInfo.php?AdminClient=" . $row['username'] . "\">". $row['username'] ."</a></td><td>" . $row['f_name'] . "</td><td>" . $row['l_name'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone_num'] . "</td><td>";
            }
            else {
                //Originally was to hide admin info in the Login/client database
            }
            $asdw = $asdw + 1;
        }
    } else {
        echo "0 results";
    }

}
?>
