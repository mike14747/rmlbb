<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>YEARLY RML CHAMPIONS</h2>';
$query_champions = $conn->query("SELECT season_year, winning_team, winning_manager, losing_team, losing_manager FROM champions ORDER BY season_year ASC");
echo '<table class="table table-bordered table-hover mt-4">';
echo '<thead>';
echo '<tr class="bg-ltgray">';
echo '<th>Season</th><th>Winning Team (Manager)</th><th>Losing Team (Manager)</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
while ($result_champions = $query_champions->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $result_champions['season_year'] .  '</td><td>';
    if ($result_champions['winning_team'] == '') {
        echo '?';
    } else {
        echo $result_champions['winning_team'];
    }
    echo ' (';
    if ($result_champions['winning_manager'] == '') {
        echo '?';
    } else {
        echo $result_champions['winning_manager'];
    }
    echo ')</td><td>';
    if ($result_champions['losing_team'] == '') {
        echo '?';
    } else {
        echo $result_champions['losing_team'];
    }
    echo ' (';
    if ($result_champions['losing_manager'] == '') {
        echo '?';
    } else {
        echo $result_champions['losing_manager'];
    }
    echo ')</td></tr>';
}
$query_champions->free_result();
echo '</tbody>';
echo '</table>';

include('components/footer/footer.php');
