<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 py-3">';
echo '<h2>EDIT THE ONLINE CONSTITUTION</h2>';

if (isset($_POST['submit']) && $_POST['submit'] == 'Submit Changes') {
    // changes are being submitted, so start processing the requested changes
    $error_string = '';
    if (isset($_POST['const_text']) && $_POST['const_text'] == '') {
        // the constitution was left blank, so append the error string
        $error_string = 'You have left the Constitution page blank!';
    }
    if ($error_string != '') {
        // there are errors, so display them
        echo '<p class="text-danger"><b>FAILED!</b></p>';
        echo '<p class="text-danger mb-3"><b>--</b> ' . $error_string . ' <b>--</b></p>';
        echo '<p class="t16"><a href="javascript:history.go(-1);">back</a></p>';
    } elseif ($error_string == "") {
        // there were no errors, so make the changes to the database
        $const_text = $_POST['const_text'];
        $new_content = $conn1->real_escape_string($const_text);
        $conn1->query("UPDATE sitepages SET page_contents='$new_content' WHERE page_id=1");
        echo '<p class="text-primary"><b>The Constitution has been successfully edited!</b></span></p>';
    }
}
if (!isset($_POST['submit'])) {
    // changes were not being submitted, so display the form
    echo '<p>Use the built-in text editor to make changes to the online constitution, then click "Submit Change" at the bottom of the page.</p>';
    echo '<p>If you ever want to reset any changes you\'ve made and start the editing process all over, click the "Reset Changes" button at the bottom of this page.</p>';
    echo '<p>By default, pressing "Enter" will make a new paragraph (double spaced). For a single line break hold down "Shift", then press "Enter".</p>';
    echo '<p class="mb-3"><b>NOTE</b>: Making changes on this page only affects the online constitution (the one you can click on directly from the top navigation bar, not the one on the "Downloads" tab).</p>';
    $query_constitution = $conn1->query("SELECT page_contents FROM sitepages WHERE page_id=1");
    $result_constitution = $query_constitution->fetch_assoc();
    $query_constitution->free_result();
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    echo '<textarea name="const_text" rows="250" cols="150">';
    echo $result_constitution['page_contents'];
    echo '</textarea>';
    echo '<input class="my-4 mr-5" type="submit" name="submit" value="Submit Changes" />';
    echo '<input class="my-4 ml-5" type="reset" value="Reset Changes" />';
    echo '</form>';
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
