<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';

echo '<div class="m-5 bigger">';
echo '<p class="bigger text-danger"><b>Error 508!</b><p>';
echo '<p>Resource Limit Is Reached!</p>';
echo '<p>The website is temporarily unable to service your request as it exceeded resource limit. Please try again later.</p>';
echo '</div>';

echo '</div>';

include('components/admin_footer/admin_footer.php');
