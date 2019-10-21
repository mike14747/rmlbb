<?php
require_once('connections/conn.php');
include('logged_in_check.php');
include('components/header/header.php');
include('components/navBar/navBar.php');
include_once('includes/autoloader.inc.php');
?>

<h2>Testing Classes</h2>

<?php
$download = new Download('RML Master Roster', 'RML_Master_Roster.xlsx');
echo '<p>';
echo $download->fileDesc . '<br />' . $download->fileName;
echo '</p>';


$test_string = ";lakjsdgfklslj\n\r<p>1'or'1'='1";
$sanitized_string = $conn->real_escape_string($test_string);
echo '<p>';
echo $test_string;
echo $sanitized_string;
echo '</p>';

include('components/footer/footer.php');
