<?php 
define('TITLE', 'Register');
include('templates/header.php');

// TODO: Do not make available if logged in and registered. 

// Print some introductory text:
print '<h2>Registration Form</h2>
	<p>Register so that you can take full advantage of this site.</p>';

include('../mysqli_connect.php');
//$dbc = mysqli_connect('localhost', 'web_user', 'webpassword', 'fanclub');
//mysqli_set_charset($dbc, 'utf8');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $problem = false; // No problems so far.

    // Check for each value...
    if (empty($_POST['username'])) {
        $problem = true;
        print '<p class="input--error">Please enter your first name!</p>';
    }

    if (empty($_POST['password1'])) {
        $problem = true;
        print '<p class="input--error">Please enter a password!</p>';
    }

    if ($_POST['password1'] != $_POST['password2']) {
        $problem = true;
        print '<p class="input--error">Your password did not match your confirmed password!</p>';
    } 

    if (!$problem) { // If there weren't any problems...

        $un_exists = false;
        // Check to see if the username exists in the db
        $users = 'SELECT * FROM users';
        if($r = mysqli_query($dbc, $users)) {
            while($row = mysqli_fetch_array($r)) {
                if($row['username'] == (trim(strip_tags($_POST['username'])))) {
                    $un_exists = true;
                    break;
                }
            }
        }

        // If the username does not exist, then add them to the db. 
        if(!$un_exists) {
            // Display a message.
            print '<p class="input--success">You are now registered! <a href="login.php">Click here</a> to login.</p>';
            
            // Add them to the db
            $un = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['username'])));
            $pw = password_hash(trim($_POST['password1']), PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password, user_dir, status, admin) VALUES ('$un', '$pw', '$un', 'OPEN', 'N')";
            mysqli_query($dbc, $query);

            // Create the users directory along with the csv file
            $dir = '../users/' . $un;
            mkdir($dir);
            $file = fopen($dir . '/books.csv', 'x+');
            fclose($file);
            
            // Clear the posted values:
            $_POST = []; 
            
            
        } else { // If the username already exists
            print '<p class="input--error">Username already exists!</p>';
        }

    } else { // Forgot a field.

        print '<p class="input--error">Please try again!</p>';

    }

} // End of handle form IF.

// Create the form:
?>
<form action="register.php" method="post" class="form--inline">
	<p><label for="username">Username:</label><input type="text" name="username" size="20" value="<?php if (isset($_POST['username'])) { print htmlspecialchars($_POST['username']); } ?>"></p>
	<p><label for="password1">Password:</label><input type="password" name="password1" size="20" value="<?php if (isset($_POST['password1'])) { print htmlspecialchars($_POST['password1']); } ?>"></p>
	<p><label for="password2">Confirm Password:</label><input type="password" name="password2" size="20" value="<?php if (isset($_POST['password2'])) { print htmlspecialchars($_POST['password2']); } ?>"></p>
	<p><input type="submit" name="submit" value="Register!" class="button--pill"></p>

</form>

<?php include('templates/footer.php'); // Need the footer. ?>