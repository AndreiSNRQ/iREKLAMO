<?php require_once 'config.php'; // must provide $conn (PDO)

header('Content-Type: application/json; charset=utf-8');
try {
    $sql = "SELECT id, c_name AS complainant, r_name AS respondent, type AS blotter_type, details AS details, date_time FROM blotter WHERE status = 'resolved' ORDER BY date_time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $rows]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
?>