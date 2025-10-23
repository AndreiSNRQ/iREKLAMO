<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT * FROM blotter WHERE status IN ('resolved', 'withdraw') ORDER BY date_time DESC");
    $stmt->execute();
    $blotters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $blotters
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching archived blotters: ' . $e->getMessage()
    ]);
}