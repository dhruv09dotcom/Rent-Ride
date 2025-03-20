<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Database connection using PDO

// Check if ID is passed
if (isset($_GET['id'])) {
    $vehicle_id = intval($_GET['id']);

    // Define available accessories
    $accessories = [
        'air_conditioner', 'power_steering', 'cd_player', 'power_door_locks', 'driver_airbag', 
        'central_locking', 'antilock_braking_system', 'passenger_airbag', 'crash_sensor', 
        'brake_assist', 'power_windows', 'leather_seats'
    ];

    // Fetch Vehicle Details
    $sql = "SELECT * FROM vehicles WHERE id = :id";
    $stmt = $pdo->prepare($sql);  // Change $conn to $pdo
    $stmt->execute(['id' => $vehicle_id]);
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        echo "<script>alert('Vehicle not found'); window.location.href='manage-vehicle.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid Request'); window.location.href='manage-vehicle.php';</script>";
    exit();
}

// Fetch brands for dropdown
$brand_options = "";
$sql = "SELECT id, brand_name FROM brands";
foreach ($pdo->query($sql) as $row) {  // Change $conn to $pdo
    $selected = ($row['id'] == $vehicle['brand_id']) ? "selected" : "";
    $brand_options .= "<option value='" . $row['id'] . "' $selected>" . $row['brand_name'] . "</option>";
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_title = trim($_POST['vehicle_title']);
    $brand = intval($_POST['brand']);
    $vehicle_overview = trim($_POST['vehicle_overview']);
    $price_per_day = floatval($_POST['price_per_day']);
    $fuel_type = trim($_POST['fuel_type']);
    $model_year = intval($_POST['model_year']);
    $seating_capacity = intval($_POST['seating_capacity']);
    $upload_dir = "uploads/";
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $max_size = 2 * 1024 * 1024;

    // Process accessories dynamically
    $accessory_values = [];
    foreach ($accessories as $accessory) {
        $accessory_values[$accessory] = isset($_POST[$accessory]) ? 1 : 0;
    }

    // Store image paths
    $image_paths = $vehicle;
    for ($i = 1; $i <= 6; $i++) {
        $image_field = "image$i";
        if (!empty($_FILES[$image_field]["name"])) {
            $file_name = basename($_FILES[$image_field]["name"]);
            $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_size = $_FILES[$image_field]["size"];

            if (!in_array($file_type, $allowed_types) || $file_size > $max_size) {
                $_SESSION['error'] = "Invalid file type or size for Image $i.";
                continue;
            }

            $new_filename = time() . "_" . $file_name;
            $target_file = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES[$image_field]["tmp_name"], $target_file)) {
                if (!empty($vehicle[$image_field]) && file_exists($upload_dir . $vehicle[$image_field])) {
                    unlink($upload_dir . $vehicle[$image_field]);
                }
                $image_paths[$image_field] = $new_filename;
            }
        }
    }

    // Update vehicle data
    $sql = "UPDATE vehicles SET 
        vehicle_title=:vehicle_title, brand_id=:brand, vehicle_overview=:vehicle_overview, price_per_day=:price_per_day, 
        fuel_type=:fuel_type, model_year=:model_year, seating_capacity=:seating_capacity,
        air_conditioner=:air_conditioner, power_steering=:power_steering, cd_player=:cd_player, 
        power_door_locks=:power_door_locks, driver_airbag=:driver_airbag, central_locking=:central_locking, 
        antilock_braking_system=:antilock_braking_system, passenger_airbag=:passenger_airbag, crash_sensor=:crash_sensor, 
        brake_assist=:brake_assist, power_windows=:power_windows, leather_seats=:leather_seats,
        image1=:image1, image2=:image2, image3=:image3, image4=:image4, image5=:image5, image6=:image6
        WHERE id=:id";

    $stmt = $pdo->prepare($sql);
    $params = array_merge(
        [
            'vehicle_title' => $vehicle_title, 'brand' => $brand, 'vehicle_overview' => $vehicle_overview, 'price_per_day' => $price_per_day,
            'fuel_type' => $fuel_type, 'model_year' => $model_year, 'seating_capacity' => $seating_capacity,
            'id' => $vehicle_id
        ],
        $accessory_values,
        [
            'image1' => $image_paths["image1"], 'image2' => $image_paths["image2"], 'image3' => $image_paths["image3"],
            'image4' => $image_paths["image4"], 'image5' => $image_paths["image5"], 'image6' => $image_paths["image6"]
        ]
    );

    if ($stmt->execute($params)) { 
        echo "<script>alert('Vehicle updated successfully!'); window.location.href='manage-vehicle.php';</script>";
    } else {
        echo "<script>alert('Error updating vehicle');</script>";
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

            <!-- Edit Vehicle Section -->
            <div class="vehicle-content">
                <h2>Edit Vehicle</h2>
                <h3 class="heading">Basic Info</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="vehicle-info">
                            <div class="row-one">
                                <div class="left">
                                    <label>Vehicle Title <span>*</span></label>
                                    <input type="text" name="vehicle_title" value="<?php echo $vehicle['vehicle_title']; ?>" required>
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
                                <textarea name="vehicle_overview" required><?php echo $vehicle['vehicle_overview']; ?></textarea>
                            </div>
                            <div class="row-two">
                                <div class="left">
                                    <label>Price Per Day <span>*</span></label>
                                    <input type="number" name="price_per_day" value="<?php echo $vehicle['price_per_day']; ?>" required>
                                </div>
                                <div class="right">
                                    <label>Select Fuel Type <span>*</span></label>
                                    <select name="fuel_type" required>
                                        <option value="Petrol" <?php if ($vehicle['fuel_type'] == "Petrol") echo "selected"; ?>>Petrol</option>
                                        <option value="Diesel" <?php if ($vehicle['fuel_type'] == "Diesel") echo "selected"; ?>>Diesel</option>
                                        <option value="CNG" <?php if ($vehicle['fuel_type'] == "CNG") echo "selected"; ?>>CNG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row-three">
                                <div class="left">
                                    <label>Model Year <span>*</span></label>
                                    <input type="text" name="model_year" value="<?php echo $vehicle['model_year']; ?>" required>
                                </div>
                                <div class="right">
                                    <label>Seating Capacity <span>*</span></label>
                                    <input type="text" name="seating_capacity" value="<?php echo $vehicle['seating_capacity']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="vehicle-image">
                            <div class="image-heading">
                                <h3>Upload Images</h3>
                            </div>
                            <div class="image-container">
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <div class="image-row">
                                        <div class="image-box">
                                            <label>Image <?php echo $i; ?>:</label>
                                            <?php if (!empty($vehicle["image$i"])): ?>
                                                <img src="uploads/<?php echo $vehicle["image$i"]; ?>" width="240" height="160px" style="border: 1px solid #000;"><br>
                                            <?php endif; ?>
                                            <input type="file" name="image<?php echo $i; ?>"><br>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="accessories-section">
                            <div class="accessories-heading">
                                <h3>Accessories</h3>
                            </div>
                            <div class="accessories-container">
                            <?php foreach ($accessories as $accessory) { ?>
                                <label>
                                <input type="checkbox" name="<?php echo $accessory; ?>" <?php echo ($vehicle[$accessory] == 1) ? "checked" : ""; ?>>
                                    <?php echo ucwords(str_replace('_', ' ', $accessory)); ?>
                                </label>
                            <?php } ?>
                            </div>
                            <div class="buttons">
                                <button class="update">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>