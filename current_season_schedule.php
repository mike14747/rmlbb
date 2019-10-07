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
if (isset($get_ind_team)) {
    $query_schedule = $conn->query("SELECT DATE_FORMAT(sd.days_date, '%M %d, %Y') AS days_date1, CONCAT(s.away_team, ' at ', s.home_team) AS matchup FROM season_days AS sd LEFT JOIN (SELECT game_date, away_team, home_team FROM schedule WHERE away_team='$get_ind_team' || home_team='$get_ind_team') AS s ON (sd.days_date=s.game_date) ORDER BY sd.days_date ASC");
    echo '<br /><br /><p class="centered">Showing full season schedule for: <b>' . $get_ind_team . '</b>.</p>';
    echo '<table class="schedule">';
    echo '<tr><td class="schedl">DATE</td><td class="schedl">MATCHUP</td></tr>';
    while ($result_schedule = $query_schedule->fetch_assoc()) {
        echo '<tr><td class="schedulel">' . $result_schedule['days_date1'] . '</td><td class="schedulel">';
        if (is_null($result_schedule['matchup'])) {
            echo '--- Day Off ---';
        } else {
            echo $result_schedule['matchup'];
        }
        echo '</td></tr>';
    }
    echo '</table>';
} else {
    $query_schedule = $conn->query("SELECT schedule_id, game_date, DATE_FORMAT(game_date, '%M %d, %Y') AS game_date1, away_team, home_team FROM schedule ORDER BY schedule_id ASC");
    echo '<br /><p class="centered">Full season day by day schedule for <b>All Teams</b>.<br />(Click on any team to see only that team\'s schedule)</p>';
    echo '<table class="schedule">';
    $cur_date = 0;
    while ($result_schedule = $query_schedule->fetch_assoc()) {
        if ($cur_date == 0) {
            echo '<tr><td class="schedl">DATE</td><td class="schedl">AWAY TEAM</td><td class="schedl">HOME TEAM</td></tr>';
            $cur_date = $result_schedule['game_date'];
        } elseif ($cur_date != $result_schedule['game_date']) {
            echo '<tr><td class="schedl"><b>DATE</b></td><td class="schedl"><b>AWAY TEAM</b></td><td class="schedl"><b>HOME TEAM</b></td></tr>';
            $cur_date = $result_schedule['game_date'];
        }
        echo '<tr><td class="schedulel">' . $result_schedule['game_date1'] . '</td><td class="schedulel"><a href="current_season_schedule.php?ind_team=' . $result_schedule['away_team'] . '">' . $result_schedule['away_team'] . '</a></td><td class="schedulel"><a href="current_season_schedule.php?ind_team=' . $result_schedule['home_team'] . '">' . $result_schedule['home_team'] . '</a></td></tr>';
    }
    echo "</table>";
}
$query_schedule->free_result();

include('components/footer/footer.php');
