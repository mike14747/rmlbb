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
		if ($file_name != "hitter_usage.csv") {
			$errStr .= "File is not valid. Only the template file for hitter usage can be uploaded.<br />";
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
include ("leftnav2.php");
echo "</td><td class=\"cell3\">";
echo "<h2>UPLOAD CURRENT SEASON HITTER USAGE</h2>";
if (isset($_POST['submit']) && $_POST['submit'] == "Upload File") {
	if (!empty($errStr)) {
		echo "<p class=\"t16\"><span class=\"red\"><b>ERROR!<br /></b>" . $errStr . "</span></p>";
	} elseif (empty($errStr)) {
		if (copy($tmp_file_name,DESTINATION_FOLDER . "/" . $file_name)) {
				$conn1->query("DELETE FROM hitter_usage");
				$separator = ",";
				$handle = fopen ("../uploaded/".$file_name,"r");
				while ($data = fgetcsv ($handle, 10000, $separator)) {
					if($data[0]=="Hitter Name" || $data[0]=="") {
						continue;
					}
					$data1 = $conn1->real_escape_string(trim($data[0])); // hitter_name
					$data2 = $conn1->real_escape_string(trim($data[1])); // rml_team
					$data3 = $data[2]; // ops
					$data4 = $data[3]; // mlb_ab
					$data5 = $conn1->real_escape_string(trim($data[4])); // full
					$data6 = $conn1->real_escape_string(trim($data[5])); // unl
					$data7 = $data[6]; // rml_ab
					if ($data7 == "") {
						$data7 = 0;
					}
					$conn1->query("INSERT INTO hitter_usage VALUES ('$data1', '$data2', $data3, $data4, '$data5', '$data6', $data7)");
				}
				fclose ($handle);
			if (file_exists("../uploaded/hitter_usage.csv")) {
				unlink("../uploaded/hitter_usage.csv");
			}
		}
		echo "<p class=\"t16\"><span class=\"blue\">You've successfully uploaded the hitter usage on the website via the .csv file.</span></p>";
	}
}
if ((isset($_POST['submit']) && $_POST['submit'] == "Upload File" && !empty($errStr)) || (!isset($_POST['submit']))) {
	echo "<p class=\"t14r\"><b>Keep these things in mind when trying to upload Hitter Usage:</b></p>";
	echo "<span class=\"t14r\">";
	echo "<ul>";
	echo "<li>The only files allowed for upload are .csv files.</li>";
	echo "<li>You must use the template and it must be in the original column format (with 'Hitter Name' in the first cell of the first row).</li>";
	echo "<li>This process will delete the entire current hitter usage table and replace it with the current hitter usage in the uploaded file.</li>";
	echo "</ul>";
	echo "</span><br />";

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