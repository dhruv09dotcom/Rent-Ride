<?php
include 'include/config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // Validate token
        $stmt = $dbh->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expiry >= NOW()");
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $new_password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);

                if ($new_password === $confirm_password) {
                    // Update password in database and remove token
                    $updateStmt = $dbh->prepare("UPDATE users SET password = :password, reset_token = NULL, token_expiry = NULL WHERE email = :email");
                    $updateStmt->bindParam(":password", $new_password, PDO::PARAM_STR);
                    $updateStmt->bindParam(":email", $user['email'], PDO::PARAM_STR);
                    $updateStmt->execute();

                    echo "<p style='color: green;'>Password updated successfully. <a href='login.php'>Login</a></p>";
                } else {
                    echo "<p style='color: red;'>Passwords do not match!</p>";
                }
            }
        } else if (!$user) {
            echo "❌ Invalid or expired token!";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p style='color: red;'>No token provided!</p>";
    exit();
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
        <!-- Include Header -->
        <?php include 'include/header.php'; ?>

        <!-- Include Navigation Bar -->
        <?php include 'include/navigation.php'; ?>

        <!-- Reset Password Section -->
        <section class="reset-password">
            <div class="reset-container">
                <h2>Reset Password</h2>
                <form method="POST">
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Enter new password" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" name="submit" class="btn-reset">Reset Password</button>
                </form>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>