<?php
require_once('connections/conn1.php');

if (isset($_POST['submit']) && isset($_POST['user_id'])) {
    $error_string = '';
    // since the submit button has been clicked, determine which submit button was clicked
    if ($_POST['submit'] == 'Change Username') {
        $new_username = $conn1->real_escape_string($_POST['username']);
        if (!preg_match('/^[a-z0-9_-]{4,40}$/i', $_POST['username'])) {
            // since the username is not between 4 and 20 characters... or consists of something other than letters, numbers, underscores and dashes, display the error
            $error_string .= 'Your username was not between 4 and 20 characters... or consists of something other than letters, numbers and underscores. ';
        } else {
            // now that the username is between 4 and 20 characters long... and consists of letters, numbers, underscores and dashes, proceed
            $new_username = $conn1->real_escape_string($_POST['username']);
            $conn1->query("UPDATE users SET username='$new_username' WHERE user_id={$_POST['user_id']}");
            header('Location: logout.php?status=username_success&new_username=' . $new_username);
        }
        if ($error_string != '') {
            header('Location: change_user_pass.php?error=' . $error_string);
        }
    } elseif ($_POST['submit'] == 'Change Password') {
        $new_password = $conn1->real_escape_string($_POST['password1']);
        if ($_POST['password1'] != $_POST['password2']) {
            // since the passwords don't match, display the error
            $error_string .= 'The passwords you entered don\'t match. ';
        } elseif (strlen($_POST['password1']) < 4 || strlen($_POST['password1']) > 20 || strlen($_POST['password2']) < 4 || strlen($_POST['password2']) > 20) {
            // since one of the passwords is not between 4 and 20 characters, display the error
            $error_string .= 'One (or both) of the passwords you entered is not between 4 and 20 characters. ';
        } elseif (strpos($_POST['password1'], ' ') == true) {
            // since the password being submitted has a space in it, display the error
            $error_string .= 'Your password cannot have any spaces in it. ';
        } else {
            // now that the password passes all validation, proceed
            $new_password = $conn1->real_escape_string($_POST['password1']);
            $conn1->query("UPDATE users SET password=MD5('$new_password') WHERE user_id={$_POST['user_id']}");
            header('Location: logout.php?status=password_success');
        }
        if ($error_string != '') {
            header('Location: change_user_pass.php?error=' . $error_string);
        }
    }
}

include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 py-3">';
echo '<h2>UPDATE YOUR ADMIN USERNAME OR PASSWORD</h2>';

// this is where you land when you first come to this page or if there were errors in your submission
if (isset($_GET['error'])) {
    echo '<p class="text-danger"><b>Error! ' . $_GET['error'] . '</b></p>';
}
echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
// start the code for updating username
echo '<p><b>Change your username to:</b> ';
echo '<input class="ml-2" type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '" />';
echo '<input class="ml-2" type="text" name="username" size="25" value="' . $_SESSION['rmlbb_username'] . '" />';
echo '<input class="ml-2" type="submit" name="submit" value="Change Username" />';
echo '</p>';
echo '<p class="mb-1"><b>Note:</b></p>';
echo '<ul>';
echo '<li>Username must be from 4 to 20 characters in length.</li>';
echo '<li>It must conain only letters, numbers, underscores or dashes.</li>';
echo '</ul>';
echo '</form>';
echo '<hr class="my-5 ml-2 w-75" align="left">';
// start the code for updating password
echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
echo '<input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '" />';
echo '<p><b>Change your password to:</b> ';
echo '<input class="ml-2" type="password" name="password1" size="25" maxlength="20" value="" />';
echo '</p>';
echo '<p><b>Re-enter your new password:</b> ';
echo '<input class="mx-2" type="password" name="password2" size="25" maxlength="20" />';
echo '<input type="submit" name="submit" value="Change Password" />';
echo '</p>';
echo '<p class="mb-1"><b>Note:</b></p>';
echo '<ul>';
echo '<li>Password must be from 4 to 20 characters in length.</li>';
echo '<li>It can conain not only letters, numbers, underscores and dashes, but just about any special character.</li>';
echo '</ul>';
echo '</form>';

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
