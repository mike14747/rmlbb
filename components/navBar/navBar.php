<?php
echo '<nav>';
echo '<ul>';
    // current season dropdown
    include('currentSeasonDropdown/currentSeasonDropdown.php');
    // downloads dropdown
    include('downloadsDropdown/downloadsDropdown.php');
    echo '<li><a href="constitution.php">Constitution</a></li>';
    echo '<li><a href="directory.php">Manager Directory</a></li>';
    // lzps dropdown
    include('lzpsDropdown/lzpsDropdown.php');
    echo '<li><a href="events.php">Upcoming Events</a></li>';
    echo '<li><a href="phpBB3/index.php">Message Board</a></li>';
echo '</ul>';
echo '</nav>';
