<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';
echo '<h2>EDIT (or delete) AN EXISTING LZP FILE</h2>';

echo '<p class="text-danger">This page is not yet functional.</p>';

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
