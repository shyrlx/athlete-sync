<?php
// db_config.php

$host = '127.0.0.1'; 
$dbname = 'athlete_sync';
$db_user = 'root';
$db_pass = ''; 

$conn = new mysqli($host, $db_user, $db_pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
