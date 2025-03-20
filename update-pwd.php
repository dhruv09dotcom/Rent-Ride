<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'include/config.php'; // Ensure this contains the PDO connection

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in to update your password.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['id']; // Get logged-in user's ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = trim($_POST['current-password']);
    $new_password = trim($_POST['new-password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match!'); window.location.href='update-pwd.php';</script>";
        exit();
    }

    // Fetch the current password from the database using PDO
    $query = "SELECT password FROM users WHERE id = :user_id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $db_password = $row['password'];

        // Verify the current password
        if ($current_password === $db_password) {
            // Update the password
            $update_query = "UPDATE users SET password = :new_password WHERE id = :user_id";
            $update_stmt = $dbh->prepare($update_query);
            $update_stmt->bindParam(':new_password', $new_password, PDO::PARAM_STR);
            $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($update_stmt->execute()) {
                echo "<script>alert('Password updated successfully!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error updating password! Please try again.'); window.location.href='update-pwd.php';</script>";
            }
        } else {
            echo "<script>alert('Current password is incorrect!'); window.location.href='update-pwd.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='update-pwd.php';</script>";
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
    </head>
    <body>
        <!-- Include Header -->
        <?php include 'include/header.php'; ?>

        <!-- Include Navigation Bar -->
        <?php include 'include/navigation.php'; ?>

        <!-- Banner Section (Background Image) -->
        <div class="ps-container">
            <div class="ps-overlay">
                <h1>Update Password</h1>
                <nav>
                    <a href="index.php">Home</a> >
                    <a href="update-pwd.php">Update Password</a>
                </nav>
            </div>
            <img src="Image/profile-page-banner.jpg" alt="Update Password Background" class="ps-img">
        </div>

        <!-- Update Password Section -->
        <section class="update-password">
            <div class="update-container">
                <h2>Change Password</h2>
                <form action="#" method="POST">
                    <div class="input-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" name="current-password" placeholder="Enter your current password" required>
                    </div>
                    <div class="input-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password" placeholder="Enter your new password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn-save">Save changes</button>
                </form>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>