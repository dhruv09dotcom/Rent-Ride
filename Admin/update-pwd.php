<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('connection.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match!'); window.location.href='update-pwd.php';</script>";
        exit();
    }

    try {
        // Fetch the current password of the single admin 
        $query = "SELECT password FROM Admin LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $db_password = $admin['password'];

            // Verify plain text password
            if ($current_password === $db_password) {
                $update_query = "UPDATE Admin SET password=:new_password LIMIT 1";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->bindParam(':new_password', $new_password, PDO::PARAM_STR);

                if ($update_stmt->execute()) {
                    echo "<script>alert('Password updated successfully!'); window.location.href='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error updating password!'); window.location.href='update-pwd.php';</script>";
                }
            } else {
                echo "<script>alert('Current password is incorrect!'); window.location.href='update-pwd.php';</script>";
            }
        } else {
            echo "<script>alert('Admin not found!'); window.location.href='update-pwd.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href='update-pwd.php';</script>";
    }
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
        <?php include 'include/navbar.php'; ?>
        <div class="main-container">
            <?php include 'include/sidebar.php'; ?>
            <div class="password-container">
                <h2>Change Password</h2>
                <div class="form-container">
                    <h3>FORM FIELDS</h3>
                    <form action="#" method="POST">
                        <div class="input-group">
                            <label for="current-password">Current Password</label>
                            <input type="password" id="current-password" name="current-password" required>
                        </div>
                        <div class="input-group">
                            <label for="new-password">New Password</label>
                            <input type="password" id="new-password" name="new-password" required>
                        </div>
                        <div class="input-group">
                            <label for="confirm-password">Confirm Password</label>
                            <input type="password" id="confirm-password" name="confirm-password" required>
                        </div>
                        <button type="submit" class="btn-save">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>