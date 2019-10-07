<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>UPCOMING EVENTS</h2>';
if (isset($get_view) && $get_view == 'include_past') {
    echo '<div class="centered"><img src="images/arrow.gif" alt="Show All Events" width="11" height="11" /><span class="t14"><a href="events.php?view=hide_past">hide past events</a></span></div><br /><br />';
    // since include past events was clicked, select all events
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%M %d, %Y') AS eventdate1 FROM events ORDER BY eventdate ASC");
} else {
    echo '<div class="centered"><img src="images/arrow.gif" alt="Include Past Events" width="11" height="11" /><span class="t14"><a href="events.php?view=include_past">include past events</a></span></div><br /><br />';
    // Select events whose date is >= to the current date
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%M %d, %Y') AS eventdate1 FROM events WHERE eventdate >= CURDATE() ORDER BY eventdate ASC");
}
// start row background alternation variables
$alternate = 1;
$bgcolor1 = 'background-color: #f3f3f3';
$bgcolor2 = 'background-color: #e3e3e3';
echo '<table border="0" cellspacing="2" cellpadding="5">';
echo '<tr style="background-color: #e3e3e3;"><td width="200px"><span class="t16"><b>DATE</b></span></td>';
echo '<td width="750px"><span class="t16"><b>EVENT</b></span></td>';
echo '</tr>';
if ($query_events->num_rows < 1) {
    echo '<tr style="background-color: #ffffff"><td colspan="2"><span class="t16">List is being updated... please try back soon.</span></td></tr>';
} else {
    while ($result_events = $query_events->fetch_assoc()) {
        if ($alternate == 1) {
            $bgclass = $bgcolor1;
            $alternate = 2;
        } else {
            $bgclass = $bgcolor2;
            $alternate = 1;
        }
        echo '<tr style="$bgclass"><td><span class="t14">' . $result_events['eventdate1'] . '</span></td>';
        echo '<td><span class="t14">' . $result_events['eventdesc'] . '</span></td></tr>';
    }
}
echo '</table><br /><br />';

include('components/footer/footer.php');
