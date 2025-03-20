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
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-container">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="car-listing.php">Car Listing</a></li>
                    <li><a href="contact-us.php">Contact Us</a></li>
                    <li><a href="about-us.php">About Us</a></li>
                </ul>
                <div class="nav-right">
                    <?php if (isset($_SESSION['id'])): ?>
                        <div class="user-menu" id="userMenu">
                            <div class="user-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="user-name"><?= isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'User'; ?></div>
                            <div class="user-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="dropdown-content" id="dropdownMenu">
                            <a href="profile.php">PROFILE SETTINGS</a>
                            <a href="contact-queries.php">CONTACT QUERIES</a>
                            <a href="my-bookings.php">MY BOOKING</a>
                            <a href="update-pwd.php">UPDATE PASSWORD</a>
                            <a href="logout.php">LOGOUT</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            let userMenu = document.getElementById("userMenu");
            let dropdownMenu = document.getElementById("dropdownMenu");

            if (userMenu && dropdownMenu) {
                userMenu.addEventListener("click", function (event) {
                    event.stopPropagation();
                    dropdownMenu.classList.toggle("show"); 
                });

                document.addEventListener("click", function (event) {
                    if (!userMenu.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.remove("show");
                    }
                });
            }
        });
        </script>
    </body>
</html>