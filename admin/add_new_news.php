<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';

// Check to see if a submit button has been clicked
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit News') {
    // a new news item has been submitted
    // set error variables for blank testing and format testing
    // set the total errors variable
    $t_errors = 0;
    // set the blank field error variable
    $b_errors = 0;
    // set the date formatting error variable
    $f_errors = 0;
    // If the submit button has been clicked, check to see if any of the fields are blank
    if (($_POST['newsheader'] == '') || ($_POST['newsdate'] == '') || ($_POST['newstext'] == '')) {
        $b_errors++;
        $t_errors++;
    }
    // If the submit button has been clicked, check to see if the date field is formatted correctly
    if (($_POST['newsdate'] != '') && (!preg_match('/^20[0-9]{2}-[0-1][0-9]-[0-3][0-9]$/', $_POST['newsdate']))) {
        $f_errors++;
        $t_errors++;
    }
    if ($t_errors == 0) {
        // If no $_POST items are blank or not formatted properly proceed with form processing
        $newsheader = $_POST['newsheader'];
        $add_newsheader = $conn1->real_escape_string($newsheader);
        $newsdate = $_POST['newsdate'];
        $add_newsdate = $conn1->real_escape_string($newsdate);
        $newstext = $_POST['newstext'];
        $add_newstext = $conn1->real_escape_string($newstext);
        // insert new news item into the database since there is no existing news_id
        $conn1->query("INSERT INTO rmlnews (newsheader, newsdate, newstext) VALUES ('$add_newsheader', '$add_newsdate', '$add_newstext')");
        // display confirmation message that the info has been added to the database
        echo '<p class="t16"><span class="blue"><b>A news item has been added with the following:</b></span></p>';
        echo '<h4>' . $add_newsheader . '</h4>';
        echo '<span class="newsdate">Posted on: ' . $add_newsdate . '</span><br /><br />';
        echo '<span class="t14">' . $_POST['newstext'] . '</span>';
    }
}
if ((isset($t_errors) && $t_errors > 0) || !isset($_POST['submit'])) {
    if (isset($t_errors) && $t_errors > 0) {
        echo '<p class="text-danger"><b>FAILED!</b></p>';
        echo '<p class="text-danger">Correct these items and resubmit the form:</p>';
        if (isset($b_errors) && $b_errors > 0) {
            echo '<p class="text-danger"><b>--</b> One or more or the fields have been left <b>blank</b>. <b>--</b></p>';
        }
        if (isset($f_errors) && $f_errors > 0) {
            echo '<p class="text-danger"><b>--</b> The <b>date field</b> is not in the proper format. <b>--</b></p>';
        }
    }
    // since submit button has not been clicked or there are errors, display the form
    echo '<h2>ADD NEW NEWS ITEM</h2>';
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    echo '<p class="updateitem"><b>Enter newsheader</b> (ie: "Pages Updated" or "Series 6 Results"):<br /><br /><input type="text" name="newsheader" size="50" maxlength="60"';
    if (isset($_POST['newsheader'])) {
        echo ' value="' . $_POST['newsheader'] . '"';
    }
    echo ' /></p>';
    echo '<p class="updateitem"><b>Enter newsdate</b> (in this format: YYYY-MM-DD):<br /><br /><input type="text" name="newsdate" id="datepicker" size="15" maxlength="10"';
    if (isset($_POST['newsdate'])) {
        echo ' value="' . $_POST['newsdate'] . '"';
    }
    echo ' /></p>';
    echo '<p class="updateitem"><b>Enter newstext</b> (for a single line break hold Shift, then press Enter):<br /><br /><textarea name="newstext" rows="10" cols="100">';
    if (isset($_POST['newstext'])) {
        echo $_POST['newstext'];
    }
    echo '</textarea></p>';
    echo '<p class="updateitem">Click "Submit News" to add this news item: <input type="submit" name="submit" value="Submit News" /></p><br />';
    echo '</form>';
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
