<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    </head>
    <body>
        <!-- Include Header -->
        <?php include 'include/header.php'; ?>

        <!-- Include Navigation Bar -->
        <?php include 'include/navigation.php'; ?>

        <!-- Banner Section (Background Image) -->
        <div class="cl-container">
            <div class="cl-overlay">
                <h1>Car Listing</h1>
                <nav>
                    <a href="index.php">Home</a> >
                    <a href="car-listing.php">Car Listing</a>
                </nav>
            </div>
            <img src="Image/car-listing-banner.jpg" alt="Car Listing Background" class="cl-img">
        </div>

        <!-- Include Listed Car -->
        <?php include 'include/listed-car.php'; ?>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>