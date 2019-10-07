<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>DOWNLOADS</h2><br />';
$query_downloads = $conn->query("SELECT * FROM downloads WHERE display=1 ORDER BY download_order ASC, download_id DESC");
if ($query_downloads->num_rows > 0) {
    echo '<table class="downloads">';
    echo '<tr><th>FILE DESCRIPTION</th>';
    echo '<th>FILE TO BE DOWNLOADED</th>';
    echo '</tr>';
    while ($results_downloads = $query_downloads->fetch_assoc()) {
        echo '<tr><td><span class="t14">' . $results_downloads['description'] . '</span></td>';
        $clean_filename = rawurlencode($results_downloads['file_name']);
        echo '<td><span class="t14"><img src="images/arrow.gif" alt="Download" width="11" height="11" /> <a href="downloads/' . $clean_filename . '">' . $results_downloads['file_name'] . '</a></span></td></tr>';
    }
    $query_downloads->free_result();
    echo '</table>';
} elseif (mysql_num_rows($query_downloads) == 0) {
    echo '<p class="t16indent">There are currently no downloads available.</p>';
}

include('components/footer/footer.php');
