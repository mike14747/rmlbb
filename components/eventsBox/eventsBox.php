<?php
if ($result_settings['display_events'] == 1) {
    // start upcoming events box since it is enabled
    // get current date
    $query_date = $conn->query("SELECT DATE_FORMAT(CURRENT_DATE(), '%b-%d, %Y') AS t_date");
    $result_date = $query_date->fetch_assoc();
    $query_date->free_result();
    // select events whose date is >= to the current date and is also <= the event interval in the settings table
    $query_events = $conn->query("SELECT eventdesc, DATE_FORMAT(eventdate, '%b-%d, %Y') AS eventdate1 FROM events WHERE (eventdate >= CURDATE()) AND (eventdate <= DATE_ADD(CURDATE(), INTERVAL {$result_settings['event_interval']} DAY)) ORDER BY eventdate ASC");
    // start row background alternation variables
    $alternate = 1;
    $bgcolor1 = 'background-color: #f3f3f3';
    $bgcolor2 = 'background-color: #e3e3e3';
    echo '<div class="w-200px h-auto border border-secondary bg-light float-right text-left ml-2 mb-3 p-2">';
    echo '<h5>UPCOMING EVENTS</h5>';
    echo '<span class="small text-secondary">CURRENT DATE: ' . $result_date['t_date'] . '</span><br />';
    echo '<span class="small text-secondary">Events during the next ' . $result_settings['event_interval'] . ' days:</span><br />';
    echo '<table style="margin: 5px 0px 0px 0px;">';
    echo '<tr style="background-color: #e3e3e3;"><td style="width: 70px; padding: 5px 3px 5px 2px;"><span class="small"><b>DATE</b></span></td>';
    echo '<td style="padding: 5px 3px 5px 2px;"><span class="small"><b>EVENT</b></span></td>';
    echo '</tr>';
    if ($query_events->num_rows < 1) {
        echo '<tr style="background-color: #ffffff;"><td colspan="2"><span class="small">List is being updated... please try back soon.</span></td></tr>';
    } else {
        while ($result_events = $query_events->fetch_assoc()) {
            if ($alternate == 1) {
                $bgclass = $bgcolor1;
                $alternate = 2;
            } else {
                $bgclass = $bgcolor2;
                $alternate = 1;
            }
            echo '<tr style="{' . $bgclass . ';}"><td style="padding: 5px 5px 5px 2px;"><span class="small">' . $result_events['eventdate1'] . '</span></td>';
            echo '<td style="padding: 5px 5px 5px 2px;"><span class="small">' . $result_events['eventdesc'] . '</span></td></tr>';
        }
        $query_events->free_result();
    }
    echo '</table>';
    echo '<div class="small mt-3 d-flex align-items-center justify-content-end"><img src="components/eventsBox/images/arrow.gif" alt="Upcoming Events" width="11" height="11" /><img src="components/eventsBox/images/arrow.gif" alt="Upcoming Events" width="11" height="11" /><a href="events.php">View All Upcoming Events</a></div>';
    echo '</div>';
}
