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
        <nav class="navbar">
            <a href="dashboard.php">
                <h1>Car Rental System | Admin Panel</h1>
            </a>
            <div class="user-menu" id="userMenu">
                <div class="user-icon"><i class="fas fa-user-circle"></i></div>
                <div class="user-name">
                    <?php 
                        echo isset($_SESSION['admin']) ? htmlspecialchars($_SESSION['admin']) : 'Admin'; 
                    ?>
                </div>
                <div class="user-arrow"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="dropdown-content" id="dropdownMenu">
                <a href="update-pwd.php">UPDATE PASSWORD</a>
                <a href="logout.php">LOG OUT</a>
            </div>
        </nav>
    </body>
</html>