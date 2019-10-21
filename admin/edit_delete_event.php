<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 py-3">';

if (isset($_POST['edit_event']) && $_POST['edit_event'] == 'Submit Changes') {
    // user is trying to edit an existing event, so validate inputs, testing eventdesc for blankness and eventdate for proper format
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
        $conn1->query("UPDATE events SET eventdesc='$new_event_desc', eventdate='$new_event_date' WHERE event_id={$_POST['event_id']}");
        // display confirmation message that the info has been updated in the database
        echo '<p class="bigger primary"><b>An upcoming event has been successfully edited as:</b></p>';
        echo '<p class="bigger"><b>Event Date:</b> ' . $new_event_date . '</p>';
        echo '<p class="bigger"><b>Event Description:</b> ' . $new_event_desc . '</p>';
    } elseif ($error_string != '') {
        // since there were errors, display them
        echo '<p class="bigger danger"><b>FAILED!</b></p>';
        echo '<p class="bigger danger">Correct these items and resubmit the form:</p>';
        echo '<p class="bigger danger"><b>--</b> ' . $error_string . ' <b>--</b></p>';
        echo '<p class="bigger mt-2"><a href="javascript:history.go(-1);">back</a></p>';
    }
} elseif (isset($_POST['delete_event']) && $_POST['delete_event'] == 'Delete') {
    // user just clicked to delete and event from the main screen
    echo '<h2>CONFIRM DELETING THIS EVENT</h2>';
    echo '<form action="edit_delete_event.php" method="post">';
    echo '<input type="hidden" name="event_id" value="' . $_POST['event_id'] . '" />';
    echo '<p class="bigger"><b>Event Date:</b> ' . $_POST['eventdate'] . '</p>';
    echo '<p class="bigger mb-5"><b>Event Description:</b> ' . $_POST['eventdesc'] . '</p>';
    echo '<input class="events" type="submit" name="delete_event" value="Confirm Delete" />';
    echo '</form>';
} elseif ((isset($_POST['delete_event']) && $_POST['delete_event'] == 'Confirm Delete')) {
    // user has confirmed to delete an event
    $conn1->query("DELETE FROM events WHERE event_id={$_POST['event_id']} LIMIT 1");
    echo '<p class="bigger primary">The event was successfully deleted!</p>';
} else {
    // no submit button has been clicked, so show the main page
    echo '<h2>EDIT (or delete) AN EXISTING UPCOMING EVENT</h2>';
    if (isset($_GET['view']) && $_GET['view'] == 'include_past') {
        echo '<div class="my-4 d-flex align-items-center justify-content-start">';
        echo '<img src="../images/arrow.gif" alt="Hide Past Events" width="11" height="11" />';
        echo '<a href="edit_delete_event.php?view=hide_past">hide past events</a>';
        echo '</div>';
        // since include past events was clicked, select all events
        $query_events = $conn1->query("SELECT * FROM events ORDER BY eventdate DESC");
    } else {
        echo '<div class="my-4 d-flex align-items-center justify-content-start">';
        echo '<img src="../images/arrow.gif" alt="Include Past Events" width="11" height="11" />';
        echo '<a href="edit_delete_event.php?view=include_past">include past events</a>';
        echo '</div>';
        // Select events whose date is >= to the current date
        $query_events = $conn1->query("SELECT * FROM events WHERE eventdate >= CURDATE() ORDER BY eventdate DESC");
    }
    echo '<ol>';
    echo '<li>The number of characters that must be entered in the "EVENT DATE" field is exactly 10 (using the YYYY-MM-DD format).</li>';
    echo '<li>The maximum number of characters that can be entered in the "EVENT DESCRIPTION" field is 200.</li>';
    echo '<li>If you click "DELETE", you will be prompted... asking you to confirm that you want to delete that event.</li>';
    echo '</ol>';
    if ($query_events->num_rows > 0) {
        echo '<table class="events mr-auto">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>EVENT DATE</th>';
        echo '<th>EVENT DESCRIPTION</th>';
        echo '<th>TASK</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $counter = 1;
        while ($result_events = $query_events->fetch_assoc()) {
            echo '<form action="edit_delete_event.php" method="post">';
            echo '<tr>';
            // set the hidden field for event_id
            echo '<input type="hidden" name="event_id" value="' . $result_events['event_id'] . '" />';
            echo '<td class="border-top border-bottom border-left border-secondary p-4">';
            echo '<input class="p-2" type="text" name="eventdate" id="datepicker';
            echo $counter;
            echo '" size="15" maxlength="10" value="' . $result_events['eventdate'] . '" />';
            echo '</td>';
            echo '<td class="border-bottom border-secondary p-4">';
            echo '<input class="p-2" type="text" name="eventdesc" size="80" maxlength="200" value="' . $result_events['eventdesc'] . '" />';
            echo '</td>';
            echo '<td class="border-top border-right border-bottom border-secondary p-4">';
            echo '<input class="mr-4 p-2" type="submit" name="edit_event" value="Submit Changes" /><input class="p-2" type="submit" name="delete_event" value="Delete" />';
            echo '</td>';
            echo '</tr>';
            echo '</form>';
            $counter++;
        }
        $query_events->free_result();
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="bigger danger">The database doesn\'t currently contain any upcoming events.</p>';
    }
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
