<?php
require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__, '../.env');
$dotenv->load();
$dotenv->required(['DB_HOSTNAME', 'DB_USERNAME', 'DB_PASSWORD', 'DB_DATABASE']);

$hostname_conn2 = getenv('DB_HOSTNAME2');
$username_conn2 = getenv('DB_USERNAME2');
$password_conn2 = getenv('DB_PASSWORD2');
$database_conn2 = getenv('DB_DATABASE2');

$conn2 = new mysqli($hostname_conn2, $username_conn2, $password_conn2, $database_conn2);
// check connection
if ($conn2->connect_error) {
    die('Connect Error (' . $conn2->connect_errno . ') ' . $conn2->connect_error);
}
