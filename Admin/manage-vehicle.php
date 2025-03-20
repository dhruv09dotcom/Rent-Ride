<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Ensure this file sets up $pdo correctly

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize input

    $stmt = $pdo->prepare("DELETE FROM vehicles WHERE id = :id");
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Vehicle deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting vehicle!";
    }

    header("Location: manage-vehicle.php");
    exit();
}

// Fetch Vehicles Data
$query = "SELECT v.id, v.vehicle_title, b.brand_name, v.price_per_day, 
                 v.fuel_type, v.model_year, v.seating_capacity
          FROM vehicles v 
          JOIN brands b ON v.brand_id = b.id";

$stmt = $pdo->query($query);
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Vehicles | Admin Dashboard</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
        <script src="script.js">
            function confirmDelete(id) {
                return confirm("Are you sure you want to delete this vehicle?");
            }
        </script>
    </head>
    <body>
        <!-- Include Navigation Bar -->
        <?php include 'include/navbar.php'; ?>

        <div class="main-container">
            <!-- Include Sidebar -->
            <?php include 'include/sidebar.php'; ?>

            <!-- Manage Vehicle Section -->
            <div class="mg-vehicle-content">
                <h2>Manage Vehicles</h2>
                <?php if (isset($_SESSION['message'])): ?>
                    <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
                <?php endif; ?>
                <div class="mg-vehicle-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Vehicle Title</th>
                                <th>Brand</th>
                                <th>Price Per Day</th>
                                <th>Fuel Type</th>
                                <th>Model Year</th>
                                <th>Seating Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1; foreach ($vehicles as $row): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlspecialchars($row['vehicle_title']); ?></td>
                                <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                                <td><?php echo $row['price_per_day']; ?></td>
                                <td><?php echo $row['fuel_type']; ?></td>
                                <td><?php echo $row['model_year']; ?></td>
                                <td><?php echo $row['seating_capacity']; ?></td>
                                <td>
                                    <a href="edit-vehicle.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></a>
                                    <a href="manage-vehicle.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirmDelete(<?php echo $row['id']; ?>)"><i class="fas fa-trash"></i></a>
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