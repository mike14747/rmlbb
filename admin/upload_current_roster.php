<?php
require_once('connections/conn1.php');
include('logged_in_check.php');

if (isset($_POST['submit']) && $_POST['submit'] == "Upload File") {
	$errStr = "";
	set_time_limit(0);
	define("DESTINATION_FOLDER", "../uploaded");
	$uploaded_file = $_FILES['csv_file'];
	$file_name = $uploaded_file['name'];
	$tmp_file_name = $uploaded_file['tmp_name'];
	// do error checking on the file being uploaded
	if ($_FILES['csv_file']['size'] == 0) {
		$errStr .= "No file was selected for upload.<br />";
	} elseif ($_FILES['csv_file']['size'] > 0) {
		if ($file_name != "current_roster.csv") {
			$errStr .= "File is not valid. Only the template file for the current roster can be uploaded.<br />";
		}
		if ((!is_uploaded_file($uploaded_file['tmp_name'])) || ($uploaded_file['error'] != 0)) {
			$errStr .= "There was an error uploading the file.<br />";
		}
	}
	if (!is_dir(DESTINATION_FOLDER) || !is_writeable(DESTINATION_FOLDER)) {
		$errStr .= "Destination folder is either not present or is not writeable.<br />";
	}
}

include('admin_header.php');

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"leftnav\">";
include('leftnav2.php');
echo "</td><td class=\"cell3\">";
echo "<h2>UPLOAD CURRENT ROSTER</h2>";
if (isset($_POST['submit']) && $_POST['submit'] == "Upload File") {
	if (!empty($errStr)) {
		echo "<p class=\"t16\"><span class=\"red\"><b>ERROR!<br /></b>" . $errStr . "</span></p>";
	} elseif (empty($errStr)) {
		if (copy($tmp_file_name,DESTINATION_FOLDER . "/" . $file_name)) {
			$conn1->query("DELETE FROM cur_roster");
			$separator = ",";
			$handle = fopen ("../uploaded/".$file_name,"r");
			while ($data = fgetcsv ($handle, 10000, $separator)) {
				if($data[0]=="Player" || $data[0]=="") {
					continue;
				}
				$data1 = $conn1->real_escape_string(trim($data[0])); // player_name
				$data2 = $conn1->real_escape_string(trim($data[1])); // rml_team
				$data3 = $conn1->real_escape_string(trim($data[2])); // exp
				if ($data3 == "M") {
					$data3 = 0;
				}
				$data4 = $conn1->real_escape_string(trim($data[3])); // salary
				if ($data4 == "") {
					$data4 = 0;
				}
				$data5 = $conn1->real_escape_string(trim($data[4])); // y
				$data6 = $conn1->real_escape_string(trim($data[5])); // c
				$data7 = $conn1->real_escape_string(trim($data[6])); // real_team
				$data8 = $conn1->real_escape_string(trim($data[7])); // b_t
				$data9 = $conn1->real_escape_string(trim($data[8])); // dob
				$data10 = $conn1->real_escape_string(trim($data[9])); // pos
				$conn1->query("INSERT INTO cur_roster VALUES ('$data1', '$data2', $data3, $data4, '$data5', '$data6', '$data7', '$data8', '$data9', '$data10')");
			}
			fclose ($handle);
			if (file_exists("../uploaded/current_roster.csv")) {
				unlink("../uploaded/current_roster.csv");
			}
		}
		echo "<p class=\"t16\"><span class=\"blue\">You've successfully uploaded the current roster on the website via the .csv file.</span></p>";
	}
}
if ((isset($_POST['submit']) && $_POST['submit'] == "Upload File" && !empty($errStr)) || (!isset($_POST['submit']))) {
	echo "<div class=\"t14r\"><b>Keep these things in mind when trying to upload the Current Roster:</b></div>";
	echo "<div class=\"t14r\">";
	echo "<ul>";
	echo "<li>The only files allowed for upload are .csv files.</li>";
	echo "<li>You must use the template and it must be in the original column format (with 'Player' in the first cell of the first row).</li>";
	echo "<li>This process will delete the entire current roster table and replace it with the current roster in the uploaded file.</li>";
	echo "</ul>";
	echo "</div><br />";

	echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">";
		echo "<p class=\"t14\"><b>Upload .csv File: </b>";
		echo "<input name=\"csv_file\" type=\"file\" id=\"csv_file\" size=\"50\"></p>";
		echo "<input type=\"submit\" name=\"submit\" value=\"Upload File\">";
		echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<input type=\"reset\" name=\"Reset\" value=\"Reset\">";
	echo "</form>";
}

include('admin_footer.php');
?>