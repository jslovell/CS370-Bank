<?php
  require_once 'db.php';

  function display_data($user) {
    global $conn;
    $query = "SELECT * FROM User WHERE Username='".$user."'";
    $result = mysqli_query($conn, $query);
    return $result;
  }
?>
