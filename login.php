<?php 
define('TITLE', 'Login');
include('templates/header.php');

//Connect to the db
include('../mysqli_connect.php');

if(isset($_SESSION['username'])) {
    print '<p>You are already logged in!</p>';
} else {
    // Print some introductory text:
print '<h2>Login Form</h2>
	<p>Please login to get full access to the site.</p>';

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Check the db to see if the username/pw exist and match. 
    
    $user_verified = false;
    $user_locked = false;
    // Check to see if the username exists in the db
    $users = 'SELECT * FROM users';
    if($r = mysqli_query($dbc, $users)) {
        while($row = mysqli_fetch_array($r)) {
            
            // If a username and password are found and match, the user is verfied in the db. 
            if(($row['username'] == (trim(strip_tags($_POST['username'])))) && (password_verify(trim($_POST['password']), $row['password']))) {
                $user_verified = true;
                
                if($row['status'] == 'LOCKED') {
                    $user_locked = true;
                }
                
                break;
            }
        }
    }

    // Handle the form:
    if ( (!empty($_POST['username'])) && (!empty($_POST['password']))) {

            if ($user_verified) {
                if($user_locked) {
                    print '<p class="input--error">Account locked, contact your administrator.</p>';
                } else {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['loggedin'] = time();
                    print '<p class="input--success">You have been logged in. Redirecting back to home page....</p>';
                    header("Location: index.php");
                }
                

            } else { // Incorrect!

                print '<p class="input--error">The submitted username and password do not match those on file!<br>Go back and try again.</p>';

            }

    } else { 

        print '<p class="text--error">Please make sure you enter both a username and a password!<br>Go back and try again.</p>';

    }

} else { // Display the form.

    print '<form action="login.php" method="post" class="form--inline">
    <p><label for="username">Username:</label><input type="text" name="username" size="20"></p>
    <p><label for="password">Password:</label><input type="password" name="password" size="20"></p>
    <p><input type="submit" name="submit" value="Log In!" class="button--pill"></p>
    </form>';

}
}



include('templates/footer.php'); // Need the footer.
?>