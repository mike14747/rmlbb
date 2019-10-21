<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';

echo '<div class="m-5 bigger">';
echo '<p class="text-danger"><b>Error 502!</b><p>';
echo '<p>Bad Gateway!</p>';
echo '<p>The web server is temporary overloaded and can\'t process your request. Please try to access the site later.</p>';
echo '</div>';

echo '</div>';

include('components/admin_footer/admin_footer.php');
