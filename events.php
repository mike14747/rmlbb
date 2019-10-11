<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>UPCOMING EVENTS</h2>';
if (isset($get_view) && $get_view == 'include_past') {
    echo '<div class="my-4 d-flex align-items-center justify-content-center"><img src="images/arrow.gif" alt="Show All Events" width="11" height="11" /><span class="t14"><a href="events.php?view=hide_past">hide past events</a></span></div>';
    // since include past events was clicked, select all events
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%M %d, %Y') AS eventdate1 FROM events ORDER BY eventdate ASC");
} else {
    echo '<div class="my-4 d-flex align-items-center justify-content-center"><img src="images/arrow.gif" alt="Include Past Events" width="11" height="11" /><span class="t14"><a href="events.php?view=include_past">include past events</a></span></div>';
    // Select events whose date is >= to the current date
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%M %d, %Y') AS eventdate1 FROM events WHERE eventdate >= CURDATE() ORDER BY eventdate ASC");
}
echo '<table class="table table-bordered table-hover">';
echo '<thead>';
echo '<tr class="bg-ltgray"><td><span class="bigger"><b>DATE</b></span></td>';
echo '<td><span class="bigger"><b>EVENT</b></span></td>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
if ($query_events->num_rows < 1) {
    echo '<tr><td colspan="2"><span class="bigger">List is being updated... please try back soon.</span></td></tr>';
} else {
    while ($result_events = $query_events->fetch_assoc()) {
        if ($alternate == 1) {
            $bgclass = $bgcolor1;
            $alternate = 2;
        } else {
            $bgclass = $bgcolor2;
            $alternate = 1;
        }
        echo '<tr><td>' . $result_events['eventdate1'] . '</td>';
        echo '<td>' . $result_events['eventdesc'] . '</td></tr><tbody>';
    }
}
echo '</table>';

include('components/footer/footer.php');
