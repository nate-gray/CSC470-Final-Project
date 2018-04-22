<?php 
define('TITLE', 'Logout');
include('templates/header.php');

if(isset($_SESSION['username'])) {
    $_SESSION = [];
    session_destroy();
    print '<p class="input--success">You have been logged out. Redirecting back to home page....</p>';
    header("Location: index.php");
} else {
    print '<p class="input--error">You need to log in first!</p>';
}


include('templates/footer.php'); // Need the footer.
?>
