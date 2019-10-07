<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

$query_page = $conn->query("SELECT * FROM cur_season_nav WHERE nav_id=3");
while ($result_page = $query_page->fetch_assoc()) {
    echo '<h2>' . $result_page['page_header'] . '</h2>';
}
$query_page->free_result();
if (isset($_GET['sort'])) {
    if ($get_sort == 'pitcher_name') {
        $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY pitcher_name ASC, rml_team ASC");
    } elseif ($get_sort == 'rml_team') {
        $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY rml_team ASC, pitcher_name ASC");
    } elseif ($get_sort == 'ops') {
        $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY ops ASC, pitcher_name ASC");
    } elseif ($get_sort == 'unl') {
        $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY unl DESC, ops DESC");
    } elseif ($get_sort == 'rml_st') {
        $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY rml_st DESC, pitcher_name ASC");
    } elseif ($get_sort == 'rml_ip') {
        $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY rml_ip DESC, pitcher_name ASC");
    }
} else {
    $query_pitcher_usage = $conn->query("SELECT * FROM pitcher_usage ORDER BY rml_team ASC, pitcher_name ASC");
}
echo '<div class="centered">';
echo '<br /><span class="t12">(Clicking on certain column headers will sort the data by that column.)</span><br />';
echo '</div>';
echo '<table class="roster"><tr>';
echo '<td class="schedl">';
if (isset($get_sort) && $get_sort == 'pitcher_name') {
    echo 'PITCHER NAME*';
} else {
    echo '<a href="pitcher_usage.php?sort=pitcher_name">PITCHER NAME</a>';
}
echo '</td>';
echo '<td class="schedl">';
if ((isset($get_sort) && $get_sort == 'rml_team') || !isset($_GET['sort'])) {
    echo 'RML TEAM*';
} else {
    echo '<a href="pitcher_usage.php?sort=rml_team">RML TEAM</a>';
}
echo '</td>';
echo '<td class="schedc">REAL APP</td>';
echo '<td class="schedc">REAL ST</td>';
echo '<td class="schedc">REAL IP</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == 'ops') {
    echo ' &nbsp;&nbsp;OPS* &nbsp;&nbsp;';
} else {
    echo ' &nbsp;&nbsp;<a href="pitcher_usage.php?sort=ops">OPS</a> &nbsp;&nbsp;';
}
echo '</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == 'unl') {
    echo 'UNL*';
} else {
    echo '<a href="pitcher_usage.php?sort=unl">UNL</a>';
}
echo '</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == 'rml_st') {
    echo 'RML ST*';
} else {
    echo '<a href="pitcher_usage.php?sort=rml_st">RML ST</a>';
}
echo '</td>';
echo '<td class="schedc">RML REL APP</td>';
echo '<td class="schedc">';
if (isset($get_sort) && $get_sort == 'rml_ip') {
    echo 'RML IP*';
} else {
    echo '<a href="pitcher_usage.php?sort=rml_ip">RML IP</a>';
}
echo '</td>';
echo '</tr>';
while ($result_pitcher_usage = $query_pitcher_usage->fetch_assoc()) {
    echo '<tr>';
    echo '<td class="schedulel">' . $result_pitcher_usage['pitcher_name'] . '</td>';
    echo '<td class="schedulel">' . $result_pitcher_usage['rml_team'] . '</td>';
    echo '<td class="schedulec">' . $result_pitcher_usage['real_app'] . '</td>';
    echo '<td class="schedulec">' . $result_pitcher_usage['real_st'] . '</td>';
    echo '<td class="schedulec">' . str_replace(".0", "", $result_pitcher_usage['real_ip']) . '</td>';
    echo '<td class="schedulec">' . ltrim($result_pitcher_usage['ops'], '0') . '</td>';
    echo '<td class="schedulec">' . $result_pitcher_usage['unl'] . '</td>';
    echo '<td class="schedulec">' . $result_pitcher_usage['rml_st'] . '</td>';
    echo '<td class="schedulec">';
    if ($result_pitcher_usage['rml_ip'] > 0) {
        echo 'n/a';
    } else {
        echo $result_pitcher_usage['rml_rel_app'];
    }
    echo '</td>';
    echo '<td class="schedulec">';
    if ($result_pitcher_usage['rml_ip'] == 0) {
        echo 'n/a';
    } else {
        echo $result_pitcher_usage['rml_ip'];
    }
    echo '</td>';
    echo '</tr>';
}
$query_pitcher_usage->free_result();
echo '</table>';

include('components/footer/footer.php');
