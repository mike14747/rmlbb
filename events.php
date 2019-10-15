<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>UPCOMING EVENTS</h2>';
if (isset($get_view) && $get_view == 'include_past') {
    echo '<div class="my-4 d-flex align-items-center justify-content-center">';
    echo '<img src="images/arrow.gif" alt="Show All Events" width="11" height="11" /><a href="events.php?view=hide_past">hide past events</a>';
    echo '</div>';
    // since include past events was clicked, select all events
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%M %d, %Y') AS eventdate1 FROM events ORDER BY eventdate ASC");
} else {
    echo '<div class="my-4 d-flex align-items-center justify-content-center">';
    echo '<img src="images/arrow.gif" alt="Include Past Events" width="11" height="11" /><a href="events.php?view=include_past">include past events</a>';
    echo '</div>';
    // Select events whose date is >= to the current date
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%M %d, %Y') AS eventdate1 FROM events WHERE eventdate >= CURDATE() ORDER BY eventdate ASC");
}
echo '<div class="d-flex justify-content-center">';
echo '<div class="min-w-50 mx-auto">';
echo '<table class="table table-hover">';
echo '<thead>';
echo '<tr class="bg-ltgray">';
echo '<th class="border border-secondary">DATE</th>';
echo '<th class="border border-secondary">EVENT</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
if ($query_events->num_rows < 1) {
    echo '<tr>';
    echo '<td colspan="2"><span class="bigger">List is being updated... please try back soon.</span></td>';
    echo '</tr>';
} else {
    while ($result_events = $query_events->fetch_assoc()) {
        echo '<tr>';
        echo '<td class="border border-secondary">' . $result_events['eventdate1'] . '</td>';
        echo '<td class="border border-secondary">' . $result_events['eventdesc'] . '</td>';
        echo '</tr>';
    }
}
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

include('components/footer/footer.php');
