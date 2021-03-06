<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 py-3">';

// check to see if a submit button has been clicked
if (isset($_POST['submit']) && $_POST['submit'] == 'Edit News') {
    // an edited news item has been submitted
    // set error variables for blank testing and format testing
    // set the total errors variable
    $t_errors = 0;
    // set the blank field error variable
    $b_errors = 0;
    // set the date formatting error variable
    $f_errors = 0;
    // if the submit button has been clicked, check to see if any of the fields are blank
    if (($_POST['newsheader'] == '') || ($_POST['newsdate'] == '') || ($_POST['newstext'] == '')) {
        $b_errors++;
        $t_errors++;
    }
    // if the submit button has been clicked, check to see if the date field is formatted correctly
    if (($_POST['newsdate'] != '') && (!preg_match('/^20[0-9]{2}-[0-1][0-9]-[0-3][0-9]$/', $_POST['newsdate']))) {
        $f_errors++;
        $t_errors++;
    }
    if ($t_errors == 0) {
        // if no $_POST items are blank or not formatted properly proceed with form processing
        $newsheader = $_POST['newsheader'];
        $add_newsheader = $conn1->real_escape_string($newsheader);
        $newsdate = $_POST['newsdate'];
        $add_newsdate = $conn1->real_escape_string($newsdate);
        $newstext = $_POST['newstext'];
        $add_newstext = $conn1->real_escape_string($newstext);
        // update items in the database since there is an existing news_id
        $update_news = $_POST['news_id'];
        $conn1->query("UPDATE rmlnews SET newsheader='$add_newsheader', newsdate='$add_newsdate', newstext='$add_newstext' WHERE news_id=$update_news");
        // display confirmation message that the info has been updated in the database
        echo '<p class="bigger text-primary"><b>A news item has been edited with the following:</b></p>';
        echo '<h4>' . $add_newsheader . '</h4>';
        echo '<p class="small text-secondary">Posted on: ' . $add_newsdate . '</p>';
        echo $_POST['newstext'];
    }
}
if (((isset($_POST['submit']) && $_POST['submit'] == 'Select Item') && (isset($_POST['news_id']) && $_POST['news_id'] != '')) || (isset($_POST['submit']) && $_POST['submit'] == 'Edit News' && isset($t_errors) && $t_errors > 0)) {
    if ($_POST['submit'] == "Select Item") {
        // since an item was just selected, find the existing item in the database\
        $cur_news = $_POST['news_id'];
        $query_news = $conn1->query("SELECT * FROM rmlnews WHERE news_id=$cur_news");
        $result_news = $query_news->fetch_assoc();
        $query_news->free_result();
        $news_id = $result_news['news_id'];
        $newsheader = $result_news['newsheader'];
        $newsdate = $result_news['newsdate'];
        $newstext = $result_news['newstext'];
    } elseif ($_POST['submit'] == "Edit News") {
        $news_id = $_POST['news_id'];
        $newsheader = $_POST['newsheader'];
        $newsdate = $_POST['newsdate'];
        $newstext = $_POST['newstext'];
    }
    if (isset($t_errors) && $t_errors > 0) {
        echo '<p class="bigger text-danger"><b>FAILED!</b></p>';
        echo '<p class="bigger text-danger">Correct these items and resubmit the form:</p>';
        if (isset($b_errors) && $b_errors > 0) {
            echo '<p class="bigger text-danger"><b>--</b> One or more or the fields have been left <b>blank</b>. <b>--</b></p>';
        }
        if (isset($f_errors) && $f_errors > 0) {
            echo '<p class="bigger text-danger"><b>--</b> The <b>date field</b> is not in the proper format. <b>--</b></p>';
        }
    }
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    echo '<h2>EDIT EXISTING NEWS ITEM</h2>';
    echo '<input type="hidden" name="news_id" value="' . $news_id . '" />';

    echo '<div class="pb-4 bb-dotted">';
    echo '<p class="mb-2"><b>News ID: </b><input class="ml-2" type="text" size="10" maxlength="3" disabled="disabled" value="' . $news_id . '" /></p>';
    echo '<p class="small mb-0">(This value cannot be modified.)</p>';
    echo '</div>';

    echo '<div class="py-4 bb-dotted">';
    echo '<p><b>Enter newsheader</b> (ie: "Pages Updated" or "Series 6 Results"):</p>';
    echo '<input type="text" name="newsheader" size="50" maxlength="60" value="' . $newsheader . '" />';
    echo '</div>';

    echo '<div class="py-4 bb-dotted">';
    echo '<p><b>Enter newsdate</b> (in this format: YYYY-MM-DD):</p>';
    echo '<input type="text" name="newsdate" id="datepicker" size="15" maxlength="10" value="' . $newsdate . '" />';
    echo '</div>';

    echo '<div class="py-4 bb-dotted">';
    echo '<p><b>Enter newstext</b> (for a single line break hold Shift, then press Enter):</p>';
    echo '<textarea name="newstext" rows="20" cols="100">' . $newstext . '</textarea>';
    echo '</div>';

    echo '<div class="py-4 mb-5 bb-dotted">';
    echo '<p class="mb-0">Click "Edit Item" to submit changes to this news item: <input class="ml-2" type="submit" name="submit" value="Edit News" /></p>';
    echo '</div>';

    echo '<div class="py-4">';
    echo '<p class="mb-0 text-danger">To <b>DELETE</b> this News Item, click "<b>Delete Item</b>": <input class="ml-2" type="submit" name="submit" value="Delete Item" />';
    echo '</p>';
    echo '</div>';

    echo '</form>';
}
if (isset($_POST['submit']) && $_POST['submit'] == 'Delete Item') {
    // an existing news item is attempting to be deleted
    echo '<h2>DELETE EXISTING NEWS ITEM</h2>';
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    echo '<p class="text-danger mb-5">Click "Confirm Delete" if you are sure you want to <b>DELETE</b> the selected News Item:</p>';
    echo '<input type="hidden" name="news_id" value="' . $_POST['news_id'] . '" />';
    echo '<input type="hidden" name="newsheader" value="' . $_POST['newsheader'] . '" />';
    echo '<input type="submit" name="submit" value="Confirm Delete" />';
    echo '</form>';
}
if (isset($_POST['submit']) && $_POST['submit'] == 'Confirm Delete') {
    // deletion for the selected news item has been confirmed
    if ((isset($_POST['news_id'])) && ($_POST['news_id'] != '')) {
        $delete_news = $_POST['news_id'];
        $conn1->query("DELETE FROM rmlnews WHERE news_id=$delete_news LIMIT 1");
        echo '<p class="bigger text-primary"><b>The selected News Item has been successfully deleted.</b></span></p>';
    } else {
        // $_POST['news_id'] was not present so delete failed
        echo '<p class="bigger text-danger"><b>DELETE FAILED!</b></p>';
        echo '<p class="bigger text-danger"><a href="javascript:history.go(-1);">back</a></p>';
    }
}
if (!isset($_POST['submit'])) {
    // since submit button has not been clicked, display the first form
    echo '<h2>EDIT (or delete) AN EXISTING NEWS ITEM</h2>';
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    echo '<p class="mb-4">To <b>EDIT</b> (or delete) an existing News Item, select the News Item to edit and click "Select Item". </p>';
    echo '<select class="d-block mb-5" name="news_id">';
    echo '<option value="" selected="selected">Select a News Item</option>';
    $query_newsitems = $conn1->query("SELECT * FROM rmlnews ORDER BY newsdate DESC");
    while ($result_newsitems = $query_newsitems->fetch_assoc()) {
        echo '<option value="' . $result_newsitems['news_id'] . '">' . $result_newsitems['newsheader'] . ' - ' . $result_newsitems['newsdate'] . '</option>';
    }
    $query_newsitems->free_result();
    echo '</select>';
    echo '<input type="submit" name="submit" value="Select Item" />';
    echo '</form>';
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
