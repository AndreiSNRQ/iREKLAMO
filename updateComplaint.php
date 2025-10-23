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

// Extract all other editable fields
$complainant_name = isset($_POST['complainant_name']) ? trim($_POST['complainant_name']) : '';
// Removed: $complainant_address = isset($_POST['complainant_address']) ? trim($_POST['complainant_address']) : '';
// Removed: $complainant_contact = isset($_POST['complainant_contact']) ? trim($_POST['complainant_contact']) : '';
$respondent_name = isset($_POST['respondent_name']) ? trim($_POST['respondent_name']) : '';
// Removed: $respondent_address = isset($_POST['respondent_address']) ? trim($_POST['respondent_address']) : '';
// Removed: $respondent_contact = isset($_POST['respondent_contact']) ? trim($_POST['respondent_contact']) : '';
$type = isset($_POST['type']) ? trim($_POST['type']) : '';
$details = isset($_POST['details']) ? trim($_POST['details']) : '';
$location = isset($_POST['location']) ? trim($_POST['location']) : '';
$date_time = isset($_POST['date_time']) ? trim($_POST['date_time']) : '';


if (!$id || $status === '') {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    $conn->beginTransaction();

    // If transferring to blotter, insert into blotter and set complaint.status = 'transfer'
    if ($status === 'blotter') {
        // Insert into blotter selecting from complaint (map columns)
        $insertSql = "
            INSERT INTO blotter
              (c_name, c_contact, c_address, r_name, r_contact, r_address, type, details, location, date_time, status, created_by, updated_at)
            SELECT c_name, c_contact, c_address, r_name, r_contact, r_address, type, details, location, date_time, 'summon', created_by, NOW()
              FROM complaint WHERE id = :id
            ";
        $stmt = $conn->prepare($insertSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the complaint from the complaint table
        $deleteSql = "DELETE FROM complaint WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $deleteStmt->execute();

    } else {
        // Update all editable fields including status
        $up = $conn->prepare("UPDATE complaint SET
            c_name = :complainant_name,
            -- Removed: c_address = :complainant_address,
            -- Removed: c_contact = :complainant_contact,
            r_name = :respondent_name,
            -- Removed: r_address = :respondent_address,
            -- Removed: r_contact = :respondent_contact,
            type = :type,
            details = :details,
            location = :location,
            date_time = :date_time,
            status = :status
            WHERE id = :id");

        $up->bindParam(':complainant_name', $complainant_name, PDO::PARAM_STR);
        // Removed: $up->bindParam(':complainant_address', $complainant_address, PDO::PARAM_STR);
        // Removed: $up->bindParam(':complainant_contact', $complainant_contact, PDO::PARAM_STR);
        $up->bindParam(':respondent_name', $respondent_name, PDO::PARAM_STR);
        // Removed: $up->bindParam(':respondent_address', $respondent_address, PDO::PARAM_STR);
        // Removed: $up->bindParam(':respondent_contact', $respondent_contact, PDO::PARAM_STR);
        $up->bindParam(':type', $type, PDO::PARAM_STR);
        $up->bindParam(':details', $details, PDO::PARAM_STR);
        $up->bindParam(':location', $location, PDO::PARAM_STR);
        $up->bindParam(':date_time', $date_time, PDO::PARAM_STR);
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