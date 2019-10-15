<?php
$query_lzps = $conn->query("SELECT * FROM lzps ORDER BY year DESC");
if ($query_lzps->num_rows > 0) {
    echo '<li><a href="javascript:void(0)">LZP Archive +</a>';
    echo '<ul>';
    while ($result_lzps = $query_lzps->fetch_assoc()) {
        echo '<li><a href="lzps/' . rawurlencode($result_lzps['file_name']) . '">' . $result_lzps['navbar_name'] . '</a></li>';
    }
    echo '</ul>';
    echo '</li>';
}
