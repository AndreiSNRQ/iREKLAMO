<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Blotter ID is required']);
    exit;
}

$id = (int)$_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM blotter WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $blotter = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($blotter) {
        echo json_encode(['success' => true, 'data' => $blotter]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Blotter not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>