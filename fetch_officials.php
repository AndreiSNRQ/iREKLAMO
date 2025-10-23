<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT position, name FROM barangay_officials");
    $officials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $result = [];
    foreach ($officials as $official) {
        $position = strtolower($official['position']);
        $result[$position] = $official['name'];
    }
    
    // Ensure all expected positions are included
    $positions = ['captain', 'secretary', 'kagawad', 'president', 'vp'];
    foreach ($positions as $position) {
        if (!isset($result[$position])) {
            $result[$position] = '';
        }
    }
    
    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Failed to fetch officials: ' . $e->getMessage()]);
}
?>