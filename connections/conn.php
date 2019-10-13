<?php
require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__, '../.env');
$dotenv->load();
$dotenv->required(['DB_HOSTNAME', 'DB_USERNAME', 'DB_PASSWORD', 'DB_DATABASE']);

$hostname_conn = getenv('DB_HOSTNAME');
$username_conn = getenv('DB_USERNAME');
$password_conn = getenv('DB_PASSWORD');
$database_conn = getenv('DB_DATABASE');

$conn = new mysqli($hostname_conn, $username_conn, $password_conn, $database_conn);
// check connection
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

// sanitize all user input and save their values to variables
if (isset($_GET['view'])) {
    $get_view = $conn->real_escape_string($_GET['view']);
}
if (isset($_GET['page'])) {
    $get_page = $conn->real_escape_string($_GET['page']);
}
if (isset($_GET['show'])) {
    $get_show = $conn->real_escape_string($_GET['show']);
}
if (isset($_GET['sort'])) {
    $get_sort = $conn->real_escape_string($_GET['sort']);
}
if (isset($_GET['ind_team'])) {
    $get_ind_team = $conn->real_escape_string($_GET['ind_team']);
}
