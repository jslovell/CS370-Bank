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
        $query = "SELECT username, password, f_name, l_name, email, phone_num, street_num, street, city FROM client WHERE username='".$user."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    
    function valdiateSignUp($user) {
        
    }

    



    ////ADMIN FUNCTIONS
    //This is going to be responsive about what "Filter Button was selected, aka how to filter
    function getClients($filter) {
        global $conn;
        $query = "SELECT username, f_name, l_name, email, phone_num, street_num, street, city FROM client ORDER BY '".$filter."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getClientsTest() {
        global $conn;
        $query = "SELECT username, f_name, l_name, email, phone_num, street_num, street, city FROM client";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getTicketUpdate($ticketID) {
        global $conn;
        $query = "SELECT ticket_id, username, password, f_name, l_name, email, phone_num, street_num, street, city FROM alteredUser WHERE ticket_id ='".$ticketID."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getTickets() {
        global $conn;
        $query = "SELECT ticket_id, ticket_owner, priority, description, timestamp FROM ticket";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getOneTicket($ticketID) {
        global $conn;
        $query = "SELECT ticket_id, ticket_owner, priority, description, timestamp FROM ticket WHERE ticket_id ='".$ticketID."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function getAccountTicket($ticketID) {
        global $conn;
        $query = "SELECT ticket_id, account_owner, account_type, balance FROM alteredaccount WHERE ticket_id ='".$ticketID."'";
        $result = mysqli_query($conn, $query);
        return $result;
    }
?>
