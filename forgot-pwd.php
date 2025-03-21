<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include Composer's autoload file
include 'include/config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    try {
        // Check if email exists in the database
        $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $token = bin2hex(random_bytes(50)); // Generate secure token
            $expiry = date("Y-m-d H:i:s", strtotime("+30 minutes"));// Token expiry

            // Store token in the database
            $updateStmt = $dbh->prepare("UPDATE users SET reset_token = :token, token_expiry = :expiry WHERE email = :email");
            $updateStmt->bindParam(":token", $token, PDO::PARAM_STR);
            $updateStmt->bindParam(":expiry", $expiry, PDO::PARAM_STR);
            $updateStmt->bindParam(":email", $email, PDO::PARAM_STR);
            $updateStmt->execute();

            // Send Reset Email using PHPMailer
            $mail = new PHPMailer(true);

            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP provider
                $mail->SMTPAuth = true;
                $mail->Username = 'rathvadhruv3@gmail.com'; // Your email
                $mail->Password = 'isiw kslo bzwg qbyv'; // Google App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email Content
                $mail->setFrom('rathvadhruv3@gmail.com', 'Rent Ride Support');
                $mail->addAddress($email);
                $mail->Subject = "Password Reset Request";
                $encodedURL = "http://localhost/Rent%20Ride/reset-pwd.php?token=" . $token;
                $mail->Body = "Click the link below to reset your password:\n\n" . $encodedURL;
                
                $mail->send();

            } catch (Exception $e) {
                echo "<p style='color: red;'>Email sending failed: {$mail->ErrorInfo}</p>";
            }
        } else {
            echo "<p style='color: red;'>Email not found!</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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

        <!-- Forgot Password Section -->
        <section class="forgot-password">
            <div class="forgot-container">
                <h2>Forgot Password</h2>
                <p>Enter your registered email to receive a password reset link.</p>
                <form method="POST">
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn-reset">Send Reset Link</button>
                </form>
                <p class="back-to-login"><a href="login.php">Back to Login</a></p>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>