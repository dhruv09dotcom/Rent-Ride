<?php 
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'include/config.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from session
$user_email = $_SESSION['email'];

// Handle booking cancellation
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];

    // Check if booking exists and fetch status
    $check_status = $dbh->prepare("SELECT status FROM bookings WHERE id = :booking_id");
    $check_status->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $check_status->execute();
    $status = $check_status->fetchColumn();

    if ($status === false) {
        echo "<script>alert('Booking not found.'); window.location.href='my-bookings.php';</script>";
        exit();
    }

    if ($status !== "Canceled") {
        // Update booking status to "Canceled"
        $cancel_booking = $dbh->prepare("UPDATE bookings SET status = 'Canceled' WHERE id = :booking_id");
        $cancel_booking->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        if ($cancel_booking->execute()) {
            echo "<script>alert('Booking canceled successfully.'); window.location.href='my-bookings.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to cancel booking. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('This booking is already canceled.');</script>";
    }
}

// Define pagination variables
$limit = 1; // Number of bookings per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total number of bookings for pagination
$query_total = "SELECT COUNT(*) FROM bookings WHERE user_id = (SELECT id FROM users WHERE email = :email)";
$stmt_total = $dbh->prepare($query_total);
$stmt_total->bindParam(':email', $user_email, PDO::PARAM_STR);
$stmt_total->execute();
$total_records = $stmt_total->fetchColumn();
$total_pages = ceil($total_records / $limit);

// Fetch paginated user bookings along with vehicle details
$query = "SELECT 
        b.id AS booking_id, 
        b.booking_number, 
        b.from_date, 
        b.to_date, 
        b.status, 
        b.message,
        v.vehicle_title, 
        v.image1 AS car_image, 
        v.price_per_day
    FROM bookings b
    JOIN vehicles v ON b.vehicle_id = v.id
    WHERE b.user_id = (SELECT id FROM users WHERE email = :email)
    ORDER BY b.from_date DESC
    LIMIT :limit OFFSET :offset";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <h1>My Bookings</h1>
                <nav>
                    <a href="index.php">Home</a> >
                    <a href="mybookings.php">My Booking</a>
                </nav>
            </div>
            <img src="Image/profile-page-banner.jpg" alt="Profile Page Background" class="ps-img">
        </div>

        <!-- My Booking Section -->
        <section class="my-bookings">
            <div class="booking-container">
                <h2 class="mb"><b>MY BOOKINGS</b></h2>

                <!-- Pagination -->
                <div class="pagination">
                    <a href="my-bookings.php?page=<?php echo $page - 1; ?>" class="prev <?php echo ($page <= 1) ? 'disabled' : ''; ?>">← previous</a>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="my-bookings.php?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    <a href="my-bookings.php?page=<?php echo $page + 1; ?>" class="next <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">next →</a>
                </div>

                <?php if (count($bookings) > 0): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <p class="booking-number">
                            Booking No: <span><?php echo htmlspecialchars($booking['booking_number']); ?></span>
                        </p>
                        <div class="booking-details">
                            <img src="admin/uploads/<?php echo htmlspecialchars($booking['car_image']); ?>" class="car-image" alt="Car Image">
                            <div class="car-info">
                                <h3><b><?php echo htmlspecialchars($booking['vehicle_title']); ?></b></h3>
                                <p><b>From:</b> <?php echo htmlspecialchars($booking['from_date']); ?> <b>To:</b> <?php echo htmlspecialchars($booking['to_date']); ?></p>
                                <p><b>Message:</b> <?php echo htmlspecialchars($booking['message']); ?></p>
                            </div>
                            <div class="status" style="border: 2px solid <?php echo ($booking['status'] == 'Canceled') ? 'red' : 'green'; ?>; color: <?php echo ($booking['status'] == 'Canceled') ? 'red' : 'green'; ?>;">
                                <?php echo htmlspecialchars($booking['status']); ?>
                            </div>
                        </div>
                        
                        <div id="invoice-<?php echo $booking['booking_id']; ?>">
                            <h3 class="invoice-heading">Invoice</h3>
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Car Name</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Total Days</th>
                                        <th>Price Per Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['vehicle_title']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['from_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['to_date']); ?></td>
                                        <td><?php 
                                            $date1 = new DateTime($booking['from_date']);
                                            $date2 = new DateTime($booking['to_date']);
                                            $interval = $date1->diff($date2);
                                            echo $interval->days;
                                        ?></td>
                                        <td>₹<?php echo htmlspecialchars($booking['price_per_day']); ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="MB"><b>Grand Total</b></td>
                                        <td><b>₹<?php echo $interval->days * $booking['price_per_day']; ?></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="button-container">
                            <form method="POST" action="my-bookings.php">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                <button type="submit" name="cancel_booking" class="cancel-button">Cancel Booking</button>
                                <button type="button" class="print-button" onclick="printInvoice(<?php echo $booking['booking_id']; ?>)">Print Invoice</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No bookings found.</p>
                <?php endif; ?>
            </div>
        </section>
        <script>
            function printInvoice(bookingId) {
                var invoice = document.getElementById("invoice-" + bookingId);
                var originalContent = document.body.innerHTML;
                document.body.innerHTML = invoice.innerHTML;
                window.print();
                document.body.innerHTML = originalContent;
                window.location.reload();
            }
        </script>
        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>
    </body>
</html>