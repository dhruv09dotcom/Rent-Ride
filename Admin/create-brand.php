<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection file
include 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand_name = trim($_POST['brand_name']);

    // Validate input
    if (empty($brand_name)) {
        $_SESSION['message'] = "Brand name cannot be empty.";
        header("Location: create-brand.php");
        exit();
    }

    try {
        // Check if brand already exists
        $stmt = $pdo->prepare("SELECT id FROM brands WHERE brand_name = ?");
        $stmt->execute([$brand_name]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Brand already exists.";
            header("Location: create-brand.php");
            exit();
        }

        // Insert brand into database
        $stmt = $pdo->prepare("INSERT INTO brands (brand_name) VALUES (?)");
        if ($stmt->execute([$brand_name])) {
            echo "<script>
                    alert('Brand added successfully.');
                    window.location.href = 'manage-brand.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error adding brand.');
                    window.location.href = 'create-brand.php';
                  </script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Database Error: " . $e->getMessage() . "');
                window.location.href = 'create-brand.php';
              </script>";
        exit();
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

        <!-- Create Brand Section -->
        <div class="create-brand">
                <h2>Create Brand</h2>
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<p class="message">' . $_SESSION['message'] . '</p>';
                    unset($_SESSION['message']);
                }
                ?>
                <div class="brand-container">
                    <form action="create-brand.php" method="POST">
                        <label for="brand-name">Brand Name</label>
                        <input type="text" id="brand-name" name="brand_name" placeholder="Tata" required>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>