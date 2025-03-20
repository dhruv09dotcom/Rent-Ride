<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'include/config.php';

$full_name = "";
$email = "";
$message = "";

// Check if user is logged in and fetch their query details
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    try {
        $query = "SELECT full_name, email, message FROM contact_queries WHERE email = :email ORDER BY id DESC LIMIT 1";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
        $stmt->execute();
        $query_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($query_data) {
            $full_name = htmlspecialchars($query_data['full_name']);
            $email = htmlspecialchars($query_data['email']);
            $message = htmlspecialchars($query_data['message']);
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
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
        <div class="cu-container">
            <div class="cu-overlay">
                <h1>Contact Us</h1>
                <nav>
                    <a href="index.php">Home</a> >
                    <a href="contact-us.php">Contact Us</a>
                </nav>
            </div>
            <img src="Image/contact-us-banner.jpg" alt="Contact-Us Background" class="cu-img">
        </div>

        <!-- Contact Queries Section -->
        <section class="contact-queries">
            <div class="contact-query-title"> 
                <h2>Contact Queries</h2>
                <form action="contact_process.php" method="POST">
                    <div class="input-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" placeholder="Full Name" value="<?php echo $full_name; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" placeholder="Email Address" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="message">Your Message</label>
                        <textarea name="message" placeholder="Your Message" required><?php echo $message; ?></textarea>
                    </div>
                </form>
                    
                <!-- Display Message Status -->
                <?php
                if (isset($_SESSION['email'])) {
                    $user_email = $_SESSION['email'];

                    $query = "SELECT status FROM contact_queries WHERE email = :email ORDER BY id LIMIT 1";
                    $stmt = $dbh->prepare($query);
                    $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
                    $stmt->execute();
                    $message_status = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($message_status) {
                        echo "<p class='message-status'>Message Status: <strong>" . ucfirst($message_status['status']) . "</strong></p>";
                    }
                }
                ?>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>