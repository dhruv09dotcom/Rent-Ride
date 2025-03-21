-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 07:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent_ride`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updated_at`) VALUES
(1, 'Admin', 'admin@123', '2025-03-18 09:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_number` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','confirmed','cancelled') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_number`, `user_id`, `email`, `vehicle_id`, `from_date`, `to_date`, `message`, `status`, `created_at`) VALUES
(1, '985887319', 1, 'test@gmail.com', 8, '2025-03-20', '2025-03-22', 'Accpet my booking asap!', 'confirmed', '2025-03-20 09:57:54'),
(2, '490419718', 1, 'test@gmail.com', 1, '2025-03-20', '2025-03-22', 'Booking for business visit!', 'cancelled', '2025-03-20 17:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `created_at`, `updated_at`) VALUES
(1, 'Tata', '2025-03-16 13:27:23', '2025-03-16 13:31:32'),
(2, 'Honda', '2025-03-17 11:36:36', '2025-03-17 11:36:36'),
(3, 'Toyota', '2025-03-17 11:36:55', '2025-03-17 11:36:55'),
(4, 'Hyundai', '2025-03-17 11:37:05', '2025-03-17 11:37:05'),
(5, 'Maruti', '2025-03-17 11:37:15', '2025-03-17 11:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `address`, `email`, `contact_number`) VALUES
(1, 'D&M Block, Alpesh Complex', 'info@rentride.com', '+91 9865 327410');

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Unread','Read') DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_queries`
--

INSERT INTO `contact_queries` (`id`, `full_name`, `email`, `message`, `created_at`, `status`) VALUES
(1, 'Test Project', 'test@gmail.com', 'Hello Admin !', '2025-03-19 09:33:12', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) NOT NULL,
  `state` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `pincode`, `state`, `password`, `created_at`) VALUES
(1, 'Test', 'Project', 'test@gmail.com', '9876543210', 'Building A, [6th Floor/603], Courtyard Trilogy, Bhayli, Vadodara.', '391410', 'Gujarat', 'test@123', '2025-03-18 15:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_title` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `vehicle_overview` text NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `model_year` year(4) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `image1` text DEFAULT NULL,
  `image2` text DEFAULT NULL,
  `image3` text DEFAULT NULL,
  `image4` text DEFAULT NULL,
  `image5` text DEFAULT NULL,
  `image6` text DEFAULT NULL,
  `air_conditioner` tinyint(4) DEFAULT NULL,
  `power_steering` tinyint(4) DEFAULT NULL,
  `cd_player` tinyint(4) DEFAULT NULL,
  `power_door_locks` tinyint(4) DEFAULT NULL,
  `driver_airbag` tinyint(4) DEFAULT NULL,
  `central_locking` tinyint(4) DEFAULT NULL,
  `antilock_braking_system` varchar(255) DEFAULT NULL,
  `passenger_airbag` tinyint(4) DEFAULT NULL,
  `crash_sensor` tinyint(4) DEFAULT NULL,
  `brake_assist` tinyint(4) DEFAULT NULL,
  `power_windows` tinyint(4) DEFAULT NULL,
  `leather_seats` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_title`, `brand_id`, `vehicle_overview`, `price_per_day`, `fuel_type`, `model_year`, `seating_capacity`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`, `air_conditioner`, `power_steering`, `cd_player`, `power_door_locks`, `driver_airbag`, `central_locking`, `antilock_braking_system`, `passenger_airbag`, `crash_sensor`, `brake_assist`, `power_windows`, `leather_seats`, `created_at`, `updated_at`) VALUES
(1, 'Honda City', 2, 'The Honda City has 1 Petrol Engine on offer. The Petrol engine is 1498 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the City has a mileage of 17.8 to 18.4 kmpl. The City is a 5 seater 4 cylinder car and has length of 4583 mm, width of 1748 mm and a wheelbase of 2600 mm.', 1200.00, 'Petrol', '2024', 5, '1742211677_Honda City 2024 1.jpg', '1742211677_Honda City 2024 2.jpg', '1742211677_Honda City 2024 3.jpg', '1742211677_Honda City 2024 4.jpeg', '1742211677_Honda City 2024 5.jpeg', '1742211677_Honda City 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 1, 1, '2025-03-17 11:41:17', '2025-03-17 11:41:17'),
(2, 'Honda Amaze', 2, 'The Honda Amaze has 1 Petrol Engine on offer. The Petrol engine is 1199 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the Amaze has a mileage of 18.65 to 19.46 kmpl & Ground clearance of Amaze is 172 mm. The Amaze is a 5 seater 4 cylinder car and has length of 3995 mm, width of 1733 mm and a wheelbase of 2470 mm.', 1100.00, 'Diesel', '2024', 5, '1742213344_Honda Amaze 2024 1.jpg', '1742213344_Honda Amaze 2024 2.jpg', '1742213344_Honda Amaze 2024 3.jpg', '1742213344_Honda Amaze 2024 4.jpeg', '1742213344_Honda Amaze 2024 5.jpeg', '1742213344_Honda Amaze 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 1, 1, '2025-03-17 12:09:04', '2025-03-17 12:09:48'),
(3, 'Toyota Innova Crysta', 3, 'The Toyota Innova Crysta has 1 Diesel Engine on offer. The Diesel engine is 2393 cc . It is available with Manual transmission.Depending upon the variant and fuel type the Innova Crysta has a mileage of 9 kmpl. The Innova Crysta is a 7 seater 4 cylinder car and has length of 4735 mm, width of 1830 mm and a wheelbase of 2750 mm.', 1800.00, 'Diesel', '2024', 7, '1742213540_Toyota Innova Crysta 2024 1.jpg', '1742213540_Toyota Innova Crysta 2024 2.jpg', '1742213540_Toyota Innova Crysta 2024 3.jpg', '1742213540_Toyota Innova Crysta 2024 4.jpeg', '1742213540_Toyota Innova Crysta 2024 5.jpeg', '1742213540_Toyota Innova Crysta 2024 6.jpg', 1, 1, 1, 1, 1, 1, '1', 1, 1, 1, 1, 1, '2025-03-17 12:12:20', '2025-03-17 16:40:46'),
(4, 'Hyundai Verna', 4, 'The Hyundai Verna has 2 Petrol Engine on offer. The Petrol engine is 1497 cc and 1482 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the Verna has a mileage of 18.6 to 20.6 kmpl. The Verna is a 5 seater 4 cylinder car and has length of 4535 mm, width of 1765 mm and a wheelbase of 2670 mm.', 1300.00, 'Petrol', '2024', 5, '1742213764_Hyundai Verna 2024 1.jpg', '1742213764_Hyundai Verna 2024 2.jpg', '1742213764_Hyundai Verna 2024 3.jpg', '1742213764_Hyundai Verna 2024 4.jpeg', '1742213764_Hyundai Verna 2024 5.jpeg', '1742213764_Hyundai Verna 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 1, 1, '2025-03-17 12:16:04', '2025-03-17 12:16:04'),
(5, 'Hyundai i20', 4, 'The Hyundai i20 has 1 Petrol Engine on offer. The Petrol engine is 1197 cc . It is available with Automatic & Manual transmission.Depending upon the variant and fuel type the i20 has a mileage of 16 to 20 kmpl. The i20 is a 5 seater 4 cylinder car and has length of 3995 mm, width of 1775 mm and a wheelbase of 2580 mm.', 1000.00, 'Petrol', '2024', 5, '1742213899_Hyundai I20 2024 1.jpg', '1742213899_Hyundai I20 2024 2.jpg', '1742213899_Hyundai I20 2024 3.jpg', '1742213899_Hyundai I20 2024 4.jpeg', '1742213899_Hyundai I20 2024 5.jpeg', '1742213899_Hyundai I20 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 0, 1, '2025-03-17 12:18:19', '2025-03-17 12:18:19'),
(6, 'Maruti Wagon R', 5, 'The Maruti Wagon R has 2 Petrol Engine and 1 CNG Engine on offer. The Petrol engine is 998 cc and 1197 cc while the CNG engine is 998 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the Wagon R has a mileage of 23.56 to 25.19 kmpl. The Wagon R is a 5 seater 4 cylinder car and has length of 3655 mm, width of 1620 mm and a wheelbase of 2435 mm.', 700.00, 'CNG', '2024', 5, '1742214012_Maruti Wagon R 2024 1.jpg', '1742214012_Maruti Wagon R 2024 2.jpg', '1742214012_Maruti Wagon R 2024 3.jpg', '1742214012_Maruti Wagon R 2024 4.jpeg', '1742214012_Maruti Wagon R 2024 5.jpeg', '1742214012_Maruti Wagon R 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 0, 1, '2025-03-17 12:20:12', '2025-03-17 12:20:12'),
(7, 'Tata Nexon', 1, 'The Tata Nexon has 1 Diesel Engine, 1 Petrol Engine and 1 CNG Engine on offer. The Diesel engine is 1497 cc, the Petrol engine is 1199 cc while the CNG engine is 1199 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the Nexon has a mileage of 17.01 to 24.08 kmpl & Ground clearance of Nexon is 208 mm. The Nexon is a 5 seater 4 cylinder car and has length of 3995 mm, width of 1804 mm and a wheelbase of 2498 mm.', 1400.00, 'Diesel', '2024', 5, '1742229466_Tata Nexon 2024 1.jpg', '1742229466_Tata Nexon 2024 2.jpg', '1742229466_Tata Nexon 2024 3.jpg', '1742229466_Tata Nexon 2024 4.jpeg', '1742229466_Tata Nexon 2024 5.jpeg', '1742229466_Tata Nexon 2024 6.jpg', 1, 1, 0, 0, 1, 1, '1', 1, 0, 0, 1, 1, '2025-03-17 16:37:46', '2025-03-17 16:40:27'),
(8, 'Tata Curvv', 1, 'The Tata Curvv has 1 Diesel Engine and 1 Petrol Engine on offer. The Diesel engine is 1497 cc while the Petrol engine is 1199 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the Curvv has a mileage of 11 to 15 kmpl & Ground clearance of Curvv is 208 mm. The Curvv is a 5 seater 4 cylinder car and has length of 4308 mm, width of 1810 mm and a wheelbase of 2560 mm.', 1600.00, 'Diesel', '2025', 5, '1742229613_Tata Curvv 2024 1.jpg', '1742229613_Tata Curvv 2024 2.jpg', '1742229613_Tata Curvv 2024 3.jpg', '1742229613_Tata Curvv 2024 4.jpeg', '1742229613_Tata Curvv 2024 5.jpeg', '1742229613_Tata Curvv 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 1, 1, '2025-03-17 16:40:13', '2025-03-17 16:40:13'),
(9, 'Maruti Dzire', 5, 'View image gallery of Maruti Dzire. Dzire has 63 photos and 360° view. Take a look at the front & rear view, side & top view & all the pictures of Dzire. Also Maruti Dzire is available in 7 colours.', 1500.00, 'Petrol', '2024', 5, '1742453008_Maruti Dzire 2024 1.jpg', '1742453008_Maruti Dzire 2024 2.jpg', '1742453008_Maruti Dzire 2024 3.jpg', '1742453008_Maruti Dzire 2024 4.jpeg', '1742453008_Maruti Dzire 2024 5.jpeg', '1742453008_Maruti Dzire 2024 6.jpg', 1, 1, 1, 0, 1, 1, '1', 1, 0, 0, 1, 0, '2025-03-20 06:43:28', '2025-03-20 06:43:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_number` (`booking_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
