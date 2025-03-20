<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'include/config.php'; // Include database connection

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in to update your password.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['id']; // Get logged-in user's ID

// Fetch user details
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $dbh->prepare($query);
$stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];

    $update_query = "UPDATE users SET first_name=:firstname, last_name=:lastname, email=:email, phone=:phone, 
                     address=:address, pincode=:pincode, state=:state WHERE id=:id";
    $stmt = $dbh->prepare($update_query);
    $stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
    $stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
    $stmt->bindParam(":address", $address, PDO::PARAM_STR);
    $stmt->bindParam(":pincode", $pincode, PDO::PARAM_STR);
    $stmt->bindParam(":state", $state, PDO::PARAM_STR);
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
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
                <h1>Profile Page</h1>
                <nav>
                    <a href="index.html">Home</a> >
                    <a href="profile.html">Profile Page</a>
                </nav>
            </div>
            <img src="Image/profile-page-banner.jpg" alt="Profile Page Background" class="ps-img">
        </div>

        <!-- Edit Profile Section --> 
        <section class="profile-section">
            <div class="profile-form">
                <form action="profile.php" method="POST">
                    <h3>Profile Details</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" value="<?= $user['first_name'] ?>" required />
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" value="<?= $user['last_name'] ?>" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required />
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?= $user['phone'] ?>" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="address">Your Address</label>
                            <textarea id="address" name="address" rows="3"><?= $user['address'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="pincode">Pincode</label>
                            <input type="text" id="pincode" name="pincode" value="<?= $user['pincode'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" value="<?= $user['state'] ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-save">Save changes</button>
                </form>
            </div>
        </section>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>