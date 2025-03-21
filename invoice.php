<?php
include 'include/config.php'; // Database connection using PDO

if (!isset($_GET['booking_id'])) {
    die("Booking ID is required.");
}

$booking_id = intval($_GET['booking_id']);

try {
    // Prepare SQL statement
    $sql = "SELECT 
                b.id AS booking_id, b.booking_number, b.from_date, b.to_date, b.status, b.created_at,
                u.first_name, u.last_name, u.email AS user_email, u.phone AS user_phone, u.address, u.pincode, u.state,
                v.vehicle_title, v.fuel_type, v.model_year, v.price_per_day
            FROM bookings b
            JOIN users u ON b.user_id = u.id
            JOIN vehicles v ON b.vehicle_id = v.id
            WHERE b.id = :booking_id";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        die("No booking found.");
    }

    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="Rent Ride: Your trusted car rental service. Explore our wide range of vehicles for rent at affordable prices.">
            <title>Invoice | Rent Ride</title>
            <link rel="stylesheet" href="styles.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="invoice-box">
            <h2>Invoice</h2>
            <table class="info-table">
                <tr><th>Booking ID:</th><td><?php echo $invoice['booking_number']; ?></td></tr>
                <tr><th>Customer Name:</th><td><?php echo $invoice['first_name'] . ' ' . $invoice['last_name']; ?></td></tr>
                <tr><th>Email:</th><td><?php echo $invoice['user_email']; ?></td></tr>
                <tr><th>Mobile Number:</th><td><?php echo $invoice['user_phone']; ?></td></tr>
                <tr><th>Address:</th><td><?php echo $invoice['address'] . ', ' . $invoice['pincode'] . ', ' . $invoice['state']; ?></td></tr>
                <tr><th>Booking Date:</th><td><?php echo date('d-m-Y', strtotime($invoice['created_at'])); ?></td></tr>
                <tr><th>Status:</th><td><?php echo ucfirst($invoice['status']); ?></td></tr>
            </table>

            <h3>Vehicle Details</h3>
            <table class="details-table">
                <tr><th>Vehicle:</th><td><?php echo $invoice['vehicle_title']; ?></td></tr>
                <tr><th>Fuel Type:</th><td><?php echo $invoice['fuel_type']; ?></td></tr>
                <tr><th>Model Year:</th><td><?php echo $invoice['model_year']; ?></td></tr>
                <tr><th>Price per Day:</th><td>₹<?php echo number_format($invoice['price_per_day'], 2); ?></td></tr>
                <tr><th>Start Date:</th><td><?php echo date('d-m-Y', strtotime($invoice['from_date'])); ?></td></tr>
                <tr><th>End Date:</th><td><?php echo date('d-m-Y', strtotime($invoice['to_date'])); ?></td></tr>
                <tr><th>Total Duration:</th><td>
                    <?php 
                        $start_date = new DateTime($invoice['from_date']);
                        $end_date = new DateTime($invoice['to_date']);
                        $interval = $start_date->diff($end_date);
                        echo $interval->days + 1 . " days";
                    ?>
                </td></tr>
                <tr><th>Total Cost:</th><td>₹<?php echo number_format(($interval->days + 1) * $invoice['price_per_day'], 2); ?></td></tr>
            </table>

            <button class="print-button" onclick="window.print();">Print Invoice</button>
        </div>
    </body>
</html>