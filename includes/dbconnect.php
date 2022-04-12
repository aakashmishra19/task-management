<?php
error_reporting(E_ALL ^ E_DEPRECATED);
date_default_timezone_set("Asia/Kolkata");
$date = date('d/m/Y');

$timestamp = time();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include "session.php";


?>
