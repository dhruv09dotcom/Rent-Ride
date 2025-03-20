<?php
// Start session only if it's not already started
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
        <script src="script.js"></script>
    </head>
    <body>
        <!-- Header Section -->
        <header>
            <div class="header-container">
                <div class="logo">
                    <a href="index.php">
                        <img src="Image/Rent Ride.png" class="logo-img">
                    </a>
                </div>
                <div class="contact-info">
                    <div class="circle_icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <p>For Support Mail us: <br> <span><a href="mailto:support@rentride.com" class="A">info@rentride.com</a></span></p>
                    <div class="circle_icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <p>Service Helpline: <br> <span><a href="tel:+919876543210" class="A">+91 98765 43210</a></span></p>
                </div>
                <div class="btn-login">
                    <?php if (isset($_SESSION['id'])): ?>
                        <p>Hello User !</p>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
    </body>
</html>