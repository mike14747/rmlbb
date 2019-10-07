<?php
if ($user->data['is_registered']) {
    // user is logged into phpBB
} else {
    // user is not logged into phpBB
    header('Location: login.php?page=directory');
}
