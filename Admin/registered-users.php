<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('connection.php'); // Database connection file

try {
    // Handle delete request with confirmation
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute([$id])) {
            $_SESSION['success'] = "User deleted successfully.";
        } else {
            $_SESSION['error'] = "Error deleting user.";
        }
        
        header('Location: registered-users.php');
        exit();
    }

    // Fetch users from database
    $query = "SELECT * FROM users ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            <!-- Registered Users Section -->
            <div class="ru-content">
                <h2>Registered Users</h2>
                <div class="ru-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email ID</th>
                                <th>Contact No.</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>State</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if (count($users) > 0) {
                                $sr_no = 1;
                                foreach ($users as $row) {
                                    echo "<tr>
                                            <td>{$sr_no}</td>
                                            <td>{$row['first_name']}</td>
                                            <td>{$row['last_name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['phone']}</td>
                                            <td>{$row['address']}</td>
                                            <td>{$row['pincode']}</td>
                                            <td>{$row['state']}</td>
                                            <td>{$row['created_at']}</td>
                                            <td class='icon'>
                                                <a href='registered-users.php?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this user?\")'>
                                                    <i class='fas fa-trash' style='color: red; font-size: 18px;'></i>
                                                </a>
                                            </td>
                                        </tr>"; // Added semicolon here
                                    $sr_no++;
                                }
                            } else {
                                echo "<tr><td colspan='10' style='text-align: center;'>No registered users found.</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
