<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('connection.php'); // Database connection file

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage-brand.php");
    exit();
}

$id = intval($_GET['id']); // Get ID and convert to integer

// Fetch existing brand details using PDO
$query = "SELECT * FROM brands WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$brand = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if brand exists
if (!$brand) {
    header("Location: manage-brand.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $brand_name = trim($_POST['brand_name']);

    // Validate input
    if (empty($brand_name)) {
        $error = "Brand name cannot be empty!";
    } else {
        // Check if the new brand name already exists
        $checkQuery = "SELECT id FROM brands WHERE brand_name = :brand_name AND id != :id";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':brand_name', $brand_name, PDO::PARAM_STR);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $error = "Brand name already exists!";
        } else {
            // Update brand
            $updateQuery = "UPDATE brands SET brand_name = :brand_name, updated_at = NOW() WHERE id = :id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':brand_name', $brand_name, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                echo "<script>
                        alert('Brand updated successfully.');
                        window.location.href = 'manage-brand.php';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Error updating brand.');
                        window.location.href = 'create-brand.php';
                      </script>";
                exit();
            }
        }
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

            <!-- Update Brand Section -->
            <div class="create-brand">
                <h2>Update Brand</h2>
                <div class="brand-container">
                    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                    <form action="" method="POST">
                        <label for="brand-name">Brand Name</label>
                        <input type="text" id="brand-name" name="brand_name" value="<?php echo htmlspecialchars($brand['brand_name']); ?>" required>
                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>