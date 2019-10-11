<?php
require_once('connections/conn.php');
include('logged_in_check.php');
if (!empty($user->data['is_registered'])) {
    // user is already logged in to phpBB
    header('Location: index.php');
}
if ($request->is_set_post('login')) {
    // the login form has been submitted
    $username = $request->variable('username', '', true);
    $password = $request->variable('password', '', true);
    $autologin = $request->variable('autologin', '', true);
    $result = $auth->login($username, $password, $autologin);
    if ($result['status'] == LOGIN_SUCCESS) {
        // user was successfully logged into phpBB
        if ($request->is_set_post(redirect)) {
            $redirect = $request->variable('redirect', '');
            header('Location: ' . $redirect . '.php');
        } else {
            header('Location: index.php');
        }
    } else {
        // user's login failed
        header('Location: login.php');
    }
} else {
    include('components/header/header.php');
    include('components/navBar/navBar.php');
    echo '<h2>LOGIN</h2><br /><br />';
    echo '<form action="login.php" method="post">';
    echo '<label class="mr-4" for="username">Username: <input type="text" name="username" size="15" /></label>';
    echo '<label class="mr-4" for="password">Password: <input type="password" name="password" size="15" /></label>';
    echo '<a href="phpBB3/ucp.php?mode=sendpassword">I forgot my password</a>';
    echo '<label class="mx-4" for="autologin">Remember me <input type="checkbox" name="autologin" /></label>';
    if (isset($get_page)) {
        echo '<input type="hidden" name="redirect" value=' . $get_page . ' />';
    }
    echo '<input type="submit" name="login" value="Login" />';
    echo '</form><br /><br />';
}

include('components/footer/footer.php');
