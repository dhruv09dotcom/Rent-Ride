<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('connection.php'); // Ensure this correctly sets up $pdo

try {
    // Handle delete request
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $query = "DELETE FROM brands WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: manage-brand.php');
        exit();
    }

    // Fetch brands from database
    $query = "SELECT * FROM brands ORDER BY id";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
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

            <!-- Manage Brand Section -->
            <div class="table-content">
                <h2>Manage Brands</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Brand Name</th>
                                <th>Creation Date</th>
                                <th>Update Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($brands as $row): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo !empty($row['updated_at']) ? $row['updated_at'] : 'N/A'; ?></td>
                                    <td>
                                        <a href="update-brand.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></a>
                                        <a href="manage-brand.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>