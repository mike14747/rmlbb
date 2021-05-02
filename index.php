<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');

// query settings table to decide which boxes to display
$query_settings = $conn->query("SELECT * FROM settings WHERE setting_id=1");
$result_settings = $query_settings->fetch_assoc();
$query_settings->free_result();
echo '<div class="clearfix">';
// events box
include('components/eventsBox/eventsBox.php');
// recent posts box
include('components/recentPosts/recentPosts.php');
// start Latest RML News section
// get user input of days to display if it exists or set it to the default of 60 if it doesn't exist
$news_days = request_var('days', 90) ? request_var('days', 90) : 90;
echo '<h2>RML NEWS</h2>';
// set the options of what day numbers should appear as links to an array
$select_days = array(30, 60, 90, 365);
echo '<div class="my-2 text-secondary ls-1 overflow-auto"><span class="small">CURRENTLY DISPLAYING NEWS FROM THE PAST:</span> ';
if ($news_days == 9999) {
    echo 'ALL';
} else {
    echo $news_days;
}
echo ' <span class="small">DAYS</span></div>';
echo '<div class="text-secondary ls-1 pb-2 border-bottom overflow-auto"><span class="small">VIEW NEWS FROM THE PAST:</span>';
foreach ($select_days as $z) {
    if ($z == $news_days) {
        echo ' &nbsp;<span class="small">' . $z . '</span>';
    } else {
        echo ' &nbsp;<a href="index.php?days=' . $z . '">' . $z . '</a>';
    }
}
echo ' &nbsp;<span class="small">DAYS</span>';
echo ' &nbsp;| &nbsp; <span class="small">SHOW</span> <a href="index.php?days=9999">ALL</a> <span class="small">NEWS</span></div>';
$query_news = $conn->query("SELECT *, DATE_FORMAT(newsdate, '%b-%d, %Y') AS newsdate1 FROM rmlnews WHERE newsdate>=DATE_SUB(CURDATE(), INTERVAL $news_days DAY) ORDER BY newsdate DESC, news_id DESC");
$news_items = $query_news->num_rows;
while ($result_news = $query_news->fetch_assoc()) {
    if ($news_items <= 1) {
        echo '<div class="py-2 overflow-auto">';
    } elseif ($news_items > 1) {
        echo '<div class="border-bottom border-secondary py-2 overflow-auto">';
    }
    echo '<h4>' . $result_news['newsheader'] . '</h4>';
    echo '<div class="mt-2 mb-3 small text-secondary ls-1">DATE: ' . $result_news['newsdate1'] . '</div>';
    echo $result_news['newstext'];
    echo '</div>';
    $news_items--;
}
echo '</div>';
$query_news->free_result();

include('components/footer/footer.php');
