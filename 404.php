<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<div class="m-5 bigger">';
echo '<p class="text-danger"><b>Error 404!</b><p>';
echo '<p>An error has occurred.</p>';
echo '<p>The page you are looking for does not exist!</p>';
echo '</div>';

include('components/footer/footer.php');
