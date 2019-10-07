<?php
$query_downloads = $conn->query("SELECT * FROM downloads WHERE display=1 ORDER BY download_order ASC, download_id DESC LIMIT 10");
if ($query_downloads->num_rows > 0) {
    echo '<li><a href="javascript:void(0)">Downloads +</a>';
    echo '<ul>';
    while ($result_downloads = $query_downloads->fetch_assoc()) {
        echo '<li><a href="downloads/' . rawurlencode($result_downloads['file_name']) . '">' . $result_downloads['description'] . '</a></li>';
    }
    $query_downloads->free_result();
    echo '<li><a href="downloads.php "><b>View All Downloads</b></a></li>';
    echo '</ul>';
    echo '</li>';
}
