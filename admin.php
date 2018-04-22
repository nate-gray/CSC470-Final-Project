<?php 
// Set the page title and include the header file:
define('TITLE', 'Admin');
include('templates/header.php');
include('../mysqli_connect.php');

// If they are not an admin, this page is unaccessable. 
if(isset ($_SESSION['username'])) {
    if(!isAdmin($_SESSION['username'])) {
        unauthorized();
    } else {
    print '<h2>Administrator Functions</h2>';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // handle the form.
        
        print '<p>Username: <strong>' . $_POST['un'] . '</strong></p>';
        $query_status = "SELECT status, admin FROM users WHERE username='{$_POST['un']}'";
        if($result = mysqli_query($dbc, $query_status)) {
            $row = mysqli_fetch_array($result);
            
            print '<div><h3>Account Options</h3><form action="status.php" method="post">'
            . '<input type="radio" name="change" value="OPEN"';

            if($row['status'] == 'OPEN') {
                print 'checked="checked"';
            }
            
            print '> Open<br>';
            
            print '<input type="radio" name="change" value="LOCKED"';
            
            if($row['status'] == 'LOCKED') {
                print 'checked="checked"';
            }
            
            print '> Locked<br>';
            
            print '<input type="radio" name="change"'; 
            
            if($row['admin'] == 'Y') {
                print 'value="revoke_admin"> Revoke Administrator Role<br>';
            } else {
                print 'value="make_admin"> Grant Administrator Role<br>';
            }
            
            print '<input type="radio" name="change" value="delete"> Delete This Account<br>'
            . '<input type="hidden" name="user" value="'. $_POST['un'] . '">'
            . '</div>'
            . '<input type="submit" name="submit" value="Submit Changes" class="button--pill">'
            . '</form>';
        }    
        
        
        
        
        
        
    } else {
        print '<form action="admin.php" method="post" class="form--inline">'
        . '<p><label>Username <select name="un">';
    
        $query_users = "SELECT username FROM users";
        if ($result = mysqli_query($dbc, $query_users)) { 
            while($row = mysqli_fetch_array($result)) {
                if($row['username'] != $_SESSION['username']) {
                    print '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
                }  
            }
            
        }
    
        print '</select> <input type="submit" name="submit" value="Submit" class="button--pill">';
    }
    
    
    
}
} else {
    unauthorized();
}


include('templates/footer.php')
?>