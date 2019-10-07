<?php
require_once('connections/conn1.php');
session_start();
if (isset($_POST['login']) && $_POST['login'] == 'Log In') {
    if ((isset($_POST['username']) && $_POST['username'] != '') && (isset($_POST['password']) && $_POST['password'] != '')) {
        $username = $conn1->real_escape_string($_POST['username']);
        $password = $conn1->real_escape_string($_POST['password']);
        $password = MD5($password);
        $query_users = $conn1->query("SELECT * FROM users WHERE username='$username' && password='$password'");
        if ($query_users->num_rows == 1) {
            $result_users = $query_users->fetch_assoc();
            $_SESSION['rmlbb_username'] = $result_users['username'];
            $_SESSION['access_level'] = $result_users['access_level'];
            $_SESSION['user_id'] = $result_users['user_id'];
            $_SESSION['website_verify'] = 'rmlbb';
            header('Location: index.php');
        } else {
            header('Location: login.php?status=failed');
        }
    } else {
        header('Location: login.php?status=failed');
    }
} else {
    header('Location: login.php?status=failed');
}
