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
        <!-- Include Header -->
        <?php include 'include/header.php'; ?>

        <!-- Include Navigation Bar -->
        <?php include 'include/navigation.php'; ?>

        <!-- Forgot Password Section -->
        <section class="forgot-password">
            <div class="forgot-container">
                <h2>Forgot Password</h2>
                <p>Enter your registered email to reset your password.</p>
                <form action="forgot-password.php" method="POST">
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Enter new password" required />
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Conform new password" required />
                    </div>
                    <button type="submit" class="btn-reset">Reset Password</button>
                </form>
                <p class="back-to-login"><a href="login.php">Back to Login</a></p>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>