<?php
// Database configuration
$servername = "localhost";  // Your database server (usually localhost)
$username = "root";         // Your database username
$password = "";             // Your database password (leave blank for default)
$dbname = "shopmaster";     // Database name (create it in MySQL)

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
