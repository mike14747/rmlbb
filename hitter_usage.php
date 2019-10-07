<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

$query_page = $conn->query("SELECT * FROM cur_season_nav WHERE nav_id=4");
while ($result_page = $query_page->fetch_assoc()) {
    echo '<h2>' . $result_page['page_header'] . '</h2>';
}
$query_page->free_result();
if (isset($get_sort)) {
    if ($get_sort == 'hitter_name') {
        $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY hitter_name ASC, rml_team ASC");
    } elseif ($get_sort == 'rml_team') {
        $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY rml_team ASC, hitter_name ASC");
    } elseif ($get_sort == 'mlb_ab') {
        $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY mlb_ab DESC, hitter_name ASC");
    } elseif ($get_sort == 'ops') {
        $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY ops DESC, hitter_name ASC");
    } elseif ($get_sort == 'full') {
        $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY full DESC, mlb_ab DESC");
    } elseif ($get_sort == 'unl') {
        $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY unl DESC, ops ASC");
    }
} else {
    $query_hitter_usage = $conn->query("SELECT * FROM hitter_usage ORDER BY rml_team ASC, hitter_name ASC");
}
echo '<div class="centered">';
echo '<br /><span class="t12">(Clicking on certain column headers will sort the data by that column.)</span><br />';
echo '</div>';
echo '<table class="roster"><tr>';
echo '<td class="schedl">';
if (isset($get_sort) && $get_sort == hitter_name) {
    echo 'HITTER NAME*';
} else {
    echo '<a href="hitter_usage.php?sort=hitter_name">HITTER NAME</a>';
}
echo '</td>';
echo '<td class="schedl">';
if ((isset($get_sort) && $get_sort == 'rml_team') || !isset($get_sort)) {
    echo 'RML TEAM*';
} else {
    echo '<a href="hitter_usage.php?sort=rml_team">RML TEAM</a>';
}
echo '</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == 'mlb_ab') {
    echo 'MLB AB*';
} else {
    echo '<a href="hitter_usage.php?sort=mlb_ab">MLB AB</a>';
}
echo '</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == 'ops') {
    echo ' &nbsp;&nbsp;OPS* &nbsp;&nbsp;';
} else {
    echo ' &nbsp;&nbsp;<a href="hitter_usage.php?sort=ops">OPS</a> &nbsp;&nbsp;';
}
echo '</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == full) {
    echo 'FULL*';
} else {
    echo '<a href="hitter_usage.php?sort=full">FULL</a>';
}
echo '</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == unl) {
    echo 'UNL*';
} else {
    echo '<a href="hitter_usage.php?sort=unl">UNL</a>';
}
echo '</td>';
echo '<td class="schedc">RML AB</td>';
echo '</tr>';
while ($result_hitter_usage = $query_hitter_usage->fetch_assoc()) {
    echo '<tr>';
    echo '<td class="schedulel">' . $result_hitter_usage['hitter_name'] . '</td>';
    echo '<td class="schedulel">' . $result_hitter_usage['rml_team'] . '</td>';
    echo '<td class="schedulec">' . $result_hitter_usage['mlb_ab'] . '</td>';
    echo '<td class="schedulec">' . ltrim($result_hitter_usage['ops'], '0') . '</td>';
    echo '<td class="schedulec">' . $result_hitter_usage['full'] . '</td>';
    echo '<td class="schedulec">' . $result_hitter_usage['unl'] . '</td>';
    echo '<td class="schedulec">';
    if ($result_hitter_usage['rml_ab'] == 0) {
        echo 'n/a';
    } else {
        echo $result_hitter_usage['rml_ab'];
    }
    echo '</td>';
    echo '</tr>';
}
$query_hitter_usage->free_result();
echo '</table>';

include('components/footer/footer.php');
