<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('components/admin_header/admin_header.php');

echo '<div class="row">';
echo '<div class="col-2">';
include('components/leftnav2/leftnav2.php');
echo '</div>';
echo '<div class="col-10 border-left border-dark py-3">';

// Check to see if the submit button has been clicked
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit') {
    // Set master error counting variable and validate email address
    $error_string = '';
    if (filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
        $s_contact_email = $_POST['contact_email'];
    } else {
        $error_string = 'The email address you entered (' . $_POST['contact_email'] . ') is not a valid email address.<br />';
    }
    if ($error_string != '') {
        echo '<p class=\"text-danger\"><b>FAILED!</b></p>';
        echo '<p class=\"text-danger\">Correct the errors and resubmit the form.</p>';
        echo '<p class=\"text-danger mb-3\">' . $error_string . '</p>';
        echo '<p><a href=\"javascript:history.go(-1);\">back</a></p>';
    } elseif ($error_string == '') {
        // since there were no errors, update items in the database
        $conn1->query("UPDATE settings SET display_events={$_POST['display_events']}, event_interval={$_POST['event_interval']}, display_recent={$_POST['display_recent']}, recent_posts={$_POST['recent_posts']}, contact_email='$s_contact_email'");
        // display confirmation message that the info has been updated in the database
        echo '<p class=\"mb-3\"><b>The settings have been updated with the following:</b></p>';
        echo '<p>Display "Events Box" on the right side of the homepage?: &nbsp;<span class=\"blue\"><b>';
        if ($_POST['display_events'] == 0) {
            echo 'No';
        } elseif ($_POST['display_events'] == 1) {
            echo 'Yes';
        }
        echo '</b></span></p>';
        echo "<p>Event Interval: &nbsp;<span class=\"blue\"><b>" . $_POST['event_interval'] . "</b></span></p>";
        echo "<p>Display 'Recent Posts Box' on the right side of the homepage?:</b> &nbsp;<span class=\"blue\"><b>";
        if ($_POST['display_recent'] == 0) {
            echo "No";
        } elseif ($_POST['display_recent'] == 1) {
            echo "Yes";
        }
        echo "</b></span></p>";
        echo "<p>Number of Recent Post to Display: &nbsp;<span class=\"blue\"><b>" . $_POST['recent_posts'] . "</b></span></p>";
        echo "<p>Contact Us Email: &nbsp;<span class=\"blue\"><b>" . $s_contact_email . "</b></span></p>";
    }
} else {
    // Since the submit button has not been clicked, display the form
    echo "<h2>UPDATE WEBSITE SETTINGS</h2>";
    $query_settings = $conn1->query("SELECT * FROM settings WHERE setting_id=1");
    $result_settings = $query_settings->fetch_assoc();
    $query_settings->free_result();
    echo "<form action=\"update_settings.php\" method=\"post\">";
    echo "<p class=\"updateitem\"><b>Display 'Upcoming Events' Box on right side of the homepage?</b>:<br /><br />";
    echo "<select name=\"display_events\">";
    echo "<option value=\"1\"";
    if ($result_settings['display_events'] == 1) {
        echo " selected=\"selected\"";
    }
    echo ">Yes</option>";
    echo "<option value=\"0\"";
    if ($result_settings['display_events'] == 0) {
        echo " selected=\"selected\"";
    }
    echo ">No</option>";
    echo "</select>";
    echo "</p>";
    echo "<p class=\"updateitem\"><b>How many days of 'Upcoming Events' to display in homepage right side box?</b> (Default started at: 60):<br />";
    echo "<br /><b>Note:</b> if the above setting of 'Display Upcoming Events Box' is set to 'No', then this setting will be of no value.<br /><br />";
    echo "<select name=\"event_interval\">";
    for ($u = 15; $u <= 180; $u += 15) {
        echo "<option value=\"" . $u . "\"";
        if ($result_settings['event_interval'] == $u) {
            echo " selected=\"selected\"";
        }
        echo ">" . $u . "</option>";
    }
    echo "</select>";
    echo "</p>";
    echo "<p class=\"updateitem\"><b>Display 'Recent Message Board Posts' Box on right side of the homepage?</b>:<br /><br />";
    echo "<select name=\"display_recent\">";
    echo "<option value=\"1\"";
    if ($result_settings['display_recent'] == 1) {
        echo " selected=\"selected\"";
    }
    echo ">Yes</option>";
    echo "<option value=\"0\"";
    if ($result_settings['display_recent'] == 0) {
        echo " selected=\"selected\"";
    }
    echo ">No</option>";
    echo "</select>";
    echo "</p>";
    echo "<p class=\"updateitem\"><b>How many 'Recent Message Board Posts' to display in homepage right side box?</b> (Default started at: 5):<br />";
    echo "<br /><b>Note:</b> if the above setting of 'Display Recent Message Board Posts' is set to 'No', then this setting will be of no value.<br /><br />";
    echo "<select name=\"recent_posts\">";
    for ($r = 1; $r <= 20; $r++) {
        echo "<option value=\"" . $r . "\"";
        if ($result_settings['recent_posts'] == $r) {
            echo " selected=\"selected\"";
        }
        echo ">" . $r . "</option>";
    }
    echo "</select>";
    echo "</p>";
    echo "<p class=\"updateitem\"><b>Enter email address to associate with the 'Contact Us' link on the website</b>:<br /><br /><input type=\"text\" name=\"contact_email\" size=\"50\" maxlength=\"80\" value=\"" . $result_settings['contact_email'] . "\" /></p><br />";
    echo "<p class=\"t16\">Click submit to update the website settings with the info provided: &nbsp;<input type=\"submit\" name=\"submit\" value=\"Submit\" /></p>";
    echo "</form>";
}

echo '</div>';
echo '</div>';

include('components/admin_footer/admin_footer.php');
