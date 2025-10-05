<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("You must be logged in to add a complaint.");
        }

        // Validate required fields
        $required = ['c_name', 'r_name', 'details', 'location'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("$field is required.");
            }
        }

        $c_name    = $_POST['c_name'];
        $c_contact = $_POST['c_contact'] ?? '';
        $c_address = $_POST['c_address'] ?? '';
        $r_name    = $_POST['r_name'];
        $r_contact = $_POST['r_contact'] ?? '';
        $r_address = $_POST['r_address'] ?? '';
        $type      = $_POST['type'] ?? 'Others';
        $details   = $_POST['details'];
        $location  = $_POST['location'];
        $date_time = $_POST['date_time'] ?? date('Y-m-d H:i:s');
        $status    = "Active";
        $created_by = $_SESSION['user_id'];

        $sql = "INSERT INTO complaint 
            (c_name, c_contact, c_address, r_name, r_contact, r_address, type, details, location, date_time, status, created_by)
            VALUES (:c_name, :c_contact, :c_address, :r_name, :r_contact, :r_address, :type, :details, :location, :date_time, :status, :created_by)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':c_name' => $c_name,
            ':c_contact' => $c_contact,
            ':c_address' => $c_address,
            ':r_name' => $r_name,
            ':r_contact' => $r_contact,
            ':r_address' => $r_address,
            ':type' => $type,
            ':details' => $details,
            ':location' => $location,
            ':date_time' => $date_time,
            ':status' => $status,
            ':created_by' => $created_by
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Complaint added successfully.'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit();
}
?>