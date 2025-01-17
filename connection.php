<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Uncomment the line below to verify the connection
// echo "Connected successfully";
?>