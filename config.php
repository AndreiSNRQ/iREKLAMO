<?php

// config.php
$dsn = "mysql:host=localhost:3306;dbname=barangay;charset=utf8mb4";
$user = "root";
$pass = ""; // Default XAMPP password is blank
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If connection fails, show the error
    die("Connection failed: " . $e->getMessage());
}

?>