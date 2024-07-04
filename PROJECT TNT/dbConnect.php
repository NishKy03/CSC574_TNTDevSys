<?php
// Define database constants if not already defined
if (!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost');
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'courierdb');
}

// Attempt to connect to MySQL database
$dbCon = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($dbCon->connect_errno) {
    die("Connection failed: " . $dbCon->connect_error);
}
?>
