<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

echo '<div class="m-5 bigger">';
echo '<p class="text-danger"><b>Error 508!</b><p>';
echo '<p>Resource Limit Is Reached.</p>';
echo '<p>The website is temporarily unable to service your request as it exceeded resource limit.</p>';
echo '<p>Please try again later.</p>';
echo '</div>';

include('components/footer/footer.php');
