<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

$query_page = $conn->query("SELECT * FROM cur_season_nav WHERE nav_id=2");
while ($result_page = $query_page->fetch_assoc()) {
    echo '<h2>' . $result_page['page_header'] . '</h2>';
}
$query_page->free_result();
echo '<div class="text-center">';
if (isset($get_show) && $get_show == 'minors') {
    echo '<span class="t12">showing only minor leaguers</span>';
} else {
    echo '<img src="images/arrow.gif" alt="Show Only Minor Leaguers" width="11" height="11" /><span class="t12"><a href="current_roster.php?show=minors';
    if (isset($get_sort) && $get_sort != 'exp' && $get_sort != 'salary') {
        echo '&sort=' . $get_sort;
    }
    echo '">show only minor leaguers</a></span>';
}
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if (isset($get_show) && $get_show == 'majors') {
    echo '<span class="t12">showing only major leaguers</span>';
} else {
    echo '<img src="images/arrow.gif" alt="Show Only Major Leaguers" width="11" height="11" /><span class="t12"><a href="current_roster.php?show=majors';
    if (isset($get_sort)) {
        echo "&sort=" . $get_sort;
    }
    echo '">show only major leaguers</a></span>';
}
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if (isset($get_show) && $get_show == 'majors' || $get_show == 'minors') {
    echo '<img src="images/arrow.gif" alt="Show All Players" width="11" height="11" /><span class="t12"><a href="current_roster.php';
    if (isset($get_sort)) {
        echo "?sort=" . $get_sort;
    }
    echo '">show all players</a></span>';
} else {
    echo '<span class="t12">showing all players</span>';
}
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if (isset($get_show) || isset($get_sort)) {
    echo '<img src="images/arrow.gif" alt="Reset All Sort/Filter Criteria" width="11" height="11" /><span class="t12"><a href="current_roster.php">reset all sort/filter criteria</a></span>';
} else {
    echo '<span class="t12">reset all sort/filter criteria</span>';
}
if (isset($get_show) && $get_show == 'majors' || $get_show == 'minors') {
    // show was set to only majors or only minors
    if ($get_show == 'minors') {
        if (isset($get_sort)) {
            // since a sort was clicked, find out which one
            if ($get_sort == 'player_name' || $get_sort == 'exp' || $get_sort == 'salary') {
                $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp='M' ORDER BY player_name ASC, rml_team ASC");
            } elseif ($get_sort == 'rml_team') {
                $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp='M' ORDER BY rml_team ASC, player_name ASC");
            }
        } else {
            $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp='M' ORDER BY rml_team ASC, player_name ASC");
        }
    } elseif ($get_show == 'majors') {
        if (isset($get_sort)) {
            // since a sort was clicked, find out which one
            if ($get_sort == 'player_name') {
                $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp!='M' ORDER BY player_name ASC, rml_team ASC");
            } elseif ($get_sort == 'rml_team') {
                $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp!='M' ORDER BY rml_team ASC, player_name ASC");
            } elseif ($get_sort == 'exp') {
                $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp!='M' ORDER BY exp DESC, player_name ASC");
            } elseif ($get_sort == 'salary') {
                $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp!='M' ORDER BY salary DESC, player_name ASC");
            }
        } else {
            $query_rosters = $conn->query("SELECT * FROM cur_roster WHERE exp!='M' ORDER BY rml_team ASC, player_name ASC");
        }
    }
} elseif (!isset($get_show)) {
    // either show all was clicked or none of the show links was clicked
    if (isset($get_sort)) {
        // since a sort was clicked, find out which one
        if ($get_sort == 'player_name') {
            $query_rosters = $conn->query("SELECT * FROM cur_roster ORDER BY player_name ASC, rml_team ASC");
        } elseif ($get_sort == 'rml_team') {
            $query_rosters = $conn->query("SELECT * FROM cur_roster ORDER BY rml_team ASC, player_name ASC");
        } elseif ($get_sort == 'exp') {
            $query_rosters = $conn->query("SELECT * FROM cur_roster ORDER BY exp DESC, player_name ASC");
        } elseif ($get_sort == 'salary') {
            $query_rosters = $conn->query("SELECT * FROM cur_roster ORDER BY salary DESC, player_name ASC");
        }
    } else {
        $query_rosters = $conn->query("SELECT * FROM cur_roster ORDER BY rml_team ASC, player_name ASC");
    }
}
echo '<br /><br />';
echo '<span class="t12">(Clicking on certain column headers will sort the data by that column.)</span>';
echo '</div>';
echo '<table class="roster"><tr>';
echo '<td class="schedl"><a href="current_roster.php?sort=player_name';
if (isset($get_show)) {
    echo '&show=' . $get_show;
}
echo '">PLAYER</a></td>';
echo '<td class="schedl"><a href="current_roster.php?sort=rml_team';
if (isset($get_show)) {
    echo '&show=' . $get_show;
}
echo '">RML TEAM</a></td>';
if (isset($get_show) && $get_show == 'minors') {
    echo '<td class="schedc">EXP</td>';
} else {
    echo '<td class="schedc"><a href="current_roster.php?sort=exp';
    if (isset($get_show)) {
        echo '&show=' . $get_show;
    }
    echo '">EXP</a></td>';
}
if (isset($get_show) && $get_show == 'minors') {
    echo '<td class="schedc">SAL</td>';
} else {
    echo '<td class="schedc"><a href="current_roster.php?sort=salary';
    if (isset($get_show)) {
        echo '&show=' . $get_show;
    }
    echo '">SAL</a></td>';
}
echo '<td class="schedc">Y</td><td class="schedc">C</td><td class="schedl">REAL TEAM</td><td class="schedc">B/T</td><td class="schedc">DOB</td><td class="schedl">POS</td></tr>';
while ($result_rosters = $query_rosters->fetch_assoc()) {
    echo '<tr>';
    echo '<td class="schedulel">' . $result_rosters['player_name'] . '</td>';
    echo '<td class="schedulel">' . $result_rosters['rml_team'] . '</td>';
    echo '<td class="schedulec">';
    if ($result_rosters['exp'] == 0) {
        echo 'M';
    } else {
        echo $result_rosters['exp'];
    }
    echo '</td>';
    echo '<td class="schedulec">';
    if ($result_rosters['salary'] == 0) {
        echo '';
    } else {
        echo $result_rosters['salary'];
    }
    echo '</td>';
    echo '<td class="schedulec">' . $result_rosters['y'] . '</td>';
    echo '<td class="schedulec">' . $result_rosters['c'] . '</td>';
    echo '<td class="schedulel">' . $result_rosters['real_team'] . '</td>';
    echo '<td class="schedulec">' . $result_rosters['b_t'] . '</td>';
    echo '<td class="schedulec">' . $result_rosters['dob'] . '</td>';
    echo '<td class="schedulel">' . $result_rosters['pos'] . '</td>';
    echo '</tr>';
}
$query_rosters->free_result();
echo '</table>';

include('components/footer/footer.php');
