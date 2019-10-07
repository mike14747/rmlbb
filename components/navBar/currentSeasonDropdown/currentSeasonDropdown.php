<?php
$query_current = $conn->query("SELECT * FROM cur_season_nav WHERE display=1");
if ($query_current->num_rows > 0) {
    echo '<li><a href="javascript:void(0)">Current Season +</a>';
    echo '<ul>';
    // echo '<li><a href="web_builder/index.html" target="_blank">Stats, Standings, Leaders</a></li>';
    while ($result_current = $query_current->fetch_assoc()) {
        echo '<li><a href="' . $result_current['urlref'] . '">' . $result_current['nav_text'] . '</a></li>';
    }
    $query_current->free_result();
    echo '</ul>';
    echo '</li>';
}
