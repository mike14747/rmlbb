<?php
// make sure the user is logged into the admin area
session_start();
if (isset($_SESSION['rmlbb_username']) && isset($_SESSION['access_level']) && isset($_SESSION['website_verify']) && $_SESSION['website_verify'] == 'rmlbb') {
    // user must be logged in, so proceed
} else {
    // since the user is not logged in, send them to login
    header('Location: login.php');
}
