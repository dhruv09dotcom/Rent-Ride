<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'include/config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // Use PDO's prepared statement to prevent SQL injection
        $stmt = $dbh->prepare("SELECT id, first_name, email FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]); // Bind parameters
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) { // If user exists
            $_SESSION['id'] = $user['id']; // Store User ID
            $_SESSION['email'] = $user['email']; // Store email
            $_SESSION['first_name'] = $user['first_name']; // Store first name

            echo "<script>
                alert('Login successful!');
                window.location.href = 'index.php';
            </script>";
            exit();
        } else {
            echo "<script>alert('Invalid email or password!');</script>";
        }
    } else {
        echo "<script>alert('Please enter email and password!');</script>";
    }
}

// No need to close connection explicitly in PDO
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
        <!-- Include Header -->
        <?php include 'include/header.php'; ?>

        <!-- Include Navigation Bar -->
        <?php include 'include/navigation.php'; ?>

        <!-- Login Section -->
        <section class="login-section">
            <div class="login_form">
                <form action="login.php" method="POST">
                    <h3>Log in with</h3>
                    <div class="login_option">
                        <div class="option"><a href="#"><i class="fa-brands fa-google"></i></a></div>
                        <div class="option"><a href="#"><i class="fa-brands fa-facebook"></i></a></div>
                    </div>
                    <p class="separator"><span>or</span></p>
                    <div class="input_box">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" required />
                    </div>
                    <div class="input_box">
                        <div class="password_title">
                            <label for="password">Password</label>
                            <a href="forgot-pwd.php">Forgot Password?</a>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required />
                    </div>
                    <button type="submit">Log In</button>
                    <p class="sign_up">Don't have an account? <a href="register.php">Sign up</a></p>
                </form>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>