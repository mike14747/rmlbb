<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

$query_page = $conn->query("SELECT * FROM cur_season_nav WHERE nav_id=1");
while ($result_page = $query_page->fetch_assoc()) {
    echo '<h2>' . $result_page['page_header'] . '</h2>';
}
$query_page->free_result();
$requested_team = request_var('ind_team', 'none');
if ($requested_team != 'none') {
    $query_schedule = $conn->query("SELECT DATE_FORMAT(sd.days_date, '%M %d, %Y') AS days_date1, CONCAT(s.away_team, ' at ', s.home_team) AS matchup FROM season_days AS sd LEFT JOIN (SELECT game_date, away_team, home_team FROM schedule WHERE away_team='$requested_team' || home_team='$requested_team') AS s ON (sd.days_date=s.game_date) ORDER BY sd.days_date ASC");
    echo '<p class="text-center my-4">Showing full season schedule for: <b>' . $requested_team . '</b>.</p>';
    echo '<div class="d-flex justify-content-center">';
    echo '<div class="min-w-50 mx-auto">';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr class="bg-ltgray">';
    echo '<td>DATE</td>';
    echo '<td>MATCHUP</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($result_schedule = $query_schedule->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $result_schedule['days_date1'] . '</td>';
        echo '<td>';
        if (is_null($result_schedule['matchup'])) {
            echo '--- Day Off ---';
        } else {
            echo $result_schedule['matchup'];
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
} else {
    $query_schedule = $conn->query("SELECT schedule_id, game_date, DATE_FORMAT(game_date, '%M %d, %Y') AS game_date1, away_team, home_team FROM schedule ORDER BY schedule_id ASC");
    echo '<p class="text-center my-4">Full season day by day schedule for <b>All Teams</b>.<br />(Click on any team to see only that team\'s schedule)</p>';
    echo '<div class="d-flex justify-content-center">';
    echo '<div class="min-w-50 mx-auto">';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr class="bg-ltgray">';
    echo '<td><b>DATE</b></td>';
    echo '<td><b>AWAY TEAM</b></td>';
    echo '<td><b>HOME TEAM</b></td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($result_schedule = $query_schedule->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $result_schedule['game_date1'] . '</td>';
        echo '<td><a href="current_season_schedule.php?ind_team=' . $result_schedule['away_team'] . '">' . $result_schedule['away_team'] . '</a></td>';
        echo '<td><a href="current_season_schedule.php?ind_team=' . $result_schedule['home_team'] . '">' . $result_schedule['home_team'] . '</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo "</table>";
    echo '</div>';
    echo '</div>';
}
$query_schedule->free_result();

include('components/footer/footer.php');
