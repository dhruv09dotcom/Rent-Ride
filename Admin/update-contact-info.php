<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Ensure connection.php uses PDO

// Fetch contact info
$sql = "SELECT * FROM contact_info WHERE id = 1"; // Assuming single record
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_address = trim($_POST['address']);
    $new_email = trim($_POST['email']);
    $new_contact = trim($_POST['contact_number']);
    
    $update_query = "UPDATE contact_info SET address = :address, email = :email, contact_number = :contact_number WHERE id = 1";
    $update_stmt = $pdo->prepare($update_query);
    
    if ($update_stmt->execute([':address' => $new_address, ':email' => $new_email, ':contact_number' => $new_contact])) {
        echo "<script>
                alert('Contact Info Updated Successfully!');
                window.location.href = 'update-contact-info.php';
            </script>";
        exit();
    } else {
        echo "<script>
                alert('Error updating contact info!');
            </script>";
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
        <!-- Include Navigation Bar -->
            <?php include 'include/navbar.php'; ?>

        <div class="main-container">
            <!-- Include Sidebar -->
                <?php include 'include/sidebar.php'; ?>

            <!-- Update Contact-Us Info Section -->
            <div class="update-cui">
                <h2>Update Contact Info</h2>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                <?php elseif (isset($_SESSION['error'])): ?>
                    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                
                <div class="update-cui-container">
                    <form action="" method="POST">
                        <label>Address</label>
                        <textarea name="address" required><?php echo htmlspecialchars($contact['address']); ?></textarea>

                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>

                        <label>Contact Number</label>
                        <input type="text" name="contact_number" value="<?php echo htmlspecialchars($contact['contact_number']); ?>" required>

                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>