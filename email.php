<?php 
define('TITLE', 'Contact');
include('templates/header.php'); 
include('../config.php');
require 'phpmailer/PHPMailerAutoload.php';

print '<h2>Email Form</h2>';

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Handle the form:
	if ( (!empty($_POST['email'])) && (!empty($_POST['subject'])) && (!empty($_POST['message'])) ) {

		$mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                
                $mail->Host = $host;
                $mail->Username = $username;
                $mail->Password = $password;
                $mail->SMTPSecure = $SMTPsecure;
                $mail->Port = $port;
                
                $mail->addAddress($username);
                $mail->FromName = $_POST['email'];
                $mail->Subject = $_POST['subject'];
                $mail->Body= $_POST['message'];
                
                if(!$mail->send()) {
                    print '<p class="input--error">Unable to send email.</p>';
                } else {
                    print '<p style=input--success">Email sent!</p>';
                }
                

	} else { // Forgot a field.

		print '<p class="input--error">Please make sure you enter an email address, subject, and a message!</p>';

	}

} else { // Display the form.

    if(isset($_SESSION['username'])) {
        print '<form action="email.php" method="post" class="form--inline">
	<p><label for="email">My Email</label><input type="email" name="email" size="20"></p>
	<p><label for="subject">Subject</label><input type="text" name="subject" size="20"></p>
        <p><label for="message">Message:</label></p>
        <p><textarea name="message" rows="9" cols="30"></textarea></p>
	<p><input type="submit" name="submit" value="Submit" class="button--pill"></p>
	</form>';
    } else {
        unauthorized();
    }


}


// Leave the PHP section to display lots of HTML:
?>


<?php include('templates/footer.php'); // Need the footer. ?>