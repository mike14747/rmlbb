<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('admin_header.php');

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"leftnav\">";
include('leftnav2.php');
echo "</td><td class=\"cell3\">";
if (isset($_POST['edit_event']) && $_POST['edit_event'] == "Submit Changes") {
	// user is trying to edit an existing event, so validate inputs, testing eventdesc for blankness and eventdate for proper format
	$error_string = "";
	if ($_POST['eventdesc'] == "") {
		// the description field has been left blank
		$error_string .= "The description field has been left blank. ";
	}
	if (!preg_match("/^20[0-9]{2}-[0-1][0-9]-[0-3][0-9]$/", $_POST['eventdate'])) {
		// the date is not formatted correctly
		$error_string .= "The date field is not in the correct format (YYYY-MM-DD). ";
	}
	if ($error_string == "") {
		// input fields passed validation, so prep them for the database
		$eventdate = $_POST['eventdate'];
		$new_event_date = $conn1->real_escape_string($eventdate);
		$eventdesc = $_POST['eventdesc'];
		$new_event_desc = $conn1->real_escape_string($eventdesc);
		$conn1->query("UPDATE events SET eventdesc='$new_event_desc', eventdate='$new_event_date' WHERE event_id={$_POST['event_id']}");
		// display confirmation message that the info has been updated in the database
		echo "<p class=\"t16\"><b><span class=\"blue\">An upcoming event has been successfully edited as:</b></span></p>";
		echo "<p class=\"t16\"><b>Event Date:</b> " . $new_event_date . "</p>";
		echo "<p class=\"t16\"><b>Event Description:</b> " . $new_event_desc . "</p>";
	} elseif ($error_string != "") {
		// since there were errors, display them
		echo "<p class=\"t16r\"><b>FAILED!</b></p>";
		echo "<p class=\"t16r\">Correct these items and resubmit the form:</p>";
		echo "<p class=\"t16r\"><b>--</b> " . $error_string . " <b>--</b></p>";
		echo "<br /><p class=\"t16\"><a href=\"javascript:history.go(-1);\">back</a></p>";
	}
} elseif (isset($_POST['delete_event']) && $_POST['delete_event'] == "Delete") {
	// user just clicked to delete and event from the main screen
	echo "<h2>CONFIRM DELETING THIS EVENT</h2>";
	echo "<form action=\"edit_delete_event.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"event_id\" value=\"" . $_POST['event_id'] . "\" />";
		echo "<p class=\"t16\"><b>Event Date:</b> " . $_POST['eventdate'] . "</p>";
		echo "<p class=\"t16\"><b>Event Description:</b> " . $_POST['eventdesc'] . "</p><br />";
		echo "<input class=\"events\" type=\"submit\" name=\"delete_event\" value=\"Confirm Delete\" />";
	echo "</form>";
} elseif ((isset($_POST['delete_event']) && $_POST['delete_event'] == "Confirm Delete")) {
	// user has confirmed to delete an event
	$conn1->query("DELETE FROM events WHERE event_id={$_POST['event_id']} LIMIT 1");
	echo "<p class=\"t16\"><span class=\"blue\">The event was successfully deleted!</span></p>";
} else {
	// no submit button has been clicked, so show the main page
	echo "<h2>EDIT (or delete) AN EXISTING UPCOMING EVENT</h2>";
	if (isset($_GET['view']) && $_GET['view'] == "include_past") {
		echo "<p><img src=\"../images/arrow.gif\" alt=\"Show All Events\" width=\"11\" height=\"11\" /><span class=\"t14\"><a href=\"edit_delete_event.php?view=hide_past\">hide past events</a></span></p>";
		// since include past events was clicked, select all events
		$query_events = $conn1->query("SELECT * FROM events ORDER BY eventdate DESC");
	} else {
		echo "<p><img src=\"../images/arrow.gif\" alt=\"Hide Past Events\" width=\"11\" height=\"11\" /><span class=\"t14\"><a href=\"edit_delete_event.php?view=include_past\">include past events</a></span></p>";
		// Select events whose date is >= to the current date
		$query_events = $conn1->query("SELECT * FROM events WHERE eventdate >= CURDATE() ORDER BY eventdate DESC");
	}
	echo "<ol>";
		echo "<li><span class=\"t14\">The number of characters that must be entered in the 'EVENT DATE' field is exactly 10 (using the YYYY-MM-DD format).</span></li>";
		echo "<li><span class=\"t14\">The maximum number of characters that can be entered in the 'EVENT DESCRIPTION' field is 200.</span></li>";
		echo "<li><span class=\"t14\">If you click 'DELETE', you will be prompted... asking you to confirm that you want to delete that event.</span></li>";
	echo "</ol>";
	if ($query_events->num_rows > 0) {
		echo "<table class=\"events\"><tr>";
		echo "<th>EVENT DATE</th>";
		echo "<th>EVENT DESCRIPTION</th>";
		echo "<th>TASK</th>";
		echo "</tr>";
		$counter=1;
		while ($result_events = $query_events->fetch_assoc()) {
			echo "<form action=\"edit_delete_event.php\" method=\"post\">";
				echo "<tr>";
				// set the hidden field for event_id
				echo "<input type=\"hidden\" name=\"event_id\" value=\"" . $result_events['event_id'] . "\" />";
				echo "<td class=\"events1\"><input class=\"events\" type=\"text\" name=\"eventdate\" id=\"datepicker";
				echo $counter;
				echo "\" size=\"15\" maxlength=\"10\" value=\"" . $result_events['eventdate'] . "\" /></td>";
				echo "<td class=\"events2\"><input class=\"events\" type=\"text\" name=\"eventdesc\" size=\"80\" maxlength=\"200\" value=\"" . $result_events['eventdesc'] . "\" /></td>";
				echo "<td class=\"events3\"><input class=\"events\" type=\"submit\" name=\"edit_event\" value=\"Submit Changes\" /> &nbsp; <input class=\"events3\" type=\"submit\" name=\"delete_event\" value=\"Delete\" /></td></tr>";
			echo "</form>";
			$counter++;
		}
		$query_events->free_result();
		echo "</table>";
	} else {
		echo "<p class=\"t16\"><span class=\"red\">The database doesn't currently contain any upcoming events.</span></p>";
	}
}

include('admin_footer.php');
?>