<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Include database connection

// Define available accessories
$accessories = [
    'air_conditioner', 'power_steering', 'cd_player', 'power_door_locks', 'driver_airbag', 
    'central_locking', 'antilock_braking_system', 'passenger_airbag', 'crash_sensor', 
    'brake_assist', 'power_windows', 'leather_seats'
];

// Fetch brands from the database
$brand_options = "";
$sql = "SELECT id, brand_name FROM brands";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $brand_options .= "<option value='" . $row['id'] . "'>" . $row['brand_name'] . "</option>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_title = $_POST['vehicle_title'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $vehicle_overview = $_POST['vehicle_overview'] ?? '';
    $price_per_day = $_POST['price_per_day'] ?? '';
    $fuel_type = $_POST['fuel_type'] ?? '';
    $model_year = $_POST['model_year'] ?? '';
    $seating_capacity = $_POST['seating_capacity'] ?? '';
    $upload_dir = "uploads/";
    $image_paths = [];

    // Process accessories dynamically
    $accessory_values = [];
    foreach ($accessories as $accessory) {
        $accessory_values[$accessory] = isset($_POST[$accessory]) ? 1 : 0;
    }

    // Image handling remains unchanged
    for ($i = 1; $i <= 6; $i++) {
        $image_field = "image$i";
        if (!empty($_FILES[$image_field]["name"])) {
            $file_name = time() . "_" . basename($_FILES[$image_field]["name"]);
            move_uploaded_file($_FILES[$image_field]["tmp_name"], $upload_dir . $file_name);
            $image_paths[$image_field] = $file_name;
        } else {
            $image_paths[$image_field] = NULL;
        }
    }

    // Insert Vehicle Data
    $sql = "INSERT INTO vehicles (
        vehicle_title, brand_id, vehicle_overview, price_per_day, fuel_type, model_year, seating_capacity,
        image1, image2, image3, image4, image5, image6,
        air_conditioner, power_steering, cd_player, power_door_locks, driver_airbag, central_locking,
        antilock_braking_system, passenger_airbag, crash_sensor, brake_assist, power_windows, leather_seats
    ) VALUES (
        :vehicle_title, :brand, :vehicle_overview, :price_per_day, :fuel_type, :model_year, :seating_capacity,
        :image1, :image2, :image3, :image4, :image5, :image6,
        :air_conditioner, :power_steering, :cd_player, :power_door_locks, :driver_airbag, :central_locking,
        :antilock_braking_system, :passenger_airbag, :crash_sensor, :brake_assist, :power_windows, :leather_seats
    )";

    $stmt = $pdo->prepare($sql);
    
    $params = [
        ':vehicle_title' => $vehicle_title, 
        ':brand' => $brand, 
        ':vehicle_overview' => $vehicle_overview, 
        ':price_per_day' => $price_per_day, 
        ':fuel_type' => $fuel_type, 
        ':model_year' => $model_year, 
        ':seating_capacity' => $seating_capacity,
        ':image1' => $image_paths["image1"], 
        ':image2' => $image_paths["image2"], 
        ':image3' => $image_paths["image3"], 
        ':image4' => $image_paths["image4"], 
        ':image5' => $image_paths["image5"], 
        ':image6' => $image_paths["image6"],
        ':air_conditioner' => $accessory_values['air_conditioner'], 
        ':power_steering' => $accessory_values['power_steering'], 
        ':cd_player' => $accessory_values['cd_player'], 
        ':power_door_locks' => $accessory_values['power_door_locks'], 
        ':driver_airbag' => $accessory_values['driver_airbag'], 
        ':central_locking' => $accessory_values['central_locking'], 
        ':antilock_braking_system' => $accessory_values['antilock_braking_system'], 
        ':passenger_airbag' => $accessory_values['passenger_airbag'], 
        ':crash_sensor' => $accessory_values['crash_sensor'], 
        ':brake_assist' => $accessory_values['brake_assist'], 
        ':power_windows' => $accessory_values['power_windows'], 
        ':leather_seats' => $accessory_values['leather_seats']
    ];

    if ($stmt->execute($params)) {
        echo "<script>alert('Vehicle added successfully!'); window.location.href='manage-vehicle.php';</script>";
    } else {
        echo "<script>alert('Error: " . implode(", ", $stmt->errorInfo()) . "');</script>";
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

            <!-- Add Vehicle Section -->
            <div class="vehicle-content">
                <h2>Post A Vehicle</h2>
                <h3 class="heading">Basic Info</h3>
                <form method="POST" enctype="multipart/form-data">
                <div class="vehicle-info">
                        <div class="row-one">
                            <div class="left">
                                <label>Vehicle Title <span>*</span></label>
                                <input type="text" name="vehicle_title" required>
                            </div>
                            <div class="right">
                                <label>Select Brand <span>*</span></label>
                                <select name="brand" required>
                                    <option value="">Select</option>
                                    <?php echo $brand_options; ?>
                                </select>
                            </div>
                        </div>
                        <div class="vehicle-overview">
                            <label>Vehicle Overview <span>*</span></label>
                            <textarea name="vehicle_overview" required></textarea>
                        </div>

                        <div class="row-two">
                            <div class="left">
                                <label>Price Per Day <span>*</span></label>
                                <input type="number" name="price_per_day" required>
                            </div>
                            <div class="right">
                                <label>Select Fuel Type <span>*</span></label>
                                <select name="fuel_type" required>
                                    <option>Select</option>
                                    <option>Petrol</option>
                                    <option>Diesel</option>
                                    <option>CNG</option>
                                </select>
                            </div>
                        </div>

                        <div class="row-three">
                            <div class="left">
                                <label>Model Year <span>*</span></label>
                                <input type="text" name="model_year" required>
                            </div>
                            <div class="right">
                                <label>Seating Capacity <span>*</span></label>
                                <input type="text" name="seating_capacity" required>
                            </div>
                        </div>
                    </div>

                    <div class="vehicle-image">
                    <div class="image-heading">
                        <h3>Upload Images</h3>
                    </div>
                    <div class="image-container">
                        <?php for ($i = 1; $i <= 6; $i++) { ?>
                            <div class="image-row">
                                <div class="image-box">
                                    <label>Image <?php echo $i; ?>:</label>
                                    <input type="file" name="image<?php echo $i; ?>" required>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                    <div class="accessories-section">
                        <div class="accessories-heading">
                            <h3>Accessories</h3>
                        </div>
                        <div class="accessories-container">
                            <?php foreach ($accessories as $accessory) { ?>
                                <label>
                                    <input type="checkbox" name="<?php echo $accessory; ?>"> 
                                    <?php echo ucwords(str_replace('_', ' ', $accessory)); ?>
                                </label>
                            <?php } ?>
                        </div>
                        <div class="buttons">
                            <button class="cancel">Cancel</button>
                            <button class="save">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>