<?php
// logout the admin user
session_start();
if (isset($_SESSION['rmlbb_username'])) {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    session_unset();
    session_destroy();
    if (isset($_GET['status']) && $_GET['status'] == 'username_success' && isset($_GET['new_username'])) {
        header('Location: login.php?status=username_success&new_username=' . $_GET['new_username'] . '');
    } elseif (isset($_GET['status']) && $_GET['status'] == 'password_success') {
        header('Location: login.php?status=password_success');
    } else {
        header('Location: login.php?status=logged_out');
    }
} else {
    header('Location: login.php?status=logged_out');
}
