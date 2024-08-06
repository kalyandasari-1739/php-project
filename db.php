<?php
$host = "localhost"; // Host name
$dbUsername = "root"; // Mysql username
$dbPassword = ""; // Mysql password
$dbName = "login_system"; // Database name

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
