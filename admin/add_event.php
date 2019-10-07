<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

// check to see if a submit button has been clicked
if (isset($_POST['submit']) && ($_POST['submit'] == 'Submit Event')) {
    // user is trying to add an event, so validate inputs, testing eventdesc for blankness and eventdate for proper format
    $error_string = '';
    if ($_POST['eventdesc'] == '') {
        // the description field has been left blank
        $error_string .= 'The description field has been left blank. ';
    }
    if (!preg_match('/^20[0-9]{2}-[0-1][0-9]-[0-3][0-9]$/', $_POST['eventdate'])) {
        // the date is not formatted correctly
        $error_string .= 'The date field is not in the correct format (YYYY-MM-DD). ';
    }
    if ($error_string == '') {
        // input fields passed validation, so prep them for the database
        $eventdate = $_POST['eventdate'];
        $new_event_date = $conn1->real_escape_string($eventdate);
        $eventdesc = $_POST['eventdesc'];
        $new_event_desc = $conn1->real_escape_string($eventdesc);
        $conn1->query("INSERT INTO events (eventdesc, eventdate) VALUES ('$new_event_desc', '$new_event_date')");
        $error_string = 'Success';
    }
}

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';
echo '<h2>ADD AN UPCOMING EVENT</h2>';

if ((isset($error_string) && $error_string != 'Success') || !isset($error_string)) {
    if (isset($error_string) && $error_string != 'Success') {
        // the form was submitted but has errors, so display them
        echo '<p class="text-danger"><b>FAILED!</b></p>';
        echo '<p class="text-danger">Correct these items and resubmit the form:</p>';
        echo '<p class="text-danger"><b>--</b> ' . $error_string . ' <b>--</b></p>';
    }
    // the form was either submitted with errors or was not submitted at all so, display the form
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    echo '<p class="updateitem"><b>Enter event date</b> (in this format: YYYY-MM-DD):<br /><br /><input type="text" name="eventdate" id="datepicker" maxlength="10" size="15" value="';
    if (isset($_POST['eventdate'])) {
        echo $_POST['eventdate'];
    }
    echo '" /></p>';
    echo '<p class="updateitem"><b>Enter event description</b> (ie: "Unowned Player Draft" or "Series 3 Due Date"):<br /><br /><input type="text" name="eventdesc" size="50" maxlength="200" value="';
    if (isset($_POST['eventdesc'])) {
        echo $_POST['eventdesc'];
    }
    echo '" /></p>';
    echo '<p class="updateitem">Click "Submit Event" to add a new Upcoming Event with the info provided: <input type="submit" name="submit" value="Submit Event" /></p><br />';
    echo '</form>';
} elseif (isset($error_string) && $error_string == 'Success') {
    // the form was successfully submitted, so show display that success
    echo '<p class="text-primary"><b>An upcoming event has been successfully added as:</b></p>';
    echo '<p><b>Event Date:</b> ' . $new_event_date . '</p>';
    echo '<p><b>Event Description:</b> ' . $new_event_desc . '</p>';
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
