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
        <div class="au-container">
            <div class="au-overlay">
                <h1>About Us</h1>
                <nav>
                    <a href="index.html">Home</a> >
                    <a href="about-us.html">About Us</a>
                </nav>
            </div>
            <img src="Image/about-us-banner.jpg" alt="About-Us Background" class="au-img">
        </div>

        <!-- About-Us Section -->
        <main>
            <section class="about-section">
    
                <!-- About Us -->
                <div class="about-container">
                    <div class="text-content">
                        <h1>About Rent Ride</h1>
                        <p>Rent Ride is a trusted car rental service that provides a seamless and hassle-free experience for customers looking for quality vehicles at affordable rates.</p>
                    </div>
                    <div class="image-container">
                        <img src="Image\about-image.jpg" alt="Car Rental">
                    </div>
                </div>
    
                <!-- Our Mission -->
                <div class="mission-container">
                    <div class="text-content">
                        <h2>Our Mission</h2>
                        <p>Our mission is to make car rental easy, convenient, and cost-effective while offering a wide range of well-maintained vehicles.</p>
                    </div>
                    <div class="image-container">
                        <img src="Image\mission-image.jpg" alt="Mission">
                    </div>
                </div>
    
                <!-- Why Choose Us -->
                <div class="why-choose-container">
                    <div class="text-content">
                        <h2>Why Choose Us?</h2>
                        <ul class="why-choose-list">
                            <li>Affordable Pricing</li>
                            <li>Wide Selection of Cars</li>
                            <li>24/7 Customer Support</li>
                            <li>Easy Online Booking</li>
                            <li>Reliable & Well-Maintained Vehicles</li>
                        </ul>
                    </div>
                    <div class="image-container">
                        <img src="Image\choose-us-image.jpg" alt="Why Choose Us">
                    </div>
                </div>
            </section>
        </main>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>