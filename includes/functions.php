<?php
include('../mysqli_connect.php');

function unauthorized() {
    print '<p class="input--error">Unauthorized.</p>';
}

function checkAccountStatus($un) {
    $query = "SELECT username, status FROM users WHERE username='$un'";
    global $dbc;
    if ($result = mysqli_query($dbc, $query)) { 
        $row = mysqli_fetch_array($result);

        if($row['status'] == 'LOCKED') {
            return true;
        } else {
            return false;
        }
    }
}

function isAdmin($un) {     
    $query = "SELECT username, admin FROM users WHERE username='$un'";
    global $dbc;
    if ($result = mysqli_query($dbc, $query)) { 
        $row = mysqli_fetch_array($result);

        if($row['admin'] == 'Y') {
            return true;
        } else {
            return false;
        }
    }
}


?>