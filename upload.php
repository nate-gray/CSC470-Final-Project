<?php 
// Set the page title and include the header file:
define('TITLE', 'Upload');
include('templates/header.php');

// Only available for logged in users. 
if(!isset($_SESSION['username'])) {
    unauthorized();
} else {
    print '<h2>Upload Files</h2>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dir = '../users/' . $_SESSION['username'] . '/';
        $dir = realpath($dir);

        // Check the file extension/type
        $valid = FALSE;
        if($_FILES['the_file']['type'] == 'application/pdf' || $_FILES['the_file']['type'] == 'application/msword' || $_FILES['the_file']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $_FILES['the_file']['type'] == 'text/plain') {
            $valid = true;
        }

        if($valid) {
            if(move_uploaded_file($_FILES['the_file']['tmp_name'], "$dir{$_FILES['the_file']['name']}")) {
                print '<p class="input--success">File successfully uploaded!</p>';
            }
        } else {
            // Invalid file type.
            print '<p class="input--error">Unsupported file type.</p>';
          }
    }
    
    print '<form action="upload.php " enctype="multipart/form-data" method="post">
    <p>Upload a story file. Please note your file must have an extension of .pdf, .doc, .docx, or .txt.</p>
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
    <p><input type="file" name="the_file"</p>
    <p><input type="submit" name="submit" value="Upload This File"></p>    
    </form>';
}

?>




<?php
include('templates/footer.php')
?>