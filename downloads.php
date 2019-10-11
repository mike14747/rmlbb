<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>DOWNLOADS</h2>';
$query_downloads = $conn->query("SELECT * FROM downloads WHERE display=1 ORDER BY download_order ASC, download_id DESC");
if ($query_downloads->num_rows > 0) {
    echo '<table class="table table-bordered table-hover mt-4">';
    echo '<thead>';
    echo '<tr class="bg-ltgray"><th>FILE DESCRIPTION</th>';
    echo '<th>FILE TO BE DOWNLOADED</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($results_downloads = $query_downloads->fetch_assoc()) {
        echo '<tr><td>' . $results_downloads['description'] . '</td>';
        $clean_filename = rawurlencode($results_downloads['file_name']);
        echo '<td><img src="images/arrow.gif" alt="Download" width="11" height="11" /> <a href="downloads/' . $clean_filename . '">' . $results_downloads['file_name'] . '</a></td></tr></tbody>';
    }
    $query_downloads->free_result();
    echo '</table>';
} elseif ($query_downloads->num_rows == 0) {
    echo '<div class="text-center bigger p-4">There are currently no downloads available.</div>';
}

include('components/footer/footer.php');
