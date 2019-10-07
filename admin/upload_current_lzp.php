<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('admin_header.php');






echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"leftnav\">";
include('leftnav2.php');
echo "</td><td class=\"cell3\">";
echo "<h2>UPLOAD CURRENT SEASON LZP FILE</h2>";
echo "<p class=\"red\">This page is not yet functional.</p>";
/*
if (isset($_POST['submit'])) {
	if ($_POST['submit'] == "Upload File") {
		// user is trying to upload a new version of a download
		// first make sure there has been a file selected for upload
		if ($_FILES['new_file']['size'] > 0) {
			$target_dir = "../downloads/";
			$target_path = $target_dir . basename($_FILES['new_file']['name']);
			// since there is a file being uploaded, check to see if it has the same filename as the current file associated with this download
			if (move_uploaded_file($_FILES['new_file']['tmp_name'], $target_path)) {
				// if the uploaded file has a different name, delete the old file
				if ($_POST['file_name'] != basename($_FILES['new_file']['name'])) {
					// since the uploaded file has a different name than the original, delete the original and upldate the name in the database
					$new_file_name = basename($_FILES['new_file']['name']);
					mysql_query("UPDATE downloads SET file_name='$new_file_name' WHERE download_id={$_POST['download_id']}", $conn) or die("Cannot change filename in the database! " . mysql_error());
					if (file_exists($target_dir . $_POST['file_name'])) {
						unlink($target_dir . $_POST['file_name']);
					}
				}
				echo "<p class=\"t16\">The file: '<b>".  basename( $_FILES['new_file']['name']). "</b>' has been uploaded successfully.</p>";
			} else {
				echo "<p class=\"t16\"><span class=\"red\">There was an error uploading the file, <a href=\"edit_delete_download.php\"><b>please try again</b></a>!</span></p>";
			}
		} else {
			echo "<p class=\"t16\"><span class=\"red\">No file was selected for upload!</span></p>";
			echo "<p class=\"t16\"><a href=\"edit_delete_download.php\"><b>START OVER</b></a></p>";
		}
	} elseif ($_POST['submit'] == "Submit Changes") {
		// user is changing the properties of a download
		if (isset($_POST['download_id']) && isset($_POST['description']) && isset($_POST['display']) && isset($_POST['sticky'])) {
			// make sure the description wasn't left blank
			if ($_POST['description'] == "") {
				echo "<p class=\"t16\"><span class=\"red\">The description for this download was left blank, <a href=\"edit_delete_download.php\"><b>please try again</b></a>!</span></p>";
			} else {
				// make the changes in the database
				mysql_query("UPDATE downloads SET description='{$_POST['description']}', display={$_POST['display']}, sticky={$_POST['sticky']} WHERE download_id={$_POST['download_id']}", $conn) or die("Cannot make changes to this download in the database! " . mysql_error());
				echo "<p class=\"t16\">The changes were successfully made.</p>";
			}
		} else {
			echo "<p class=\"t16\"><span class=\"red\">An error occurred, <a href=\"edit_delete_download.php\"><b>please try again</b></a>!</span></p>";
		}
	}
} elseif (isset($_POST['delete']) && isset($_POST['download_id'])) {
	// a delete button was clicked, find out which one
	if ($_POST['delete'] == "Delete Download") {
		// user has clicked to delete a download
		echo "<p class=\"t16r\">Are you sure you want to permanently delete this download (<b>" . $_POST['description'] . "</b>) and all traces of it from the website?</p><br />";
		echo "<form action=\"edit_delete_download.php\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $_POST['download_id'] . "\" />";
			echo "<input type=\"hidden\" name=\"file_name\" value=\"" . $_POST['file_name'] . "\" />";
			echo "<input type=\"submit\" name=\"delete\" value=\"Confirm Delete\" /><br /><br />";
		echo "</form>";
	} elseif ($_POST['delete'] == "Confirm Delete") {
		// user has confirmed to delete a download
		mysql_query("DELETE FROM downloads WHERE download_id={$_POST['download_id']}", $conn) or die("Cannot download from the database! " . mysql_error());
		$target_dir = "../downloads/";
		unlink($target_dir . $_POST['file_name']);
	}
} elseif (isset($_GET['download_id'])) {
	$query_pages = mysql_query("SELECT * FROM sitepages WHERE page_id=2 Limit 1", $conn) or die("Cannot access the current season LZP in the database! " . mysql_error());
	$page = mysql_fetch_assoc($query_pages);
	echo "<div class=\"updateitem\"><b>Edit the properties of this download:</b><br /><br />";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $download['download_id'] . "\" />";
			echo "<b>Description</b> (name that shows up in the navigation bar and on the downloads page... max length is 40 characters):<br /><input type=\"text\" name=\"description\" value=\"" . $download['description'] . "\"  size=\"40\" maxlength=\"40\" /><br /><br />";
			echo "<b>Display (enable) this page</b> (this includes displaying it on both the navigation bar and the downloads page... selecting 'No' will not delete the download, just disable it until it's re-enabled):<br />";
			echo "Yes <input type=\"radio\" name=\"display\" value=\"1\"";
			if ($download['display'] == 1) {
				echo "checked";
			}
			echo " /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "No <input type=\"radio\" name=\"display\" value=\"0\"";
			if ($download['display'] == 0) {
				echo "checked";
			}
			echo " /><br /><br />";
			echo "<b>Make this download 'Sticky'</b> (this will keep it in the top group of both the navigation bar and the downloads page... this should be set to 'Yes' for downloads that carry over from year to year, ie: the RML Constitution and the Player/Money Totals downloads):<br />";
			echo "Yes <input type=\"radio\" name=\"sticky\" value=\"1\"";
			if ($download['sticky'] == 1) {
				echo "checked";
			}
			echo " /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "No <input type=\"radio\" name=\"sticky\" value=\"0\"";
			if ($download['sticky'] == 0) {
				echo "checked";
			}
			echo " /><br /><br />";
			echo "<input type=\"submit\" name=\"submit\" value=\"Submit Changes\" /><br /><br />";
		echo "</form>";
	echo "</div><br />";
	echo "<div class=\"updateitem\"><b>Upload a newer version of the current season LZP file:</b><br /><br />";
		echo "The current file associated with this LZP is: <b>" . $download['file_name'] . "</b><br /><br />";
		echo "The file you upload doesn't have to have the same name as the existing file, but if the name is different, the existing file will be permanently deleted from the server. If you upload a file with the same name, it will overwrite the existing file. Either way, the existing file will be gone and the new file you're uploading will become associated with the current season LZP.";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $download['download_id'] . "\" />";
			echo "<input type=\"hidden\" name=\"file_name\" value=\"" . $download['file_name'] . "\" />";
			echo "<p class=\"t14\"><b>Upload newer version of this download file: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>";
			echo "<input name=\"new_file\" type=\"file\" id=\"new_file\" size=\"50\"></p>";
			echo "<input type=\"submit\" name=\"submit\" value=\"Upload File\"><br /><br />";
		echo "</form>";
	echo "</div><br />";
	echo "<div class=\"updateitem\"><b>Permanently delete this download:</b><br /><br />(this will remove all traces of this download from the website... it will no longer appear in the navigation pane, nor on the downloads page... the file will also be deleted from the server):<br /><br />";
		echo "Note: you will be prompted to confirm the deletion of this file... just clicking the delete button alone won't do it.<br /><br />";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $download['download_id'] . "\" />";
			echo "<input type=\"hidden\" name=\"description\" value=\"" . $download['description'] . "\" />";
			echo "<input type=\"hidden\" name=\"file_name\" value=\"" . $download['file_name'] . "\" />";
			echo "<input type=\"submit\" name=\"delete\" value=\"Delete Download\" /><br /><br />";
		echo "</form>";
	echo "</div><br />";
} elseif (!isset($_POST['submit']) && !isset($_POST['delete']) && !isset($_GET['download_id'])) {
	// no submit has been clicked, so load the entry page
	$query_pages = mysql_query("SELECT * FROM sitepages WHERE page_id=2 Limit 1", $conn) or die("Cannot access the current season LZP in the database! " . mysql_error());
	$page = mysql_fetch_assoc($query_pages);
	echo "<div class=\"updateitem\"><b>Upload a newer version of the current season LZP file:</b><br /><br />";
		echo "The current file associated with this LZP is: <b>" . $page['urlref'] . "</b><br /><br />";
		echo "The file you upload doesn't have to have the same name as the existing file, but if the name is different, the existing file will be permanently deleted from the server. If you upload a file with the same name, it will overwrite the existing file. Either way, the existing file will be gone and the new file you're uploading will become associated with the current season LZP.";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
			echo "<input type=\"hidden\" name=\"file_name\" value=\"" . $page['urlref'] . "\" />";
			echo "<p class=\"t14\"><b>Upload newer version of this season's LZP file: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>";
			echo "<input name=\"new_file\" type=\"file\" id=\"new_file\" size=\"50\"></p>";
			echo "<input type=\"submit\" name=\"submit\" value=\"Upload File\"><br /><br />";
		echo "</form>";
	echo "</div><br />";
} else {
	// this should not being able to happen, but if it does, display an error
	echo "<p><span class=\"red\"><b>An error has occurred!</b></span></p>";
	echo "<p><a href=\"edit_delete_download.php\">START OVER</a></p>";
}
*/









include('admin_footer.php');
?>