<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<?php
	require_once('db.php');
  require_once('functions.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Bank</title>
</head>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<body>
  <div id="frm">
    <form autocomplete="off" method="post" action="login.php">
      <h1>Login</h1>
      <p>
        <label>Username</label>
        <input type="text" name="user" id="user" />
        <label>Password</label>
        <input type="text" name="pass" id="pass" />
        <input type="submit" id="btn" value="Login"/>
      </p>
    </form>
  </div>
</body>
</html>
