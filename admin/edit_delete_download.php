<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('admin_header.php');

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"leftnav\">";
include('leftnav2.php');
echo "</td><td class=\"cell3\">";
echo "<h2>EDIT (or delete) AN EXISTING DOWLOAD</h2>";
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
					$conn1->query("UPDATE downloads SET file_name='$new_file_name' WHERE download_id={$_POST['download_id']}");
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
		if (isset($_POST['download_id']) && isset($_POST['description']) && isset($_POST['display'])) {
			// make sure the description wasn't left blank
			if ($_POST['description'] == "") {
				echo "<p class=\"t16\"><span class=\"red\">The description for this download was left blank, <a href=\"edit_delete_download.php\"><b>please try again</b></a>!</span></p>";
			} else {
				// make the changes in the database
				$conn1->query("UPDATE downloads SET description='{$_POST['description']}', display={$_POST['display']} WHERE download_id={$_POST['download_id']}");
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
		$conn1->query("DELETE FROM downloads WHERE download_id={$_POST['download_id']}");
		$target_dir = "../downloads/";
		unlink($target_dir . $_POST['file_name']);
		echo "The requested download has been removed from the dropdown list and the file associated with it has been deleted.";
	}
} elseif (isset($_GET['download_id'])) {
	// user has selected a download to edit or delete
	$query_download = $conn1->query("SELECT * FROM downloads WHERE download_id={$_GET['download_id']} LIMIT 1");
	$result_download = $query_download->fetch_assoc();
	$query_download->free_result();
	echo "<div class=\"updateitem\"><b>Edit the properties of this download:</b><br /><br />";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $result_download['download_id'] . "\" />";
			echo "<b>Description</b> (name that shows up in the navigation bar and on the downloads page... max length is 40 characters):<br /><input type=\"text\" name=\"description\" value=\"" . $result_download['description'] . "\"  size=\"40\" maxlength=\"40\" /><br /><br />";
			echo "<b>Display (enable) this page</b> (this includes displaying it on both the navigation bar and the downloads page... selecting 'No' will not delete the download, just disable it until it's re-enabled):<br />";
			echo "Yes <input type=\"radio\" name=\"display\" value=\"1\"";
			if ($result_download['display'] == 1) {
				echo "checked";
			}
			echo " /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "No <input type=\"radio\" name=\"display\" value=\"0\"";
			if ($result_download['display'] == 0) {
				echo "checked";
			}
			echo " /><br /><br />";
			echo "<input type=\"submit\" name=\"submit\" value=\"Submit Changes\" /><br /><br />";
		echo "</form>";
	echo "</div><br />";
	echo "<div class=\"updateitem\"><b>Upload a newer version of the file to be downloaded:</b><br /><br />";
		echo "The current file associated with this download is: <b>" . $result_download['file_name'] . "</b><br /><br />";
		echo "The file you upload doesn't have to have the same name as the existing file, but if the name is different, the existing file will be permanently deleted from the server. If you upload a file with the same name, it will overwrite the existing file. Either way, the existing file will be gone and the new file you're uploading will become associated with this download.";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $result_download['download_id'] . "\" />";
			echo "<input type=\"hidden\" name=\"file_name\" value=\"" . $result_download['file_name'] . "\" />";
			echo "<p class=\"t14\"><b>Upload newer version of this download file: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>";
			echo "<input name=\"new_file\" type=\"file\" id=\"new_file\" size=\"50\"></p>";
			echo "<input type=\"submit\" name=\"submit\" value=\"Upload File\"><br /><br />";
		echo "</form>";
	echo "</div><br />";
	echo "<div class=\"updateitem\"><b>Permanently delete this download:</b><br /><br />(this will remove all traces of this download from the website... it will no longer appear in the navigation pane, nor on the downloads page... the file will also be deleted from the server):<br /><br />";
		echo "Note: you will be prompted to confirm the deletion of this file... just clicking the delete button alone won't do it.<br /><br />";
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"download_id\" value=\"" . $result_download['download_id'] . "\" />";
			echo "<input type=\"hidden\" name=\"description\" value=\"" . $result_download['description'] . "\" />";
			echo "<input type=\"hidden\" name=\"file_name\" value=\"" . $result_download['file_name'] . "\" />";
			echo "<input type=\"submit\" name=\"delete\" value=\"Delete Download\" /><br /><br />";
		echo "</form>";
	echo "</div><br />";
} elseif (!isset($_POST['submit']) && !isset($_POST['delete']) && !isset($_GET['download_id'])) {
	// no submit or delete button has been clicked, so load the entry page
	echo "<div class=\"updateitem\">Click on a download to do any of the following to it:<br />";
	echo "<ol>";
		echo "<li>edit the download's properties... including the display name for it on the website</li>";
		echo "<li>upload a newer version of the file to be downloaded</li>";
		echo "<li>permanently delete the download</li>";
	echo "</ol>";
	echo "</div><br />";
	$query_downloads = $conn1->query("SELECT * FROM downloads ORDER BY description ASC");
	while ($result_downloads = $query_downloads->fetch_assoc()) {
		echo "<p class=\"updateitem\"><a href=\"edit_delete_download.php?download_id=" . $result_downloads['download_id'] . "\">" . $result_downloads['description'] . "</a> &nbsp;&nbsp;(" . $result_downloads['file_name'] . ")<br /><br /></p>";
	}
	$query_downloads->free_result();
} else {
	// this should not being able to happen, but if it does, display an error
	echo "<p><span class=\"red\"><b>An error has occurred!</b></span></p>";
	echo "<p><a href=\"edit_delete_download.php\">START OVER</a></p>";
}

include('admin_footer.php');
?>