<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "visa_db";

// First connect without database
$conn = mysqli_connect($hostName, $dbUser, $dbPassword);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Create database if not exists
$createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbName";
if (mysqli_query($conn, $createDbQuery)) {
    // echo "Database created successfully or already exists";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Now connect with database
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Create tables if they don't exist
$createTables = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS visa_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100) NOT NULL,
    passport_number VARCHAR(50) NOT NULL,
    nationality VARCHAR(50) NOT NULL,
    visa_type VARCHAR(50) NOT NULL,
    application_date DATE NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);
";

// Execute table creation
if (mysqli_multi_query($conn, $createTables)) {
    do {
        // Store first result set
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($conn));
}

// echo "Database and tables ready!";
?>