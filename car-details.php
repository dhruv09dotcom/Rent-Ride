<?php
// Step 1: Start Session & Include Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'include/config.php';

// Step 2: Validate & Fetch Car ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Car ID is missing.");
}
$car_id = $_GET['id'];

// Step 3: Check If User Is Logged In
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Step 4: Connect to Database & Fetch Car Details
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT v.*, b.brand_name FROM vehicles v 
                           JOIN brands b ON v.brand_id = b.id 
                           WHERE v.id = :car_id");
    $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        die("Car details not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Step 5: Check If User Clicked 'Book Now' Button
if (isset($_POST['submit'])) {

    // Step 6: Retrieve & Secure User Input
    $fromdate = htmlspecialchars($_POST['fromdate']);
    $todate = htmlspecialchars($_POST['todate']);
    $message = htmlspecialchars($_POST['message']);
    $vhid = $_GET['id']; // Get vehicle ID from URL
    $bookingno = mt_rand(100000000, 999999999); // Generate unique booking number
    $status = 'new'; // Default status
    $useremail = $_SESSION['email']; // Get user email from session

    // Step 7: Fetch User ID From Database Using Email
    $stmt = $pdo->prepare("SELECT id FROM Users WHERE email = :email");
    $stmt->bindParam(':email', $useremail, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
    
    $user_id = $user['id']; // Store user ID

    // Step 8: Validate Date Selection
    if (strtotime($fromdate) < strtotime(date('Y-m-d'))) {
        echo "<script>alert('Invalid From Date! Please select a future date.'); window.location='car-listing.php';</script>";
        exit();
    }
    if (strtotime($todate) < strtotime($fromdate)) {
        echo "<script>alert('To Date must be after From Date!'); window.location='car-listing.php';</script>";
        exit();
    }

    // Step 9: Check If Car is Already Booked
    $ret = "SELECT * FROM bookings WHERE 
            (:fromdate BETWEEN from_date AND to_date 
            OR :todate BETWEEN from_date AND to_date 
            OR from_date BETWEEN :fromdate AND :todate) 
            AND vehicle_id=:vhid";

    $query1 = $pdo->prepare($ret);
    $query1->bindParam(':vhid', $vhid, PDO::PARAM_INT);
    $query1->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query1->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query1->execute();

    if ($query1->rowCount() == 0) {

        // Step 10: Insert Booking Into Database (Including Email Column)
        $sql = "INSERT INTO bookings (booking_number, user_id, email, vehicle_id, from_date, to_date, message, status) 
                VALUES (:bookingno, :user_id, :email, :vhid, :fromdate, :todate, :message, :status)";

        $query = $pdo->prepare($sql);
        $query->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':email', $useremail, PDO::PARAM_STR); // ✅ Insert email
        $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();

        // Step 11: Redirect to My Bookings Page With Success Message
        if ($pdo->lastInsertId()) {
            $_SESSION['success_msg'] = "Your booking was successful! Booking Number: $bookingno";
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your booking was successful! Booking Number: $bookingno',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'my-bookings.php';
                        });
                    });
                  </script>";
            exit();
        } else {
            echo "<script>alert('Something went wrong. Please try again.'); window.location='car-listing.php';</script>";
        }
    } else {
        echo "<script>alert('Car already booked for these days.'); window.location='car-listing.php';</script>";
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

        <!-- Car Details Section -->
        <div class="scrolling-background">
            <div class="image-wrapper">
                <img src="admin/uploads/<?php echo htmlspecialchars($vehicle['image1']); ?>" alt="Car Image 1">
                <img src="admin/uploads/<?php echo htmlspecialchars($vehicle['image2']); ?>" alt="Car Image 2">
                <img src="admin/uploads/<?php echo htmlspecialchars($vehicle['image3']); ?>" alt="Car Image 3">
                <img src="admin/uploads/<?php echo htmlspecialchars($vehicle['image4']); ?>" alt="Car Image 4">
                <img src="admin/uploads/<?php echo htmlspecialchars($vehicle['image5']); ?>" alt="Car Image 5">
                <img src="admin/uploads/<?php echo htmlspecialchars($vehicle['image6']); ?>" alt="Car Image 6">
            </div>
        </div>
        <div class="car-wrapper">
            <div class="car-info-container">
                <h1 class="car-title"><?php echo htmlspecialchars($vehicle['vehicle_title']); ?></h1>
                <div class="car-price">₹<?php echo htmlspecialchars($vehicle['price_per_day']); ?> <span>Per Day</span></div>
                
                <div class="car-details">
                    <div class="car-detail-item">
                        <div class="circle"><i class="fa-solid fa-calendar-days"></i></div>
                        <p>Model Year <br> <?php echo htmlspecialchars($vehicle['model_year']); ?></p>
                    </div>
                    <div class="car-detail-item">
                        <div class="circle"><i class="fa-solid fa-gas-pump"></i></div>
                        <p>Fuel Type <br> <?php echo htmlspecialchars($vehicle['fuel_type']); ?></p>
                    </div>
                    <div class="car-detail-item">
                        <div class="circle"><i class="fa-solid fa-user-group"></i></div>
                        <p>Brand <br> <?php echo htmlspecialchars($vehicle['brand_name']); ?></p>
                    </div>
                </div>
                
                <div class="car-tabs">
                    <button class="active">Vehicle Overview</button>
                    <button>Accessories</button>
                </div>

                <div class="car-tab-content active">
                    <!-- Vehicle Overview -->
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Vehicle Overview</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p style="font-size: 17px;">
                                        <?php echo htmlspecialchars($vehicle['vehicle_overview']); ?>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="car-tab-content">
                    <!-- Vehicle Accessories -->
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Accessories</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // List of accessories from the database
                            $accessories = [
                                'air_conditioner' => 'Air Conditioner',
                                'antilock_braking_system' => 'Anti-Lock Braking System',
                                'power_steering' => 'Power Steering',
                                'power_windows' => 'Power Windows',
                                'cd_player' => 'CD Player',
                                'leather_seats' => 'Leather Seats',
                                'central_locking' => 'Central Locking',
                                'power_door_locks' => 'Power Door Locks',
                                'brake_assist' => 'Brake Assist',
                                'driver_airbag' => 'Driver Airbag',
                                'passenger_airbag' => 'Passenger Airbag',
                                'crash_sensor' => 'Crash Sensor'
                            ];

                            // Loop through accessories and display them dynamically
                            foreach ($accessories as $key => $label) {
                                $icon = ($vehicle[$key] == 1) ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>';
                                echo "<tr><td>{$label}</td><td>{$icon}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Second Row: Booking Section on the Right -->
            <form method="post">
                <div class="car-booking-container">
                    <h2><i class="fa-solid fa-envelope"></i> Book Now</h2>
                    
                    <label>From Date:</label>
                    <input type="date" name="fromdate" id="fromdate" required>

                    <label>To Date:</label>
                    <input type="date" name="todate" id="todate" required>

                    <textarea name="message" placeholder="Message (Optional)"></textarea>

                    <button class="book-btn" type="submit" name="submit">Book Now</button>
                </div>
            </form>

            <script>
                // Disable past dates in FromDate and ToDate
                let today = new Date().toISOString().split('T')[0];
                document.getElementById("fromdate").setAttribute("min", today);
                document.getElementById("todate").setAttribute("min", today);

                // Ensure ToDate is always after FromDate
                document.getElementById("fromdate").addEventListener("change", function() {
                    document.getElementById("todate").setAttribute("min", this.value);
                });
            </script>
        </div>

        <!-- Include Footer -->
        <?php include 'include/footer.php'; ?>

        <script>
            // Bg Image Section
            document.addEventListener("DOMContentLoaded", function () {
                let wrapper = document.querySelector(".image-wrapper");
                let clone = wrapper.innerHTML;
                wrapper.innerHTML += clone; // Duplicate images for smooth looping
            });

            // Tab Btn Switching
            document.addEventListener("DOMContentLoaded", function () {
                const tabButtons = document.querySelectorAll(".car-tabs button");
                const tabContents = document.querySelectorAll(".car-tab-content");

                tabButtons.forEach((button, index) => {
                    button.addEventListener("click", () => {
                        // Remove active class from all buttons and contents
                        tabButtons.forEach(btn => btn.classList.remove("active"));
                        tabContents.forEach(content => content.classList.remove("active"));

                        // Add active class to clicked button and corresponding content
                        button.classList.add("active");
                        tabContents[index].classList.add("active");
                    });
                });
            });

        </script>
    </body>
</html>