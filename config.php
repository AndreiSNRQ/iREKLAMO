<?php
// $host = 'localhost:3307';
// $dbname = 'barangay'; // Make sure this matches your actual DB name
// $username = 'root';
// $password = ''; // Add your password if set

// try {
//     $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }

// config.php
$dsn = "mysql:host=localhost:3307;dbname=barangay;charset=utf8mb4";
$user = "root";
$pass = "";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
$conn = new PDO($dsn, $user, $pass, $options);
?>