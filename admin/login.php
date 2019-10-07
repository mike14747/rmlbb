<?php
require_once('connections/conn1.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-12 p-4">';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'failed') {
        echo '<p class="t14"><span class="red"><b>Login Failed!</b></span></p>';
    } elseif ($_GET['status'] == 'logged_out') {
        echo '<p class="t14"><span class="red"><b>You are now logged out!</b></span></p>';
    } elseif ($_GET['status'] == 'username_success' && isset($_GET['new_username'])) {
        echo '<p class="mb-4"><span class="blue">Your username has been successfully changed to: "<b>' . $_GET['new_username'] . '</b>" and you have been automatically logged out. You must login with the new username from now on.</span></p>';
    } elseif ($_GET['status'] == "password_success") {
        echo '<p class="mb-4"><span class="blue">Your password has been successfully changed and you have been automatically logged out. You must login with the new password from now on.</span></p>';
    }
}
echo '<div>';
echo '<form action="login_check.php" method="post">';
echo '<p class="my-1">Username:</p>';
echo '<input class="mb-4" type="text" name="username" value="" />';
echo '<p class="my-1">Password:</p>';
echo '<input class="mb-5" type="password" name="password" value="" />';
echo '<input type="submit" name="login" value="Log In" />';
echo '</form>';
echo '</div>';

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
