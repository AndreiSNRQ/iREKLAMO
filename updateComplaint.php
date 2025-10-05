<?php
// updateComplaint.php
require_once 'config.php'; // must define $conn as PDO

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

if (!$id || $status === '') {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    $conn->beginTransaction();

    // If transferring to blotter, insert into blotter and set complaint.status = 'transfer'
    if ($status === 'transfer') {
        // Insert into blotter selecting from complaint (map columns)
        $insertSql = "
            INSERT INTO blotter
              (c_name, c_contact, c_address, r_name, r_contact, r_address, type, details, location, date_time, status, created_by)
            SELECT c_name, c_contact, c_address, r_name, r_contact, r_address, type, details, location, date_time, 'pending', created_by
              FROM complaint WHERE id = :id
            ";
        $stmt = $conn->prepare($insertSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Update complaint status to transfer
        $up = $conn->prepare("UPDATE complaint SET status = 'transfer' WHERE id = :id");
        $up->bindParam(':id', $id, PDO::PARAM_INT);
        $up->execute();

    } else {
        // Only update status (no other fields)
        $up = $conn->prepare("UPDATE complaint SET status = :status WHERE id = :id");
        $up->bindParam(':status', $status, PDO::PARAM_STR);
        $up->bindParam(':id', $id, PDO::PARAM_INT);
        $up->execute();
    }

$conn->commit();
    echo json_encode(['success' => true, 'message' => 'Complaint updated successfully.', 'redirect' => 'complaints.php']);
    exit;
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}