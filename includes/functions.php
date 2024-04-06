<?php
    require_once 'db.php';

    function getAccounts($user) {
        global $conn;
        $query = "SELECT account_id, account_type, balance FROM account WHERE account_owner='".$user."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getClientInfo($user) {
        global $conn;
        $query = "SELECT f_name, l_name, email, phone_num, street_num, street, city FROM client WHERE username='".$user."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }
?>
