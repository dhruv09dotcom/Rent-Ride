<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Database connection
include('config.php'); // Ensure this file contains your database connection ($dbh)

// Fetch car details from the database
$sql = "SELECT v.id, v.vehicle_title, v.price_per_day, v.fuel_type, v.model_year, v.vehicle_overview, v.image1, b.brand_name 
        FROM vehicles v 
        JOIN brands b ON v.brand_id = b.id 
        ORDER BY v.id"; // Fetch all cars dynamically

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
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
        <!-- Explore Cars Section -->
        <main class="explore-car-section">
            <h2>Explore Cars</h2>
            <section class="explore-car-container">
                <div class="explore-car-row">

                <?php if ($query->rowCount() > 0) {
                    foreach ($results as $car) { ?>
                        <article class="explore-car-box">
                            <div class="explore-car-photo">
                                <img src="admin/uploads/<?php echo htmlentities($car->image1); ?>" alt="<?php echo htmlentities($car->vehicle_title); ?>">
                            <div class="explore-car-details">
                                <div class="explore-car-specs">
                                    <span><i class="fas fa-gas-pump"></i> <?php echo htmlentities($car->fuel_type); ?> </span>
                                    <span><i class="fas fa-calendar"></i> <?php echo htmlentities($car->model_year); ?> </span>
                                    <span><i class="fa-solid fa-car"></i> <?php echo htmlentities($car->brand_name); ?> </span>
                                </div>
                                <h3><?php echo htmlentities($car->vehicle_title); ?></h3>
                                <p class="explore-car-price">₹<?php echo htmlentities($car->price_per_day); ?> / Day</p>
                                <p class="explore-car-description">
                                    <?php echo substr(htmlentities($car->vehicle_overview), 0, 40); ?>...
                                    <a href="car-details.php?id=<?php echo htmlentities($car->id); ?>">See More</a>
                                </p>
                            </div>
                        </article>
                <?php } } else { ?>
                    <p>No cars available at the moment.</p>
                <?php } ?>
                
                </div>
            </section>
        </main>
    </body>
</html>