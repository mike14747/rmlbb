<?php
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<title>RML Baseball Admin</title>';
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
echo '<link rel="stylesheet" href="../css/admin.css?v=1.2" type="text/css">';

// initialize tinymce3
include('scripts/tinymce3_init.php');

if (basename($_SERVER['PHP_SELF']) == 'edit_download_order.php' || 'add_new_news.php' || 'edit_delete_news.php' || 'add_event.php' || 'edit_delete_event.php') {
    // start scripts for jquery and jqueryui
    echo '<link rel="stylesheet" href="../css/jquery-ui.min.css">';
    echo '<script src="../js/jquery-3.2.0.min.js"></script>';
    echo '<script src="../js/jquery-ui.min.js"></script>';
}
if (basename($_SERVER['PHP_SELF']) == 'add_new_news.php' || 'edit_delete_news.php' || 'add_event.php' || 'edit_delete_event.php') {
    // initialize jqueryui datepicker
    include('scripts/datepicker_init.php');
}
if (basename($_SERVER['PHP_SELF']) == 'edit_download_order.php') {
    // initialize jqueryui sortable
    include('scripts/jqueryui_sortable_init.php');
}
echo '</head>';
echo '<body>';
echo '<div class="admin_header">';
echo '<h1>RML ADMIN AREA</h1>';
if (isset($_SESSION['rmlbb_username'])) {
    echo 'Logged in as: ';
    echo $_SESSION['rmlbb_username'] . ' &nbsp;| &nbsp;<a href="logout.php">Logout</a>';
} else {
    echo '<a href="login.php">Login</a>';
}
echo '</div>';
echo '<div class="container-fluid">';
