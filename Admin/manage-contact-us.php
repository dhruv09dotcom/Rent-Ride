<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Database Connection (Ensure PDO is set up)

// Mark query as read
if (isset($_POST['mark_read'])) {
    $query_id = $_POST['query_id'];
    
    $update_query = "UPDATE contact_queries SET status='Read' WHERE id=:query_id";
    $stmt = $pdo->prepare($update_query);
    $stmt->bindParam(':query_id', $query_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: manage-contact-us.php"); // Refresh Page
        exit();
    }
}

// Fetch contact queries
$query = "SELECT * FROM contact_queries ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            <!-- Contact-Us Queries Section -->
            <div class="tblcontact">
                <h2>Manage Contact-Us</h2>
                <div class="tblcontainer">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Creation Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sr_no = 1;
                            foreach ($results as $row) {
                                echo "<tr>
                                        <td>{$sr_no}</td>
                                        <td>" . htmlspecialchars($row['full_name']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['message']) . "</td>
                                        <td>{$row['created_at']}</td>
                                        <td><span class='status " . strtolower($row['status']) . "'>{$row['status']}</span></td>
                                        <td>
                                            <form method='POST' style='display:inline-block;'>
                                                <input type='hidden' name='query_id' value='{$row['id']}'>
                                                <button type='submit' name='mark_read' class='btn-read' " . ($row['status'] == 'Read' ? 'disabled' : '') . ">
                                                    <i class='fa fa-check' style='color: white; font-weight: bold;'></i> Read
                                                </button>
                                            </form>
                                        </td>
                                    </tr>";
                                $sr_no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>