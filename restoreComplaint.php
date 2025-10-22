<?php
// Assuming database connection is in config.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    try {
        // Update complaint status from 'archived' to 'active' (adjust based on your schema)
        $query = "UPDATE complaint SET status = 'active' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Complaint restored successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to restore complaint: ' . $e->getMessage()]);
    }
    
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>