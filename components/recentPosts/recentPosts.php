<?php
if ($result_settings['display_recent'] == 1) {
    echo '<div class="w-200px h-auto clear-right border border-secondary bg-light float-right text-left ml-2 mb-3 p-2">';
    echo '<h5>MESSAGE BOARD ACTIVITY</h5>';
    echo '<span class="small text-secondary">' . $result_settings['recent_posts'] . ' MOST RECENT POSTS:</span><br />';
    // connect to the message board datbase
    require_once('connections/conn2.php');
    // select the most recent x number of message board posts
    $query_posts = $conn2->query("SELECT pp.poster_id, pu.username, FROM_UNIXTIME(pp.post_time, '%m-%d-%y %l:%i%p') AS post_time1, pf.forum_name, pp.post_subject, pp.post_text FROM phpbb_posts AS pp JOIN phpbb_users AS pu ON (pp.poster_id=pu.user_id) JOIN phpbb_forums AS pf ON (pp.forum_id=pf.forum_id) WHERE pp.post_delete_user=0 ORDER BY pp.post_time DESC LIMIT {$result_settings['recent_posts']}");
    // loop through the recent posts
    while ($result_posts = $query_posts->fetch_assoc()) {
        echo '<div class="text-dark border-bottom border-secondary small py-3">';
        echo '<span class="small text-secondary">POSTED ON: </span>' . $result_posts['post_time1'] . '<br />';
        echo '<span class="small text-secondary">FORUM: </span>';
        if (strlen($result_posts['forum_name']) >= 30) {
            echo $conn->real_escape_string(substr($result_posts['forum_name'], 0, 30)) . '...<br />';
        } else {
            echo $conn->real_escape_string($result_posts['forum_name']) . '<br />';
        }
        echo '<span class="small text-secondary">TOPIC: </span>';
        if (strlen($result_posts['post_subject']) >= 30) {
            echo $conn->real_escape_string(substr($result_posts['post_subject'], 0, 30)) . '...<br />';
        } else {
            echo $conn->real_escape_string($result_posts['post_subject']) . '<br />';
        }
        echo '<span class="small text-secondary">AUTHOR: </span>' . $result_posts['username'] . '<br />';
        echo '<span class="small text-secondary">MESSAGE: </span>';
        // save message text and bbcode to a variable, then remove the bbcode and carriage returns
        $original_message_text = $conn->real_escape_string(strip_tags(str_replace("\n", " ", $result_posts['post_text'])));
        $pattern = '~\[[^]]+]~';
        $replace = '';
        $cleaned_message_text = preg_replace($pattern, $replace, $original_message_text);
        if (strlen($cleaned_message_text) >= 25) {
            echo substr($cleaned_message_text, 0, 22) . '...<br />';
        } else {
            echo $cleaned_message_text . '<br />';
        }
        echo '</div>';
    }
    $query_posts->free_result();
    // start log into message board link
    echo '<div class="small mt-3 d-flex align-items-center justify-content-end"><img src="components/recentPosts/images/arrow.gif" alt="Message Board" width="11" height="11" /><img src="components/recentPosts/images/arrow.gif" alt="Message Board" width="11" height="11" /><a href="phpBB3/index.php">Go to the Message Board</a></div>';
    echo '</div>';
    // close the connection to the message board database
    $conn2->close();
}
