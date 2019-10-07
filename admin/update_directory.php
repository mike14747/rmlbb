<?php
require_once('connections/conn1.php');
include('logged_in_check.php');
include('admin_header.php');

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"leftnav\">";
include('leftnav2.php');
echo "</td><td class=\"cell3\">";
// check to see if the submit button has been clicked
if (isset($_POST['submit']) && $_POST['submit'] == "Submit") {
	// begin validating form input fields
	// set master error counting variable
	$t_errors = 0;
	// test conference for blankness and formatting
	if (($_POST['conference'] == "") OR (!preg_match("/^(A|N)C$/", $_POST['conference']))) {
		$c_errors++;
		$t_errors++;
	}
	// test teamname for blankness
	if ($_POST['teamname'] == "") {
		$t_errors++;
	}
	// test non-blank email fields for formatting
	$email_format = array("email1a", "email1b", "email2a", "email2b");
	$e_errors = 0;
	foreach ($email_format as $e) {
		if (($_POST[$e] != "") AND (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$/", $_POST[$e]))) {
			$e_errors++;
			$t_errors++;
		}
	}
	if ($t_errors > 0) {
		echo "<p class=\"t16r\"><b>FAILED!</b></p>";
		echo "<p class=\"t16r\">Correct the errors and resubmit the form.</p>";
		if ($c_errors > 0) {
			echo "<p class=\"t16r\">The conference field has been left blank or is not in the correct format. It must either be AC or NC (and it is case sensitive).</p>";
		}
		if ($_POST['teamname'] == "") {
			echo "<p class=\"t16r\">The teamname field has been left blank.</p>";
		}
		if ($e_errors > 0) {
			echo "<p class=\"t16r\">One or more of the non-blank email fields is not in the correct format.</p>";
		}
		echo "<br /><p class=\"t16\"><a href=\"javascript:history.go(-1);\">back</a></p>";
	} elseif ($t_errors == 0) {
		// assign the $_POST items to a variable (including proper backslashes)
		$u_team_id = $conn1->real_escape_string($_POST['team_id']);
		$u_conference = $conn1->real_escape_string($_POST['conference']);
		$u_division_id = $conn1->real_escape_string($_POST['division_id']);
		$query_submitted_division = $conn1->query("SELECT division FROM divisions WHERE division_id=$u_division_id LIMIT 1");
		$result_submitted_division = $query_submitted_division->fetch_assoc();
		$query_submitted_division->free_result();
		$u_division = $result_submitted_division['division'];
		$u_teamname = $conn1->real_escape_string($_POST['teamname']);
		$u_description1 = $conn1->real_escape_string($_POST['description1']);
		$u_manager1 = $conn1->real_escape_string($_POST['manager1']);
		$u_address1a = $conn1->real_escape_string($_POST['address1a']);
		$u_address1b = $conn1->real_escape_string($_POST['address1b']);
		$u_city1 = $conn1->real_escape_string($_POST['city1']);
		$u_state1 = $conn1->real_escape_string($_POST['state1']);
		$u_country1 = $conn1->real_escape_string($_POST['country1']);
		$u_zip1 = $conn1->real_escape_string($_POST['zip1']);
		$u_phone1a = $conn1->real_escape_string($_POST['phone1a']);
		$u_phone1b = $conn1->real_escape_string($_POST['phone1b']);
		$u_email1a = $conn1->real_escape_string($_POST['email1a']);
		$u_email1b = $conn1->real_escape_string($_POST['email1b']);
		$u_description2 = $conn1->real_escape_string($_POST['description2']);
		$u_manager2 = $conn1->real_escape_string($_POST['manager2']);
		$u_address2a = $conn1->real_escape_string($_POST['address2a']);
		$u_address2b = $conn1->real_escape_string($_POST['address2b']);
		$u_city2 = $conn1->real_escape_string($_POST['city2']);
		$u_state2 = $conn1->real_escape_string($_POST['state2']);
		$u_country2 = $conn1->real_escape_string($_POST['country2']);
		$u_zip2 = $conn1->real_escape_string($_POST['zip2']);
		$u_phone2a = $conn1->real_escape_string($_POST['phone2a']);
		$u_phone2b = $conn1->real_escape_string($_POST['phone2b']);
		$u_email2a = $conn1->real_escape_string($_POST['email2a']);
		$u_email2b = $conn1->real_escape_string($_POST['email2b']);
		// update items in the database
		$conn1->query("UPDATE managerdir SET conference='$u_conference', division_id=$u_division_id, teamname='$u_teamname', description1='$u_description1', manager1='$u_manager1', address1a='$u_address1a', address1b='$u_address1b', city1='$u_city1', state1='$u_state1', country1='$u_country1', zip1='$u_zip1', phone1a='$u_phone1a', phone1b='$u_phone1b', email1a='$u_email1a', email1b='$u_email1b', description2='$u_description2', manager2='$u_manager2', address2a='$u_address2a', address2b='$u_address2b', city2='$u_city2', state2='$u_state2', country2='$u_country2', zip2='$u_zip2', phone2a='$u_phone2a', phone2b='$u_phone2b', email2a='$u_email2a', email2b='$u_email2b' WHERE team_id='$u_team_id'");
		// display confirmation message that the info has been updated in the database
		echo "<p class=\"t16\"><b>The Manager Directory has been updated with the following:</b></p>";
		echo "<p class=\"t14\">";
		echo "<b>team_id:</b> " . $u_team_id . "<br />";
		echo "<b>conference:</b> " . $u_conference . "<br />";
		echo "<b>conference:</b> " . $u_division . "<br />";
		echo "<b>teamname:</b> " . $u_teamname . "<br />";
		echo "<b>description1:</b> " . $u_description1 . "<br />";
		echo "<b>manager1:</b> " . $u_manager1 . "<br />";
		echo "<b>address1a:</b> " . $u_address1a . "<br />";
		echo "<b>address1b:</b> " . $u_address1b . "<br />";
		echo "<b>city1:</b> " . $u_city1 . "<br />";
		echo "<b>state1:</b> " . $u_state1 . "<br />";
		echo "<b>country1:</b> " . $u_country1 . "<br />";
		echo "<b>zip1:</b> " . $u_zip1 . "<br />";
		echo "<b>phone1a:</b> " . $u_phone1a . "<br />";
		echo "<b>phone1b:</b> " . $u_phone1b . "<br />";
		echo "<b>email1a:</b> " . $u_email1a . "<br />";
		echo "<b>email1b:</b> " . $u_email1b . "<br />";
		echo "<b>description2:</b> " . $u_description2 . "<br />";
		echo "<b>manager2:</b> " . $u_manager2 . "<br />";
		echo "<b>address2a:</b> " . $u_address2a . "<br />";
		echo "<b>address2b:</b> " . $u_address2b . "<br />";
		echo "<b>city2:</b> " . $u_city2 . "<br />";
		echo "<b>state2:</b> " . $u_state2 . "<br />";
		echo "<b>country2:</b> " . $u_country2 . "<br />";
		echo "<b>zip2:</b> " . $u_zip2 . "<br />";
		echo "<b>phone2a:</b> " . $u_phone2a . "<br />";
		echo "<b>phone2b:</b> " . $u_phone2b . "<br />";
		echo "<b>email2a:</b> " . $u_email2a . "<br />";
		echo "<b>email2b:</b> " . $u_email2b . "<br />";
		echo "</p>";
	}
} elseif ((isset($_POST['team_id'])) AND ($_POST['team_id'] != "")) {
	// display update form since a team has been selected
	// get the selected team's current info from the database
	$query_team = $conn1->query("SELECT * FROM managerdir WHERE team_id={$_POST['team_id']}");
	$result_team = $query_team->fetch_assoc();
	$query_team->free_result();
	echo "<h2>UPDATE MANAGER DIRECTORY</h2>";
	echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"team_id\" value=\"" . $result_team['team_id'] . "\" />";
		echo "<p class=\"updateitem\"><b>Team ID: </b><input type=\"text\" size=\"10\" maxlength=\"3\" disabled=\"disabled\" value=\"" . $result_team['team_id'] . "\" /><br /><span class=\"t12\">(This value cannot be modified.)</span></p>";
		echo "<p class=\"updateitem\"><b>Conference: </b>";
		echo "<select name=\"conference\">";
			if ($result_team['conference'] == "AC") {
				echo "<option value=\"AC\" selected=\"selected\">AC</option>";
				echo "<option value=\"NC\">NC</option>";
			} elseif ($result_team['conference'] == "NC") {
				echo "<option value=\"AC\">AC</option>";
				echo "<option value=\"NC\" selected=\"selected\">NC</option>";
			}
		echo "</select>";
		echo "</p>";
		echo "<p class=\"updateitem\"><b>Division: </b>";
		// find possible divisions
		$query_divisions = $conn1->query("SELECT * FROM divisions ORDER BY division_id ASC");
		echo "<select name=\"division_id\">";
			while ($result_divisions = $query_divisions->fetch_assoc()) {
				echo "<option value=\"" . $result_divisions['division_id'] . "\"";
				if ($result_divisions['division_id'] == $result_team['division_id']) {
					echo " selected=\"selected\"";
				}
				echo ">" . $result_divisions['division'] . "</option>";
			}
			$query_divisions->free_result();
		echo "</select>";
		echo "</p>";
		echo "<p class=\"updateitem\"><b>Team: </b><input type=\"text\" name=\"teamname\" size=\"50\" maxlength=\"30\" value=\"" . $result_team['teamname'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>MANAGER 1 INFO:</b></p>";
		echo "<p class=\"updateitem\"><b>Description: </b><input type=\"text\" name=\"description1\" size=\"50\" maxlength=\"255\" value=\"" . $result_team['description1'] . "\" /><br /><span class=\"t12\">(Usually leave blank unless there is more than 1 manager.)</span></p>";
		echo "<p class=\"updateitem\"><b>Manager: </b><input type=\"text\" name=\"manager1\" size=\"50\" maxlength=\"50\" value=\"" . $result_team['manager1'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Address</b> (line 1)<b>: </b><input type=\"text\" name=\"address1a\" size=\"50\" maxlength=\"80\" value=\"" . $result_team['address1a'] . "\" /><br /><b>Address</b> (line 2)<b>: </b><input type=\"text\" name=\"address1b\" size=\"50\" maxlength=\"80\" value=\"" . $result_team['address1b'] . "\" /><br /><span class=\"t12\">(Address line 2 is left blank in most cases.)</span></p>";
		echo "<p class=\"updateitem\"><b>City: </b><input type=\"text\" name=\"city1\" size=\"50\" maxlength=\"50\" value=\"" . $result_team['city1'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>State: </b><input type=\"text\" name=\"state1\" size=\"50\" maxlength=\"20\" value=\"" . $result_team['state1'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Country: </b><input type=\"text\" name=\"country1\" size=\"50\" maxlength=\"20\" value=\"" . $result_team['country1'] . "\" /><br /><span class=\"t12\">(Leave blank unless the country is something other than USA.)</span></p>";
		echo "<p class=\"updateitem\"><b>Zip Code: </b><input type=\"text\" name=\"zip1\" size=\"10\" maxlength=\"20\" value=\"" . $result_team['zip1'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Phone 1: </b><input type=\"text\" name=\"phone1a\" size=\"20\" maxlength=\"20\" value=\"" . $result_team['phone1a'] . "\" /><br /><b>Phone 2: </b><input type=\"text\" name=\"phone1b\" size=\"20\" maxlength=\"20\" value=\"" . $result_team['phone1b'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Email 1: </b><input type=\"text\" name=\"email1a\" size=\"30\" maxlength=\"80\" value=\"" . $result_team['email1a'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Email 2: </b><input type=\"text\" name=\"email1b\" size=\"30\" maxlength=\"80\" value=\"" . $result_team['email1b'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>MANAGER 2 INFO</b> (if applicable)<b>:</b></p>";
		echo "<p class=\"updateitem\"><b>Description: </b><input type=\"text\" name=\"description2\" size=\"50\" maxlength=\"255\" value=\"" . $result_team['description2'] . "\" /><br /><span class=\"t12\">(Usually leave blank unless there is a Manager 2.)</span></p>";
		echo "<p class=\"updateitem\"><b>Manager: </b><input type=\"text\" name=\"manager2\" size=\"50\" maxlength=\"50\" value=\"" . $result_team['manager2'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Address</b> (line 1)<b>: </b><input type=\"text\" name=\"address2a\" size=\"50\" maxlength=\"80\" value=\"" . $result_team['address2a'] . "\" /><br /><b>Address</b> (line 2)<b>: </b><input type=\"text\" name=\"address2b\" size=\"50\" maxlength=\"80\" value=\"" . $result_team['address2b'] . "\" /><br /><span class=\"t12\">(Address line 2 is left blank in most cases.)</span></p>";
		echo "<p class=\"updateitem\"><b>City: </b><input type=\"text\" name=\"city2\" size=\"50\" maxlength=\"50\" value=\"" . $result_team['city2'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>State: </b><input type=\"text\" name=\"state2\" size=\"50\" maxlength=\"20\" value=\"" . $result_team['state2'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Country: </b><input type=\"text\" name=\"country2\" size=\"50\" maxlength=\"20\" value=\"" . $result_team['country2'] . "\" /><br /><span class=\"t12\">(Leave blank unless the country is something other than USA.)</span></p>";
		echo "<p class=\"updateitem\"><b>Zip Code: </b><input type=\"text\" name=\"zip2\" size=\"10\" maxlength=\"20\" value=\"" . $result_team['zip2'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Phone 1: </b><input type=\"text\" name=\"phone2a\" size=\"20\" maxlength=\"20\" value=\"" . $result_team['phone2a'] . "\" /><br /><b>Phone 2: </b><input type=\"text\" name=\"phone2b\" size=\"20\" maxlength=\"20\" value=\"" . $result_team['phone2b'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Email 1: </b><input type=\"text\" name=\"email2a\" size=\"30\" maxlength=\"80\" value=\"" . $result_team['email2a'] . "\" /></p>";
		echo "<p class=\"updateitem\"><b>Email 2: </b><input type=\"text\" name=\"email2b\" size=\"30\" maxlength=\"80\" value=\"" . $result_team['email2b'] . "\" /></p>";
		echo "<p class=\"updateitem\">Click submit to update the Manager Directory with the info provided: <input type=\"submit\" name=\"submit\" value=\"Submit\" /></p>";
	echo "</form>";
} elseif ((!isset($_POST['team_id'])) OR ($_POST['team_id'] == "")) {

	echo "<h2>UPDATE MANAGER DIRECTORY</h2>";

	echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
	echo "<p class=\"updateitem\">Select a team to <b>EDIT</b>, then click 'Select Team': ";
	echo "<select name=\"team_id\">";
	echo "<option value=\"\" selected=\"selected\">Select a Team</option>";

	$query_teamnames = $conn1->query("SELECT team_id, teamname FROM managerdir ORDER BY teamname ASC");
	while ($result_teamnames = $query_teamnames->fetch_assoc()) {
		echo "<option value=\"" . $result_teamnames['team_id'] . "\">" . $result_teamnames['teamname'] . "</option>";
	}
	$query_teamnames->free_result();
	echo "</select> <input type=\"submit\" value=\"Select Team\"\" /></p>";
}

include('admin_footer.php');
?>