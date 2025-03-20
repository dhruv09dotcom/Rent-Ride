<?php
// Start session and connect to database
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'include/config.php'; // This includes the PDO connection as $dbh

// Fetch contact details from contact_info table using PDO
$sql = "SELECT * FROM contact_info WHERE id = 1"; // Assuming single record
$stmt = $dbh->prepare($sql);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Rent Ride: Your trusted car rental service. Explore our wide range of vehicles for rent at affordable prices.">
        <title>Car Rental System | Rent Ride</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="script.js"></script>
    </head>
    <body>
        <!-- Footer Section -->
        <footer>
            <div class="container">
            <div class="footer-content">
                <h3>Contact Us</h3>
                <p>Email: <a href="mailto:<?php echo htmlspecialchars($contact['email'] ?? 'N/A'); ?>">
                    <?php echo htmlspecialchars($contact['email'] ?? 'N/A'); ?></a>
                </p>
                <p>Phone: <a href="tel:<?php echo htmlspecialchars($contact['contact_number'] ?? 'N/A'); ?>">
                    <?php echo htmlspecialchars($contact['contact_number'] ?? 'N/A'); ?></a>
                </p>
                <p>Address: <?php echo htmlspecialchars($contact['address'] ?? 'N/A'); ?></p>
            </div>
                <div class="footer-content">
                    <h3>Follow Us</h3>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="bottom-bar">
                <p>&copy; 2025 <a href="admin/Login.php">Rent Ride</a>. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>