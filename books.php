<?php 
define('TITLE', 'Books by J.D. Salinger');
include('templates/header.php');

if($logged_in) {
    print '<form action="books.php" method="post">'
    . '<p><label>Book Title: <input type="text" name="title"></label></p>'
    . '<p><label>Book Author: <input type="text" name="author"></label></p>'
    . '<p><input type="submit" name="submit" value="Add Book"></p>';
    
    $file = '../users/' . $_SESSION['username'] . '/books.csv';
    $file = realpath($file);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!empty($_POST['title']) && !empty($_POST['author'])) {
            $fw = fopen($file, 'a');
            $new_book = array($_POST['title'], $_POST['author']);
            fputcsv($fw, $new_book, '|');
            fclose($fw);
            print '<p class="input--success">Book added!</p>';
        } else {
            print '<p class="input--error">Both a title and an author are needed.</p>';
        }
    }
    
    
    $fp = fopen($file, 'rb');
    print '<h2>My Books</h2><ul>';
    while( $line = fgetcsv($fp, 200, "|")) {
        print "<li>$line[0] by $line[1]</li>";
    }
} else {
    print '<h2>Exmaple Books</h2><ul>'
    . '<li>The catcher in the Rye</li>'
    . '<li>Nine Stories</li>'
    . '<li>Franny and Zooey</li>'
    . '<li>Raise High the Roof Beam, Carpenters and Seymour: An Introduction</li>'
    . '</ul>';
}

?>

<?php include('templates/footer.php'); ?>