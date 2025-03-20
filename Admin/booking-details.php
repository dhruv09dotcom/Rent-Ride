<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Include database connection

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    try {
        // Fetch booking details using PDO
        $query = "SELECT b.booking_number, b.email, b.from_date, b.to_date, b.status, b.created_at, 
                     b.vehicle_id, v.vehicle_title, v.price_per_day, 
                     u.first_name, u.phone, u.address, u.pincode, u.state 
              FROM bookings b
              JOIN vehicles v ON b.vehicle_id = v.id
              JOIN users u ON b.user_id = u.id
              WHERE b.id = :booking_id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            extract($row);
        } else {
            echo "<p style='color:red;'>Booking not found!</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Database Error: " . $e->getMessage() . "</p>";
        exit;
    }
} else {
    echo "<p style='color:red;'>Invalid request!</p>";
    exit;
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

            <!-- Booking Details Section -->
                    <div class="booking-details">
                        <h2>Booking Details</h2>
                        <div class="booking-info">
                            <h3><span class="booking-number">#<?php echo $booking_number; ?></span><br> Booking Details</h3>
                            
                            <table class="details-table">
                                <tr>
                                    <th>Booking No.</th>
                                    <td>#<?php echo $booking_number; ?></td>
                                    <th>Name</th>
                                    <td><?php echo $first_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Email Id</th>
                                    <td><?php echo $email; ?></td>
                                    <th>Contact No</th>
                                    <td><?php echo $phone; ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo $address; ?></td>
                                    <th>Pincode</th>
                                    <td><?php echo $pincode; ?></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo $state; ?></td>
                                    <th>Booking Date</th>
                                    <td><?php echo $created_at; ?></td>
                                </tr>
                            </table>

                            <h3>Booking Details</h3>
                            <table class="details-table">
                                <tr>
                                    <th>Vehicle Name</th>
                                    <td><a href="edit-vehicle.php?id=<?php echo $vehicle_id; ?>"><?php echo $vehicle_title; ?></a></td>
                                    <th>From Date</th>
                                    <td><?php echo $from_date; ?></td>
                                </tr>
                                <tr>
                                    <th>To Date</th>
                                    <td><?php echo $to_date; ?></td>
                                    <th>Total Days</th>
                                    <td><?php echo (new DateTime($from_date))->diff(new DateTime($to_date))->days + 1; ?></td>
                                </tr>
                                <tr>
                                    <th>Rent Per Day</th>
                                    <td>₹<?php echo $price_per_day; ?></td>
                                    <th>Grand Total</th>
                                    <td>₹<?php echo ((new DateTime($from_date))->diff(new DateTime($to_date))->days + 1) * $price_per_day; ?></td>
                                </tr>
                                <tr>
                                    <th>Booking Status</th>
                                    <td colspan="3"><span class="status"><?php echo $status; ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST['confirm_booking'])) {
                                    $update_status = "UPDATE bookings SET status = 'Confirmed' WHERE id = :booking_id";
                                } elseif (isset($_POST['cancel_booking'])) {
                                    $update_status = "UPDATE bookings SET status = 'Cancelled' WHERE id = :booking_id";
                                }

                                try {
                                    $stmt = $pdo->prepare($update_status);
                                    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    echo "<script>alert('Booking status updated successfully!'); window.location.href='total-booking.php';</script>";
                                    exit();
                                } catch (PDOException $e) {
                                    echo "<script>alert('Error updating booking status!');</script>";
                                }
                            }
                        ?>
                        <!-- Booking Action Buttons -->
                        <div class="action-buttons">
                            <form id="bookingForm" method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                                <button type="button" class="confirm-btn" onclick="confirmBooking()">Confirm Booking</button>
                                <button type="button" class="cancel-btn" onclick="cancelBooking()">Cancel Booking</button>
                            </form>
                        </div>
                    </div>
                    <!-- JavaScript Confirmation -->
                    <script>
                    function confirmBooking() {
                        if (confirm("Are you sure you want to confirm this booking?")) {
                            document.getElementById('bookingForm').innerHTML += '<input type="hidden" name="confirm_booking">';
                            document.getElementById('bookingForm').submit();
                        }
                    }

                    function cancelBooking() {
                        if (confirm("Are you sure you want to cancel this booking?")) {
                            document.getElementById('bookingForm').innerHTML += '<input type="hidden" name="cancel_booking">';
                            document.getElementById('bookingForm').submit();
                        }
                    }
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>