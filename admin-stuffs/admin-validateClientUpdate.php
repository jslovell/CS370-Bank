<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
    <?php
    session_start();
    require_once('../includes/db.php');
    require_once('../includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: ../index.php');
    $user = $_SESSION['user'];

    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: ../index.php');
    }

    //Acquires the Ticket ID through the URL --> Aka the ?ticket= part
    $theTicket;
    if(isset($_GET['ticket'])) {
        $theTicket = $_GET['ticket'];
    }
    $persInfo = getTicketUpdate($theTicket);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="../styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>
<body>
    <h1>Welcome, <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['f_name'] ?></h1>


    <div class="nav">
        <a href="../admin.php">Back</a>
        <a href="?logout=true">Logout</a>
    </div>

    <div id="content">

    <div class="frm">
        <form autocomplete="off" method="post" action=<?php echo "./validateClientUpdate.php?ticket=" .mysqli_fetch_assoc(getTicketUpdate($theTicket))['ticket_id'] ."" ?>>
            <label>Old Username</label>
            <input value= <?php echo mysqli_fetch_assoc(getOneTicket($theTicket))['ticket_owner'] ?> type="text" name="oldUser" id="oldUser" />
            <label>Username</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['username'] ?> type="text" name="user" id="user" />
            <label>Password</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['password'] ?> type="text" name="pass" id="pass" />

            <label>First name</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['f_name'] ?> type="text" name="fname" id="fname" />
            <label>Last Name</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['l_name'] ?> type="text" name="lname" id="lname" />

            <label>Email</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['email'] ?> type="text" name="emailer" id="emailer" />
            <label>Phone Number</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['phone_num'] ?> type="text" name="pnum" id="pnum" />

            <label>Street Number</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['street_num'] ?> type="text" name="streetnum" id="streetnum" />
            <label>Street</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['street'] ?> type="text" name="street" id="street" />
            <label>City</label>
            <input value= <?php echo mysqli_fetch_assoc(getTicketUpdate($theTicket))['city'] ?> type="text" name="city" id="city" />
            <input type="submit" id="btn" value="Confirm Changes"/>
        </form>
        <br>
        <?php if ($_SESSION['signUpError']) { ?>
            <p style='color: red;'>Not A valid Signup!</p>
        <?php } ?>
    </div>
    </div>


    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            var content = document.getElementById('content1');
            content.classList.toggle('hidden');

            var Logins = document.getElementById('content');
            Logins.classList.toggle('hidden');
        });

        document.getElementById('toggleButton1').addEventListener('click', function() {
            var content = document.getElementById('content');
            content.classList.toggle('hidden');

            var Logins = document.getElementById('content1');
            Logins.classList.toggle('hidden');
        });
    </script>
</body>
</html>
