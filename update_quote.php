<?php 
// Set the page title and include the header file:
define('TITLE', 'Update Quote');
include('templates/header.php');
include('../mysqli_connect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(isset($_SESSION['username'])) {
    print '<h2>Update Quote</h2>';

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $query = "SELECT text, author, favorite FROM quotes WHERE id={$_GET['id']}";
    if($result = mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($result);
        
        print '<form action="update_quote.php" method="post">'
        . '<p><label>Author: <input type="text" name="author" value="' . htmlentities($row['author']) . '"></label></p>'
        . '<p><label>Quote Text: <textarea name="text" rows="5" cols="30">' . htmlentities($row['text']) . '</textarea></label></p>'
        . '<p><label>Check to add as a favorite <input type="checkbox" name="favorite" value="yes"';
        
        if($row['favorite'] == 'Y') {
            print ' checked="checked"';
        }
        
        print '></label></p><input type="hidden" name="id" value="' . $_GET['id'] . '">'
                . '<p><input type="submit" name="submit" value="Update Quote"></p>'
                . '</form>';
    }
} elseif(isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0) {
    $problem = false;
    if(!empty($_POST['text']) && !empty($_POST['author'])) {
        $quote = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['text'])));
        $author = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['author'])));
        
        if(isset($_POST['favorite'])) {
            $favorite = 'Y';
        } else {
            $favorite = 'N';
        }
    } else {
        print '<p class="input--error">Please submit both a quotation and an author.</p>';
        $problem = true;
    }
    
    if(!$problem) {
        $query = "UPDATE quotes SET text='$quote', author='$author', favorite='$favorite' WHERE id={$_POST['id']}";
        if($result = mysqli_query($dbc, $query)) {
            print '<p class="input--success">The quotation has been updated.</p>';
        } else {
            print '<p class="input--error">The quotation could not be updated.</p>';
        }
    } else {
        print '<p class="input--error">This page has been accessed in error.</p>';
    }
}

mysqli_close($dbc);

} else {
    unauthorized();
}
    
} else {
    print '<p class="input--error">You have reached this page in error.</p>';
}




include('templates/footer.php')
?>