<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
    <?php
    session_start();
    require_once('includes/db.php');
    require_once('includes/functions.php');
    if (!isset($_SESSION['user'])) header('Location: index.php');
    $user = $_SESSION['user'];
    $accounts = getAccounts($user);
    $persInfo = getClientInfo($user);
    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="styles/styles.css">
<title>Very Legitimate Bank Inc.</title>
</head>
<body>
    <h1>Welcome, <?php echo mysqli_fetch_assoc(getClientInfo($user))['f_name'] ?></h1>


    <div class="nav">
        <a href="client.php">Back</a>
        <a href="?logout=true">Logout</a>
    </div>

    <div id="content">
    <div class="frm">
        <form autocomplete="off" method="post" action="includes/update-client.php">
            <label>Username</label>
            <input value= <?php echo $user ?> type="text" name="user" id="user" />
            <label>Password</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['password'] ?> type="text" name="pass" id="pass" />

            <label>First name</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['f_name'] ?> type="text" name="fname" id="fname" />
            <label>Last Name</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['l_name'] ?> type="text" name="lname" id="lname" />

            <label>Email</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['email'] ?> type="text" name="emailer" id="emailer" />
            <label>Phone Number</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['phone_num'] ?> type="text" name="pnum" id="pnum" />

            <label>Street Number</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['street_num'] ?> type="text" name="streetnum" id="streetnum" />
            <label>Street</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['street'] ?> type="text" name="street" id="street" />
            <label>City</label>
            <input value= <?php echo mysqli_fetch_assoc(getClientInfo($user))['city'] ?> type="text" name="city" id="city" />
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