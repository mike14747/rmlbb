<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';
echo '<h2>Error 502</h2>';

echo '<h5 class="text-danger">Bad Gateway! The web server is temporary overloaded and can\'t process your request. Please try to access the site later.</h4>';

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
