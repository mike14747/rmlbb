<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

// query settings table to decide which boxes to display
$query_settings = $conn->query("SELECT * FROM settings WHERE setting_id=1");
$result_settings = $query_settings->fetch_assoc();
$query_settings->free_result();
// events box
include('components/eventsBox/eventsBox.php');
// recent posts box
include('components/recentPosts/recentPosts.php');
// start Latest RML News section
// get user input of days to display if it exists or set it to the default of 60 if it doesn't exist
if (isset($get_days)) {
    $news_days = $get_days;
} else {
    $news_days = 60;
}
// display latest news header
echo '<h2>RML NEWS</h2>';
// set the options of what day numbers should appear as links to an array
$select_days = array(30, 60, 90, 365);
echo '<span class="newsdate">CURRENTLY DISPLAYING NEWS FROM PAST: <span class="t12">';
if ($news_days == 9999) {
    echo 'ALL';
} else {
    echo $news_days;
}
echo '</span> DAYS</span><br />';
echo '<span class="newsdate">VIEW NEWS FROM THE PAST:<span class="t12">';
foreach ($select_days as $z) {
    if ($z == $news_days) {
        echo ' &nbsp;' . $z;
    } else {
        echo ' &nbsp;<a href="index.php?days=' . $z . '">' . $z . '</a>';
    }
}
echo '</span> &nbsp;DAYS</span>';
echo ' &nbsp;| &nbsp; <span class="newsdate">SHOW <span class="t12"><a href="index.php?days=9999">ALL</a></span> NEWS</span>';
$query_news = $conn->query("SELECT *, DATE_FORMAT(newsdate, '%b-%d, %Y') AS newsdate1 FROM rmlnews WHERE newsdate>=DATE_SUB(CURDATE(), INTERVAL $news_days DAY) ORDER BY newsdate DESC, news_id DESC");
$news_items = $query_news->num_rows;
while ($result_news = $query_news->fetch_assoc()) {
    if ($news_items <= 1) {
        echo '<div class="newsdiv_final">';
    } elseif ($news_items > 1) {
        echo '<div class="newsdiv">';
    }
    echo '<h4>' . $result_news['newsheader'] . '</h4>';
    echo '<span class="newsdate">DATE: ' . $result_news['newsdate1'] . '</span><br />';
    echo $result_news['newstext'];
    echo '</div>';
    $news_items--;
}
$query_news->free_result();

include('components/footer/footer.php');
