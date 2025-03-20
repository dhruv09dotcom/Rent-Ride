<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle"><i class="fas fa-tags"></i> Brand <i class="fas fa-chevron-down dropdown-icon"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="create-brand.php"><i class="fas fa-plus-circle"></i> Create Brand</a></li>
                        <li><a href="manage-brand.php"><i class="fas fa-edit"></i> Manage Brand</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle"><i class="fas fa-car"></i> Vehicles <i class="fas fa-chevron-down dropdown-icon"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="add-vehicle.php"><i class="fas fa-plus-square"></i> Post a Vehicle</a></li>
                        <li><a href="manage-vehicle.php"><i class="fas fa-tasks"></i> Manage Vehicle</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle"><i class="fas fa-book"></i> Bookings <i class="fas fa-chevron-down dropdown-icon"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="total-booking.php"><i class="fa-solid fa-cart-shopping"></i> Total Booking</a></li>
                        <li><a href="confirmed-booking.php"><i class="fas fa-check-circle"></i> Confirmed Booking</a></li>
                        <li><a href="cancelled-booking.php"><i class="fas fa-times-circle"></i> Cancelled Booking</a></li>
                    </ul>
                </li>
                <li><a href="registered-users.php"><i class="fas fa-users"></i> Registered Users</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle"><i class="fa-solid fa-address-book"></i> Contact-Us <i class="fas fa-chevron-down dropdown-icon"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="update-contact-info.php"><i class="fas fa-envelope"></i> Update Contact Info.</a></li>
                        <li><a href="manage-contact-us.php"><i class="fas fa-address-card"></i> Manage Contact Queries</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </body>
</html>