<?php
$dbuser = "root";
$dbpass = "";
$host = "localhost";
$db = "kplc_db";

$mysqliObj = new mysqli($host, $dbuser, $dbpass, $db);

if ($mysqliObj->connect_error) {
    throw new Exception("Failed to connect to MySQL: " . $mysqliObj->connect_error);
}
// echo "Database connection established successfully!";
