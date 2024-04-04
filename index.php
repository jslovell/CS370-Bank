<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<?php
	require_once('db.php');
  require_once('functions.php');
  $result = display_data();
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
    <form method="post">

      <p>
      <center><H1>Sql injcetion test!
      </center>

      </p>
      <p>
      <center>
      <label>User Name</label>
        <input type="text" name="user" id="user">



      <label>Password</label>
        <input type="text" name="pass" id="pass">

      </center>
      </p>
      <center>
        <input type="submit" id="btn" value="Login"/>

      </center>
    </form>
  </div>

	<div id="table">
	<table>
		<tr>
			<td>Username</td>
			<td>Password</td>
			<td>FirstName</td>
			<td>MiddleInitial</td>
			<td>LastName</td>
		</tr>
		<tr>
		<?php
			while ($row = mysqli_fetch_assoc($result)) {
		?>
			<td><?php echo $row['Username']; ?></td>
			<td><?php echo $row['Password']; ?></td>
			<td><?php echo $row['FirstName']; ?></td>
			<td><?php echo $row['MiddleInitial']; ?></td>
			<td><?php echo $row['LastName']; ?></td>
		</tr>
		<?php
		}
		?>
	</table>
	</div>
</body>
</html>
