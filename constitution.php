<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

$query_constitution = $conn->query("SELECT * FROM sitepages WHERE page_id=1");
while ($result_constitution = $query_constitution->fetch_assoc()) {
    echo '<h2>' . $result_constitution['page_header'] . '</h2>';
    echo $result_constitution['page_contents'];
}
$query_constitution->free_result();

include('components/footer/footer.php');
