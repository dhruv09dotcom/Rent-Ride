CREATE DATABASE rent_ride;
USE rent_ride;

-- Admin Table --
CREATE TABLE Admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO Admin (username, password) VALUES 
('Admin', 'admin@123');

-- User Table --
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    pincode VARCHAR(10) NOT NULL
    state VARCHAR(100) NOT NULL
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reset_token VARCHAR(100) NULL,
    token_expiry DATETIME NULL
);

-- Brands Table --
CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand_name VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Vehicles Table --
CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_title VARCHAR(255) NOT NULL,
    brand_id INT NOT NULL,
    vehicle_overview TEXT NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    fuel_type VARCHAR(50) NOT NULL,
    model_year YEAR NOT NULL,
    seating_capacity INT NOT NULL,
    image1 TEXT NULL,  -- Using TEXT for longer file paths
    image2 TEXT NULL,
    image3 TEXT NULL,
    image4 TEXT NULL,
    image5 TEXT NULL,
    image6 TEXT NULL,
    air_conditioner TINYINT NULL,
    power_steering TINYINT NULL,
    cd_player TINYINT NULL,
    power_door_locks TINYINT NULL,
    driver_airbag TINYINT NULL,
    central_locking TINYINT NULL,
    antilock_braking_system TINYINT NULL,
    passenger_airbag TINYINT NULL,
    crash_sensor TINYINT NULL,
    brake_assist TINYINT NULL,
    power_windows TINYINT NULL,
    leather_seats TINYINT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES Brands(id) ON DELETE CASCADE
);

-- Booking Table --
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_number VARCHAR(20) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    vehicle_id INT NOT NULL,
    from_date DATE NOT NULL,
    to_date DATE NOT NULL,
    message TEXT DEFAULT NULL,
    status ENUM('new', 'confirmed', 'cancelled') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES Vehicles(id) ON DELETE CASCADE
);

-- Contact Queries Table --
CREATE TABLE contact_queries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact Info --
CREATE TABLE contact_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contact_number VARCHAR(20) NOT NULL
);

INSERT INTO contact_info (address, email, contact_number) 
VALUES ('D&M Block, Alpesh Complex', 'info@rentride.com', '+91 98765 43210');