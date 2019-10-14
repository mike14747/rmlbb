<?php
if ($result_settings['display_events'] == 1) {
    // start upcoming events box since it is enabled
    // get current date
    $query_date = $conn->query("SELECT DATE_FORMAT(CURRENT_DATE(), '%b-%d, %Y') AS t_date");
    $result_date = $query_date->fetch_assoc();
    $query_date->free_result();
    // select events whose date is >= to the current date and is also <= the event interval in the settings table
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%b-%d, %Y') AS eventdate1 FROM events WHERE (eventdate >= CURDATE()) AND (eventdate <= DATE_ADD(CURDATE(), INTERVAL {$result_settings['event_interval']} DAY)) ORDER BY eventdate ASC");
    echo '<div class="w-200px h-auto border border-secondary bg-light float-right text-left ml-2 mb-3 p-2 lh-115">';
    echo '<h5>UPCOMING EVENTS</h5>';
    echo '<p class="small text-secondary my-2">CURRENT DATE: ' . $result_date['t_date'] . '</p>';
    echo '<p class="small text-secondary my-2">Events during the next ' . $result_settings['event_interval'] . ' days:</p>';
    echo '<table>';
    echo '<thead>';
    echo '<tr class="bg-ltgray">';
    echo '<th><p class="small my-1 pl-1"><b>DATE</b></p></th>';
    echo '<th><p class="small my-1"><b>EVENT</b></p></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    if ($query_events->num_rows < 1) {
        echo '<tr>';
        echo '<td colspan="2"><p class="small my-2">List is being updated... please try back soon.</p></td>';
        echo '</tr>';
    } else {
        while ($result_events = $query_events->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="py-2 pr-2 border-bottom"><p class="small m-0">' . $result_events['eventdate1'] . '</p></td>';
            echo '<td class="py-2 border-bottom"><p class="small m-0">' . $result_events['eventdesc'] . '</p></td>';
            echo '</tr>';
        }
        $query_events->free_result();
    }
    echo '</tbody>';
    echo '</table>';
    echo '<div class="small mt-3 d-flex align-items-center justify-content-end">';
    echo '<img src="components/eventsBox/images/arrow.gif" alt="Upcoming Events" width="11" height="11" /><img src="components/eventsBox/images/arrow.gif" alt="Upcoming Events" width="11" height="11" /><a href="events.php">View All Upcoming Events</a>';
    echo '</div>';
    echo '</div>';
}
