<?php
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    try {
        $stmt = $conn->prepare("UPDATE complaint SET status = 'active' WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(["success" => true, "message" => "Complaint restored successfully."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
