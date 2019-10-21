<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 py-3">';
echo '<h2>ADD A NEW DOWLOAD</h2>';

if (isset($_POST['submit']) && $_POST['submit'] == 'Add New Download') {
    // the form has been submitted, error check the inputs
    $error_string = '';
    if ($_POST['description'] == '') {
        $error_string .= '<p class="text-danger">The description field was left blank!</p>';
    }
    if ($_FILES['new_file']['size'] == 0) {
        $error_string .= '<p class="text-danger">No file was selected to be uploaded!</p>';
    }
}
if (isset($_POST['submit']) && isset($error_string) && $error_string == '') {
    // the form was submitted and has no errors, so add the new download
    $target_dir = '../downloads/';
    $target_path = $target_dir . basename($_FILES['new_file']['name']);
    if (move_uploaded_file($_FILES['new_file']['tmp_name'], $target_path)) {
        $new_file_name = basename($_FILES['new_file']['name']);
        $conn1->query("INSERT INTO downloads (download_id, description, file_name, display, download_order) VALUES(NULL, '{$_POST['description']}', '$new_file_name', {$_POST['display']}, 1)");
        echo '<p>The new download has been added successfully.</p>';
    } else {
        echo '<p class="text-danger">There was an error uploading the file, <a href="add_download.php"><b>please try again</b></a>!</p>';
    }
} elseif ((isset($_POST['submit']) && isset($error_string) && $error_string != '') || !isset($_POST['submit'])) {
    // the form either was submitted and has errors or wasn't submitted at all
    if (isset($error_string) && $error_string != '') {
        echo '<p class="text-danger"><b>ERROR!</b></p>';
        echo '<p>' . $error_string . '</p>';
    }
    echo '<form action="add_download.php" method="post" enctype="multipart/form-data">';
    echo '<p class="my-1"><b>Description</b> (name that shows up in the navigation bar and on the downloads page... max length is 40 characters):</p>';
    echo '<input class="mb-4" type="text" name="description" value="';
    if (isset($_POST['description'])) {
        echo $_POST['description'];
    }
    echo '" size="40" maxlength="40" />';
    echo '<p class="my-1"><b>Display (enable) this page</b> (this includes displaying it on both the navigation bar and the downloads page... selecting "No" will not delete the download, just disable it until it\'s re-enabled):</p>';
    echo 'Yes <input class="mr-4" type="radio" name="display" value="1" checked />';
    echo 'No <input class="mb-4" type="radio" name="display" value="0" />';
    echo '<p class="my-1"><b>Upload a file to be associated with this download:</b></p>';
    echo '<input class="mb-4 mr-5" name="new_file" type="file" id="new_file" size="50">';
    echo '<input class="mb-4" type="submit" name="submit" value="Add New Download" />';
    echo '</form>';
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
