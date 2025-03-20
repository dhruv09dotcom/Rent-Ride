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
        <div class="bg-container">
            <div class="bg-overlay">
                <main>
                    <section>
                        <div class="Word">
                            <h2>Welcome to Rent Ride
                                <span> Your Trusted Car Rental Service </span>
                            </h2>
                        </div>
                    </section>
                </main>
            </div>
            <img src="Image\index-banner.jpg" alt="Index Page Background" class="bg-img">
        </div>

        <!-- Paragraph Section -->
        <main>
            <section class="paragraph">
                <div class="content-box">
                    <!-- Heading -->
                    <h2>Find the Best <span>Car For You</span></h2>

                    <!-- Paragraph -->
                    <p>
                        Looking for a hassle-free and affordable car rental? <span>Rent Ride</span> has got you covered!  
                        We offer a diverse fleet of Petrol, Diesel, CNG, and Electric cars to suit your travel needs.  
                        Whether you're planning a weekend getaway, a business trip, or a daily commute,  
                        we provide well-maintained vehicles at unbeatable prices.  
                        Enjoy a smooth booking process, flexible rental plans, and top-notch customer support.  
                        Choose <span>Rent Ride</span> today and experience the freedom of driving your way! 🚗💨
                    </p>

                    <!-- Button -->
                    <a href="car-listing.php" class="btn-primary">Book Now</a>
                </div>
            </section>
        </main>

        <!-- Include Explore Car -->
        <?php include 'include/explore-car.php'; ?>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>