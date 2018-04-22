<?php 
// Set the page title and include the header file:
define('TITLE', 'Add Quote');
include('templates/header.php');
include('../mysqli_connect.php');

if(isset($_SESSION['username'])) {
    print '<h2>Add a Quotation</h2>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!empty($_POST['quote']) && !empty($_POST['author'])) {
            $quote = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['quote'])));
            $author = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['author'])));

            //Create favorite value
            if(isset($_POST['favorite'])) {
                $favorite = 'Y';
            } else {
                $favorite = 'N';
            }

            $date = date("Y-m-d H:i:s");
            $query = "INSERT INTO quotes (text, author, favorite, date_entered) VALUES ('$quote', '$author', '$favorite', '$date')";
            mysqli_query($dbc, $query);

            if(mysqli_affected_rows($dbc) == 1) {
                print '<p class="input--success">Your quotation has been stored.</p>';
            } else {
                print '<p class="input--error">Your quotation could not be stored.</p>';
            }

            mysqli_close($dbc);
        } else {
            print '<p class="input--error">Please enter a quotation and an author!</p>';
        }
        
    }
    
    print '<form action="add_quote.php" method="post">
    <p><label>Quote <textarea name="quote" rows="5" cols="30"></textarea></label></p>
    <p><label>Author <input type="text" name="author"></label></p>
    <p><label>Is this a favorite? <input type="checkbox" name="favorite" value="yes"></label></p>
    <p><input type="submit" name="submit" value="Add this quote!"></p>
    </form>';
    
} else {
     print '<p class="input--error">You need to log in first!</p>';
}
?>  
    
<?php
include('templates/footer.php')
?>