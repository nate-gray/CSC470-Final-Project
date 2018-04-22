<?php 
// Set the page title and include the header file:
define('TITLE', 'Quotes');
include('templates/header.php');
include('../mysqli_connect.php');


print '<h2>Quotes</h2>';

if($logged_in) {
    print '<h4><a href="add_quote.php">Add New Quote</a></h4>';
}

$query = 'SELECT id, text, author, favorite FROM quotes ORDER BY date_entered DESC';
if($result = mysqli_query($dbc, $query)) {
    
    while($row = mysqli_fetch_array($result)) {
        print "<div><blockquote>{$row['text']}</blockquote>- {$row['author']}\n";
        
        if($row['favorite'] == 'Y') {
            print ' <strong style="color: red;">Favorite!</strong>';
        }
        
        if($logged_in) {
            print "<p><a href=\"update_quote.php?id={$row['id']}\">Edit</a> <a href=\"delete_quote.php?id={$row['id']}\">Delete</a></div>\n<hr>";
        }
    }
} 

mysqli_close($dbc);

include('templates/footer.php')
?>