<?php
$db_host = "localhost"; // Replace with your MySQL server host in docker compose
$db_username = "erfan"; // Replace with your MySQL username
$db_password = "1234"; // Replace with your MySQL password
$db_database = "testdb"; // Replace with the name of your MySQL database

// Create a connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_database);

// Check the connection
if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully";
?>