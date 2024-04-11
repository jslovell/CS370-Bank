<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    require_once('includes/db.php');
    //if (!isset($_SESSION['signUpError'])) $_SESSION['signUpError'] = false;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>

<body>
    <h1>Very Legitimate Bank Inc.</h1>
    <br>
   

    <button id="toggleButton1">Toggle Element</button>
    <div id="content" class="hidden1">
    <div class="frm">
        <form autocomplete="off" method="post" action="includes/registerClient.php">
            <label>Username</label>
            <input type="text" name="user" id="user" />
            <label>Password</label>
            <input type="text" name="pass" id="pass" />

            <label>First name</label>
            <input type="text" name="fname" id="fname" />
            <label>Last Name</label>
            <input type="text" name="lname" id="lname" />

            <label>Email</label>
            <input type="text" name="emailer" id="emailer" />
            <label>Phone Number</label>
            <input type="text" name="pnum" id="pnum" />

            <label>Street Number</label>
            <input type="text" name="streetnum" id="streetnum" />
            <label>Street</label>
            <input type="text" name="street" id="street" />
            <label>City</label>
            <input type="text" name="city" id="city" />
            <input type="submit" id="btn" value="Login"/>
        </form>
        <?php if ($_SESSION['signUpError']) { ?>
            <p style='color: red;'>Not A valid Signup!</p>
        <?php } ?>
    </div>
    </div>


    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            var content = document.getElementById('content');
            content.classList.toggle('hidden');
        });
    </script>
</body>
</html>