<?php
// Database connection settings
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'majdool';

// Attempt to connect to the database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to the database successfully!";
}

$conn->close();
?>
