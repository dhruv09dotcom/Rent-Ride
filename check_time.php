<?php
include 'include/config.php'; // Include your database connection

// Check PHP timezone
echo "🕒 PHP Time: " . date("Y-m-d H:i:s") . "<br>";

// Check MySQL timezone
$stmt = $dbh->query("SELECT NOW() as mysql_time");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "🕒 MySQL Time: " . $row['mysql_time'];
?>