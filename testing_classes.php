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
echo $download->fileDesc . '<br />' . $download->fileName;

include('components/footer/footer.php');
