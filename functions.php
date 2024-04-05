<?php
  require_once 'db.php';

  function display_data($user) {
    global $conn;
    $query = "SELECT account_id, account_type, balance FROM account WHERE account_owner='".$user."'";
    $result = mysqli_query($conn, $query);
    return $result;
  }
?>
