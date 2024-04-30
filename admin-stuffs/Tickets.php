<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('../includes/db.php');
    require_once('../includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: ../index.php');
    $user = $_SESSION['user'];
    $persInfo = getTickets();
    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: ../index.php');
    }

    $_SESSION['tempUser'] = "abecker"; //Placeholder Test
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="../styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>
<body>
    <h1>All Client Accounts : Admin View</h1>
    <div class="nav">
        <a href="../admin.php">Back</a>
        <a href="?logout=true">Logout</a>
    </div>

    <div class="wrapper"><div class="table">
        <table id="dataTable">
            <tr>
                <?php echo "<td>Ticket ID <a onclick=\"sortTable('ticket_id')\">Sort</a></td><td>Ticket Owner <a onclick=\"sortTable('ticket_owner')\">Sort</a></td><td>Priority <a onclick=\"sortTable('priority')\">Sort</a></td><td>Description <a onclick=\"sortTable('description')\">Sort</a></td><td>Timestamp <a onclick=\"sortTable('timestamp')\">Sort</a></td><td>";?>
            </tr>
            <tr>
                <?php
                while($row = mysqli_fetch_assoc($persInfo)) {
                ?>
                <?php echo "<tr><td> <a href=\"../Ticket-Stuffs/handleTicketRequests.php?ticket=" . $row['ticket_id'] . "\">". $row['ticket_id'] ."</a></td><td>" . $row['ticket_owner'] . "</td><td>" . $row['priority'] . "</td><td>" . $row['description'] . "</td><td>" . $row['timestamp'] . "</td><td>";?>


            </tr>
            <?php
}
            ?>

        </table>
    </div></div>



    <script>
        //Havent worked on sort functionality for Tickets
        function sortTable(column) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("dataTable").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "filterTicketsInTable.php?sort=" + column, true); //Need to Copy php files destination and modify it so it works for tickets
            xhttp.send();
        }
        //Havent worked on sort functionality for Tickets or modified (WIP)
        function accessClient(tempestUser) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("dataTable").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "validateClientUpdate.php?ticket=" + tempestUser, true); //Need to Copy php files destination and modify it so it works for tickets
            xhttp.send();
        }
    </script>


</body>
</html>
