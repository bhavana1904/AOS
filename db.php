<?php
$servername = "localhost";
$username = "root"; // Correct username
$password = "Bhavana@1234"; // Correct password
$dbname = "nas_server_db";  // Correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
