<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

$id = $_POST['id'] ?? null;
$new_status = $_POST['new_status'] ?? null;

if (!$id || !$new_status) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE blotter SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $id]);
    
    echo json_encode(['success' => true, 'refresh' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}