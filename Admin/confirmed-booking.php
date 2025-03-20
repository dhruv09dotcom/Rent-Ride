<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connection.php"; // Include database connection file

try {
    // Fetch only confirmed bookings
    $sql = "SELECT b.booking_number, b.from_date, b.to_date, 
                   b.status, b.created_at AS posting_date, 
                   v.vehicle_title AS vehicle, 
                   u.first_name AS name
            FROM bookings b
            JOIN vehicles v ON b.vehicle_id = v.id
            JOIN users u ON b.user_id = u.id
            WHERE LOWER(b.status) = 'confirmed'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error occurred.");
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
    </head>
    <body>
        <!-- Include Navigation Bar -->
            <?php include 'include/navbar.php'; ?>

        <div class="main-container">
            <!-- Include Sidebar -->
                <?php include 'include/sidebar.php'; ?>

            <!-- Confirmed Booking Section -->
            <div class="new-booking-content">
                <h2>Confirmed Bookings</h2>
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
                        if (!empty($bookings)) {
                            $sr_no = 1;
                            foreach ($bookings as $row) {
                                echo "<tr>";
                                echo "<td>" . $sr_no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['booking_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['vehicle']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['from_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['to_date']) . "</td>";
                                echo "<td style='color: green; font-weight: bold;'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['posting_date']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align: center;'>No confirmed bookings found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </body>
</html>