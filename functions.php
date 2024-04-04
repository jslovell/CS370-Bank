<?php
  require_once 'db.php';

  function display_data() {
    global $conn;
    $query = "SELECT * FROM User";
    $result = mysqli_query($conn, $query);
    return $result;
  }
?>
