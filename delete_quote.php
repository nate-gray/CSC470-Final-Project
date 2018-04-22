<?php 
// Set the page title and include the header file:
define('TITLE', 'Delete Quote');
include('templates/header.php');
include('../mysqli_connect.php');

print '<h2>Delete a Quotation</h2>';

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0) ) { 

	
	$query = "SELECT text, author, favorite FROM quotes WHERE id={$_GET['id']}";
	if ($result = mysqli_query($dbc, $query)) { 

		$row = mysqli_fetch_array($result); 

		print '<form action="delete_quote.php" method="post">
		<p>Are you sure you want to delete this quote?</p>
		<div><blockquote>' . $row['text'] . '</blockquote>- ' . $row['author'];

		if ($row['favorite'] == 'Y') {
			print ' <strong>Favorite!</strong>';
		}

		print '</div><br><input type="hidden" name="id" value="' . $_GET['id'] . '">
		<p><input type="submit" name="submit" value="Delete this Quote"></p>
		</form>';

	} else { 
		print '<p class="input--error">Could not delete quote.</p>';
	}

} elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0) ) { 

	$query = "DELETE FROM quotes WHERE id={$_POST['id']} LIMIT 1";
	$result = mysqli_query($dbc, $query); 

	if (mysqli_affected_rows($dbc) == 1) {
		print '<p class="input--success">The quote entry has been deleted.</p>';
	} else {
		print '<p class="input--error">Could not delete the entry because of an error.</p>';
	}

} else { 
    print '<p class="input--error">You have reached this page in error.</p>';
} 

mysqli_close($dbc); // Close the connection.

include('templates/footer.php')
?>