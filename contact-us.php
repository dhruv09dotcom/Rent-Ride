<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'include/config.php';

// Fetch contact details from contact_info table
$sql = "SELECT * FROM contact_info WHERE id = 1"; // Assuming single record
$stmt = $dbh->prepare($sql);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['email'])) {
        // Redirect to login page if the user is not logged in
        echo "<script>
                alert('You need to log in first to send a message.');
                window.location.href = 'login.php';
              </script>";
        exit(); // Stop further execution
    }

    // If logged in, process form submission
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare and execute the insert query using PDO
    $insert_query = "INSERT INTO contact_queries (full_name, email, message) VALUES (:full_name, :email, :message)";
    $stmt = $dbh->prepare($insert_query);
    $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<script>
                alert('Message sent successfully!');
                window.location.href = 'contact-us.php';
              </script>";
    } else {
        echo "<script>
                alert('Error sending message!');
              </script>";
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

        <!-- Contact Us Section -->
        <section class="contact-section">
            <!-- First Row -->
            <div class="contact-title">
                <h2>Contact Us</h2>
                <p>We would love to hear from you! Fill out the form below, or reach us through our contact details.</p>
            </div>

            <!-- Second Row (Form & Contact Info) -->
            <div class="contact-wrapper">
                <!-- Left Side: Contact Details -->
                <div class="contact-details">
                    <h3>Get in Touch</h3>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $contact['address']; ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo $contact['email']; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $contact['contact_number']; ?></p>
                </div>
                
                <!-- Right Side: Contact Form -->
                <div class="contact-box">
                    <form action="contact-us.php" method="POST">
                        <input type="text" name="full_name" placeholder="Full Name" required>
                        <input type="email" name="email" placeholder="Email Address" required>
                        <textarea name="message" placeholder="Write your message" required></textarea>
                        <button type="submit">Send Message</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>