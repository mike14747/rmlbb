<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<h2>DOWNLOADS</h2>';
$query_downloads = $conn->query("SELECT * FROM downloads WHERE display=1 ORDER BY download_order ASC, download_id DESC");
if ($query_downloads->num_rows > 0) {
    echo '<div class="d-flex justify-content-center">';
    echo '<div class="min-w-50 mx-auto">';
    echo '<table class="table table-hover mt-4">';
    echo '<thead>';
    echo '<tr class="bg-ltgray">';
    echo '<th class="border border-secondary">FILE DESCRIPTION</th>';
    echo '<th class="border border-secondary">FILE TO BE DOWNLOADED</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($results_downloads = $query_downloads->fetch_assoc()) {
        echo '<tr>';
        echo '<td class="border border-secondary">' . $results_downloads['description'] . '</td>';
        $clean_filename = rawurlencode($results_downloads['file_name']);
        echo '<td class="border border-secondary">';
        echo '<div class="d-flex align-items-center justify-content-start">';
        echo '<img src="images/arrow.gif" alt="Download" width="11" height="11" /> <a href="downloads/' . $clean_filename . '">' . $results_downloads['file_name'] . '</a>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
    $query_downloads->free_result();
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
} elseif ($query_downloads->num_rows == 0) {
    echo '<div class="text-center bigger p-4">There are currently no downloads available.</div>';
}

include('components/footer/footer.php');
