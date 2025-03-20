<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'include/config.php';
try {
    // Fetch brands from the brands table
    $brand_query = "SELECT DISTINCT brand_name FROM brands ORDER BY brand_name ASC";
    $brand_stmt = $dbh->prepare($brand_query);
    $brand_stmt->execute();
    $brands = $brand_stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Ensure brands array is never NULL

    // Fetch fuel types from the vehicles table
    $fuel_query = "SELECT DISTINCT fuel_type FROM vehicles ORDER BY fuel_type ASC";
    $fuel_stmt = $dbh->prepare($fuel_query);
    $fuel_stmt->execute();
    $fuels = $fuel_stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Ensure fuels array is never NULL

    // Fetch car details from the vehicles table along with brand names
    $sql = "SELECT v.id, v.vehicle_title, v.price_per_day, v.fuel_type, v.model_year, v.vehicle_overview, v.image1, b.brand_name 
            FROM vehicles v 
            JOIN brands b ON v.brand_id = b.id 
            ORDER BY v.id"; // Fetch all cars ordered by latest first

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Ensure cars array is never NULL

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // Display error if query fails
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
        <script src="script.js"></script>
    </head>
    <body>
        <!-- Car Listing Section -->
        <section class="car-listing-section">
            <div class="car-listing-container">

                <!-- Car Listing Filter -->
                <div class="filter-container">
                    <select id="brandFilter">
                        <option value="">Select Brand</option>
                        <?php foreach ($brands as $brand) { ?>
                            <option value="<?= htmlspecialchars($brand['brand_name']) ?>"><?= htmlspecialchars($brand['brand_name']) ?></option>
                        <?php } ?>
                    </select>

                    <select id="fuelFilter">
                        <option value="">Select Fuel Type</option>
                        <?php foreach ($fuels as $fuel) { ?>
                            <option value="<?= htmlspecialchars($fuel['fuel_type']) ?>"><?= htmlspecialchars($fuel['fuel_type']) ?></option>
                        <?php } ?>
                    </select>

                    <button class="filter-btn" onclick="filterCars()">Apply Filter</button>
                </div>
    
                <!-- Main Content -->
                <main class="car-container">
                    <?php foreach ($cars as $car) { ?>
                        <div class="car-card" data-brand="<?= htmlspecialchars($car['brand_name']) ?>" data-fuel="<?= htmlspecialchars($car['fuel_type']) ?>">
                            <img src="admin/uploads/<?= htmlspecialchars($car['image1']) ?>" alt="<?= htmlspecialchars($car['vehicle_title']) ?>">
                            <div class="car-info">
                                <h3><?= htmlspecialchars($car['vehicle_title']) ?></h3>
                                <p class="prices">₹<?= htmlspecialchars($car['price_per_day']) ?> per day</p>
                                <div class="cars-meta">
                                    <span><i class="fa-solid fa-car"></i> <?= htmlspecialchars($car['brand_name']) ?></span>
                                    <span><i class="fas fa-calendar"></i> <?= htmlspecialchars($car['model_year']) ?></span>
                                    <span><i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?></span>
                                </div>
                                <button class="details-btn"><a href="car-details.php?id=<?php echo $car['id']; ?>">View Details</a></button>
                            </div>
                        </div>
                    <?php } ?>
                </main>
            </div>
        </section>
        <script>
            function filterCars() {
                let brand = document.getElementById("brandFilter").value.toLowerCase().trim();
                let fuel = document.getElementById("fuelFilter").value.toLowerCase().trim();
                let cars = document.querySelectorAll(".car-card");

                cars.forEach(car => {
                    let carBrand = car.querySelector(".cars-meta span:nth-child(1)").textContent.toLowerCase().trim();
                    let carFuel = car.querySelector(".cars-meta span:nth-child(3)").textContent.toLowerCase().trim();

                    if ((brand === "" || carBrand.includes(brand)) && (fuel === "" || carFuel.includes(fuel))) {
                        car.style.display = "flex"; // Ensure card and details are shown
                    } else {
                        car.style.display = "none";
                    }
                });
            }
        </script>
    </body>
</html>