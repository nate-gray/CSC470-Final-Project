<?php 
// Set the page title and include the header file:
define('TITLE', 'Status');
include('templates/header.php');
include('../mysqli_connect.php');

if($_POST['change'] == 'OPEN') {
    $query = "UPDATE users SET status='OPEN' WHERE username='{$_POST['user']}'";
    if($result = mysqli_query($dbc, $query)) {
        print '<p class="input--success">Account is open.</p>';
    } else {
        print '<p class="input--error">Unable to perform update to account.</p>';
    }
    mysqli_close($dbc);
}elseif($_POST['change'] == 'LOCKED') {
    $query = "UPDATE users SET status='LOCKED' WHERE username='{$_POST['user']}'";
    if($result = mysqli_query($dbc, $query)) {
        print '<p class="input--success">Account is locked.</p>';
    } else {
        print '<p class="input--error">Unable to perform update to account.</p>';
    }
    mysqli_close($dbc);
} elseif($_POST['change'] == 'make_admin') {
        $query = "UPDATE users SET admin='Y' WHERE username='{$_POST['user']}'";
    if($result = mysqli_query($dbc, $query)) {
        print '<p class="input--success">Account is now admin.</p>';
    } else {
        print '<p class="input--error">Unable to perform update to account.</p>';
    }
    mysqli_close($dbc);
} elseif($_POST['change'] == 'delete') {
     $query = "DELETE FROM users WHERE username='{$_POST['user']}'";
     
     $dir = '../users/' . $_POST['user'] . '/';
     $contents = scandir($dir);
     foreach($contents as $item) {
         if(( substr($item, 0, 1) != '.')){
            unlink(urldecode($dir . $item)); 
         }    
     }
     rmdir($dir);
     
    if($result = mysqli_query($dbc, $query)) {
        print '<p class="input--success">Account has been deleted.</p>';
    } else {
        print '<p class="input--error">Unable to perform update to account.</p>';
    }
    mysqli_close($dbc);
} 


include('templates/footer.php')
?>