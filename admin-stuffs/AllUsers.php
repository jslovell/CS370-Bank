<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('../includes/db.php');
    require_once('../includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: ../index.php');
    $user = $_SESSION['user'];
    $persInfo = getClientsTest();
    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: ../index.php');
    }

    $_SESSION['tempUser'] = "abecker"; //Place holder test value
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
                <?php echo "<td>Username <a onclick=\"sortTable('username')\">Username</a></td><td>F_NAME <a onclick=\"sortTable('f_name')\">f_name</a></td><td>L_NAME <a onclick=\"sortTable('l_name')\">l_name</a></td><td>EMAIL <a onclick=\"sortTable('email')\">email</a></td><td>PHONE_NUM <a onclick=\"sortTable('phone_num')\">phone_num</a></td><td>";?>
            </tr>
            <tr>
                <?php
                while($row = mysqli_fetch_assoc($persInfo)) {
                ?>
                <?php echo "<tr><td> <a href=\"adminOverrideClientInfo.php?AdminClient=" . $row['username'] . "\">". $row['username'] ."</a></td><td>" . $row['f_name'] . "</td><td>" . $row['l_name'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone_num'] . "</td><td>";?>
            </tr>
            <?php
}
            ?>
        </table>
    </div></div>



    <script>
        //This is the function that will return a table with it sorted by Column Tag by ASCENDING Order
        function sortTable(column) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("dataTable").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "filterUsersInTable.php?sort=" + column, true);
            xhttp.send();
        }

        //When a Users ID is clicked on it bring up their page
        function accessClient(tempestUser) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("dataTable").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "adminOverrideClientInfo.php?AdminClient=" + tempestUser, true);
            xhttp.send();
        }
    </script>


</body>
</html>
