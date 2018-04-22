<?php 
// Set the page title and include the header file:
define('TITLE', 'Stories');
include('templates/header.php');
// Only available for logged in users. 
if(!isset($_SESSION['username'])) {
    unauthorized();
} else {
    print '<h2>Stories Uploaded</h2>';

    $dir = '../users/' . $_SESSION['username'] . '/';
    $dir = realpath($dir);
    $contents = scandir($dir);

    print '<table cellpadding="2" cellspacing="2"><tr><th>Name</th><th>Last Modified</th></tr>';
    foreach($contents as $item) {
        if((is_file(realpath($dir . '/' . $item_))) AND ( substr($item, 0, 1) != '.') AND ($item != 'books.csv')) {
            $last_modified = date('F j, Y', filemtime($dir . '/' . $item));
            print "<tr><td>$item</td><td>$last_modified</td></tr>";
        } 
    }

    print '</table>';
}



include('templates/footer.php')
?>