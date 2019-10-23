<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 py-3">';
echo '<h2>Current Season Dropdown Settings</h2>';

if (isset($_POST['submit']) && ($_POST['submit'] === 'Edit Item' || $_POST['submit'] === 'Delete Item')) {
    echo $_POST['nav_id'];
} else {
    $query_items = $conn1->query("SELECT * FROM cur_season_nav ORDER BY nav_id");
    if ($query_items->num_rows > 0) {
        echo '<div class="d-flex justify-content-start">';
        echo '<div class="min-w-50">';
        echo '<table class="table table-hover table-bordered">';
        echo '<thead>';
        echo '<tr class="bg-ltgray">';
        echo '<th>ID</th>';
        echo '<th>Nav Text</th>';
        echo '<th>Page Heading</th>';
        echo '<th>Display ?</th>';
        echo '<th>Page URL</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($result_items = $query_items->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="align-middle">';
            echo $result_items['nav_id'];
            echo '</td>';
            echo '<td class="align-middle">';
            echo '<input class="p-2" type="text" size="30" name="nav_text" value="' . $result_items['nav_text'] . '" />';
            // echo $result_items['nav_text'];
            echo '</td>';
            echo '<td class="align-middle">';
            echo '<input class="p-2" type="text" size="30" name="page_header" value="' . $result_items['page_header'] . '" />';
            echo '</td>';
            echo '<td class="align-middle">';
            echo $result_items['display'];
            echo '</td>';
            echo '<td class="align-middle">';
            echo '<input class="p-2" type="text" size="30" name="url_ref" value="' . $result_items['urlref'] . '" />';
            echo '</td>';
            echo '<td class="align-middle">';
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
            echo '<input type="hidden" name="nav_id" value="' . $result_items['nav_id'] . '" />';
            echo '<input class="mr-4 p-2" type="submit" name="submit" value="Edit Item">';
            echo '<input class="p-2" type="submit" name="submit" value="Delete Item">';
            echo '';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p class="bigger">No items found.</p>';
    }
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
