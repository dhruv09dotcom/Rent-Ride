<?php
// Step 1: Start Session & Include Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php'; // Ensure this file initializes $pdo

try {
    // Fetch bookings data using PDO
    $sql = "SELECT 
                b.id AS booking_id, 
                u.first_name AS user_name, 
                b.booking_number, 
                v.vehicle_title AS vehicle_name, 
                b.from_date, 
                b.to_date, 
                b.status, 
                b.created_at 
            FROM bookings b
            JOIN users u ON b.email = u.email
            JOIN vehicles v ON b.vehicle_id = v.id
            ORDER BY b.created_at";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Rental System | Admin Dashboard</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="script.js"></script>
        <style>
            .status-pending {
                color: red;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <!-- Include Navigation Bar -->
        <?php include 'include/navbar.php'; ?>

        <div class="main-container">
            <!-- Include Sidebar -->
            <?php include 'include/sidebar.php'; ?>

            <!-- New Booking Section -->
            <div class="new-booking-content">
                <h2>Total Bookings</h2>
                <div class="new-booking-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Booking No.</th>
                                <th>Vehicle</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Status</th>
                                <th>Posting Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($bookings as $row) {
                                // Fetch status from the database and make it bold & red
                                $status_text = ucfirst($row['status']); // Capitalize first letter
                                $status_link = "<a href='booking-details.php?id={$row['booking_id']}' style='color: red; font-weight: bold; text-decoration: none;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"none\"'>{$status_text}</a>";
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$row['user_name']}</td>
                                        <td>{$row['booking_number']}</td>
                                        <td>{$row['vehicle_name']}</td>
                                        <td>{$row['from_date']}</td>
                                        <td>{$row['to_date']}</td>
                                        <td>{$status_link}</td>
                                        <td>{$row['created_at']}</td>
                                    </tr>";
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>