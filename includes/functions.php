<?php
    require_once 'db.php';

    function getAccounts($user) {
        global $conn;
        $query = "SELECT account_id, account_type, balance FROM account WHERE account_owner='".$user."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getOneAccount($acc) {
        global $conn;
        $query = "SELECT account_owner, account_type, balance FROM account WHERE account_id='".$acc."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getTransactions($user) {
        global $conn;
        $query= "SELECT transaction_id, send_account, rec_account, amount, timestamp FROM transaction WHERE send_account IN (SELECT account_id FROM account INNER JOIN client ON account.account_owner=client.username WHERE username='".$user."') OR rec_account IN (SELECT account_id FROM account INNER JOIN client ON account.account_owner=client.username WHERE username='".$user."')";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getOneTransaction($id) {
        global $conn;
        $query= "SELECT send_account, rec_account, amount, timestamp FROM transaction WHERE transaction_id='".$id."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getClientInfo($user) {
        global $conn;
        $query = "SELECT f_name, l_name, email, phone_num, street_num, street, city FROM client WHERE username='".$user."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    
    function valdiateSignUp($user) {
        
    }
?>
