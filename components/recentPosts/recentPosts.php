<?php
if ($result_settings['display_recent'] == 1) {
    echo '<div class="w-200px h-auto clear-right border border-secondary bg-light float-right text-left ml-2 mb-3 p-2 lh-115">';
    echo '<h5>MESSAGE BOARD ACTIVITY</h5>';
    echo '<p class="small mt-2 mb-3 py-1 pl-1 bg-ltgray"><b>' . $result_settings['recent_posts'] . ' MOST RECENT POSTS:</b></p>';
    // connect to the message board datbase
    require_once('connections/conn2.php');
    // select the most recent x number of message board posts
    $query_posts = $conn2->query("SELECT pp.poster_id, pu.username, FROM_UNIXTIME(pp.post_time, '%m-%d-%y %l:%i%p') AS post_time1, pf.forum_name, pp.post_subject, pp.post_text FROM phpbb_posts AS pp JOIN phpbb_users AS pu ON (pp.poster_id=pu.user_id) JOIN phpbb_forums AS pf ON (pp.forum_id=pf.forum_id) WHERE pp.post_delete_user=0 ORDER BY pp.post_time DESC LIMIT {$result_settings['recent_posts']}");
    // loop through the recent posts
    while ($result_posts = $query_posts->fetch_assoc()) {
        echo '<div class="border-bottom border-secondary my-3 small">';
        echo '<p class="my-2"><span class="text-secondary small">POSTED ON: </span>' . $result_posts['post_time1'] . '</p>';
        echo '<p class="my-2"><span class="small text-secondary">FORUM: </span>';
        $cleaned_forum = filter_var($result_posts['forum_name'], FILTER_SANITIZE_STRING);
        if (strlen($result_posts['forum_name']) >= 25) {
            echo substr($cleaned_forum, 0, 24) . '~';
        } else {
            echo $cleaned_forum;
        }
        echo '</p>';
        echo '<p class="my-2"><span class="small text-secondary">TOPIC: </span>';
        $cleaned_topic = filter_var($result_posts['post_subject'], FILTER_SANITIZE_STRING);
        if (strlen($cleaned_topic) >= 25) {
            echo substr($cleaned_topic, 0, 24) . '~';
        } else {
            echo $cleaned_topic;
        }
        echo '</p>';
        echo '<p class="my-2"><span class="small text-secondary">AUTHOR: </span>' . $result_posts['username'] . '</p>';
        echo '<p class="mt-2 mb-3"><span class="small text-secondary">MESSAGE: </span>';
        // $cleaned_message_text = $conn->real_escape_string(strip_tags(filter_var($result_posts['post_text'], FILTER_SANITIZE_STRING)));
        $cleaned_message_text = strip_tags(str_replace("\n", " ", filter_var($result_posts['post_text'], FILTER_SANITIZE_STRING)));
        // save message text and bbcode to a variable, then remove the bbcode and carriage returns
        // $original_message_text = $conn->real_escape_string(strip_tags(str_replace("\n", " ", $result_posts['post_text'])));
        $pattern = '~\[[^]]+]~';
        $replace = '';
        $cleaned_message_text = preg_replace($pattern, $replace, $cleaned_message_text);
        if (strlen($cleaned_message_text) >= 25) {
            echo substr($cleaned_message_text, 0, 24) . '~';
        } else {
            echo $cleaned_message_text;
        }
        echo '</p>';
        echo '</div>';
    }
    $query_posts->free_result();
    // start log into message board link
    echo '<div class="small mt-3 d-flex align-items-center justify-content-end"><img src="components/recentPosts/images/arrow.gif" alt="Message Board" width="11" height="11" /><img src="components/recentPosts/images/arrow.gif" alt="Message Board" width="11" height="11" /><a href="phpBB3/index.php">Go to the Message Board</a></div>';
    echo '</div>';
    // close the connection to the message board database
    $conn2->close();
}
