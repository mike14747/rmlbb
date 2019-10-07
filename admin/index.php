<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';
echo '<h2>RML ADMIN HOMEPAGE</h2>';

echo '<div class="pb-3">Click on an item on the left to manage that particular part of the main website.</div>';
echo '<div class="pb-3">Note... some parts of the website need to be managed separately through the <a href="../phpBB3/index.php" target="_blank"><b>Message Board</b></a> (by logging into the "Administration Control Panel" at the bottom of the page... after first logging into the main message board). Those areas include:';
echo '<ul>';
    echo '<li>Username / Password management (for the main website and message board since they are linked)</li>';
    echo '<li>Anything to do with the message board (posts, permissions, forums, etc)</li>';
echo '</ul>';
echo '</div>';
echo '<div class="pb-3">If you click on: "Change your admin username or password" (in the left pane), it will only change your admin username and/or password. That is totally separate from your username and password for the main website and message board.</div>';

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
