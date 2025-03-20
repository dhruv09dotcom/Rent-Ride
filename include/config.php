<?php
// Database configuration
$host = 'localhost';
$dbname = 'car_rent'; // Change this to your database name
$username = 'root';  // Change if using a different MySQL user
$password = ''; // Leave empty if no password

try {
    // Create a PDO connection
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>