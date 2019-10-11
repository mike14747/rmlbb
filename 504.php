<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<div class="m-5 bigger">';
echo '<p class="text-danger"><b>Error 504!</b><p>';
echo '<p>The server is temporary unavailable.</p>';
echo '<p>Please try to access the site later.</p>';
echo '</div>';

include('components/footer/footer.php');
