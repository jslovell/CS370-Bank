<?php
session_start();
//require_once 'db.php';
require_once('../includes/functions.php');
global $conn;

// Handle the button click
if (isset($_GET['sort'])) {
    $sortColumn = $_GET['sort'];

    // Prepare and bind parameters
    $query = "SELECT ticket_id, ticket_owner, priority, description, timestamp FROM ticket ORDER BY $sortColumn";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the sorted data in the table
    $asdw = 0;
    if ($result->num_rows > 0) {
        echo "<tr><td>Ticket ID <a onclick=\"sortTable('ticket_id')\">Sort</a></td><td>Ticket Owner <a onclick=\"sortTable('ticket_owner')\">Sort</a></td><td>Priority <a onclick=\"sortTable('priority')\">Sort</a></td><td>Description <a onclick=\"sortTable('description')\">Sort</a></td><td>Timestamp <a onclick=\"sortTable('timestamp')\">Sort</a></td><td>";
        while ($row = $result->fetch_assoc()) {
            if($asdw != 0) {
                echo "<tr><td> <a href=\"adminOverrideClientInfo.php?AdminClient=" . $row['ticket_id'] . "\">". $row['ticket_id'] ."</a></td><td>" . $row['ticket_owner'] . "</td><td>" . $row['priority'] . "</td><td>" . $row['description'] . "</td><td>" . $row['timestamp'] . "</td><td>";
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
