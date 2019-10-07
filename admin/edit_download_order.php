<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';
echo '<h2>EDIT THE DROPDOWN ORDER OF DOWLOADS</h2>';

if (isset($_POST['submit'])) {
    // the submit was clicked to change the order in the database
    $id_ary = explode(',', $_POST['sort_order']);
    for ($i = 0; $i < count($id_ary); $i++) {
        $j = $i + 1;
        $conn1->query("UPDATE downloads SET download_order=$j WHERE download_id=$id_ary[$i]");
    }
    echo 'Done! Here is the new order:<br /><br />';
    $query_downloads = $conn1->query("SELECT description FROM downloads WHERE display=1 ORDER BY download_order ASC, download_id DESC");
    echo '<ul class="no_sort_icon">';
    while ($result_downloads = $query_downloads->fetch_assoc()) {
        echo '<li class="no_sort_icon">' . $result_downloads['description'] . '</li>';
    }
    $query_downloads->free_result();
    echo '</ul>';
} else {
    // the submit button was not clicked, so display all the items to be sorted
    echo '<p class="t16">Drag the downloads around into their optimal positions as you want them to appear in the navigation bar\'s dropdown menu, then click the: "Save Order" button at the bottom of the page. Note: downloads that are set to be hidden are not in this list. Also note: only the first 10 downloads will be viewable on the navigation bar. The full list can be viewed only by clicking "View All Downloads".</p><br />';
    $query_downloads = $conn1->query("SELECT * FROM downloads WHERE display=1 ORDER BY download_order ASC, download_id DESC");
    echo '<form name="frmQA" method="POST" />';
    echo '<input type="hidden" name="sort_order" id="sort_order" /> ';
    echo '<ul class="sort_icon" id="sortable">';
    while ($result_downloads = $query_downloads->fetch_assoc()) {
        echo '<li class="sort_icon" id="' . $result_downloads['download_id'] . '">' . $result_downloads['description'] . '</li>';
    }
    $query_downloads->free_result();
    echo '</ul>';
    echo '<div class="submit_button"><input type="submit" name="submit" value="Save Order" onClick="saveOrder();" /></div>';
    echo '</form>';
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
