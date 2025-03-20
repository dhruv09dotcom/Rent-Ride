<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch Counts from Database using PDO
$users_count = $pdo->query("SELECT COUNT(*) AS total FROM users")->fetch(PDO::FETCH_ASSOC)['total'];
$vehicles_count = $pdo->query("SELECT COUNT(*) AS total FROM vehicles")->fetch(PDO::FETCH_ASSOC)['total'];
$brands_count = $pdo->query("SELECT COUNT(*) AS total FROM brands")->fetch(PDO::FETCH_ASSOC)['total'];
$bookings_count = $pdo->query("SELECT COUNT(*) AS total FROM bookings")->fetch(PDO::FETCH_ASSOC)['total'];
$queries_count = $pdo->query("SELECT COUNT(*) AS total FROM contact_queries")->fetch(PDO::FETCH_ASSOC)['total'];
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

        <!-- Dashboard Content -->
        <div class="dashboard">
            <h2>Dashboard</h2>
            <div class="dashboard-cards">
                <div class="card blue">
                    <h3><?php echo $users_count; ?></h3>
                    <p>REG USERS</p>
                    <a href="registered-users.php">FULL DETAIL →</a>
                </div>
                <div class="card green">
                    <h3><?php echo $vehicles_count; ?></h3>
                    <p>LISTED VEHICLES</p>
                    <a href="manage-vehicle.php">FULL DETAIL →</a>
                </div>
                <div class="card orange">
                    <h3><?php echo $brands_count; ?></h3>
                    <p>LISTED BRANDS</p>
                    <a href="manage-brand.php">FULL DETAIL →</a>
                </div>
                <div class="card green">
                    <h3><?php echo $bookings_count; ?></h3>
                    <p>TOTAL BOOKINGS</p>
                    <a href="total-booking.php">FULL DETAIL →</a>
                </div>
                <div class="card blue">
                    <h3><?php echo $queries_count; ?></h3>
                    <p>QUERIES</p>
                    <a href="manage-contact-us.php">FULL DETAIL →</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>