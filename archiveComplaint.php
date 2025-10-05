<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: complaints.php');
    exit;
}

$ids = $_POST['complaint_ids'] ?? [];
if (!is_array($ids) || count($ids) === 0) {
    $_SESSION['error'] = 'No complaints selected.';
    header('Location: complaints.php');
    exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "UPDATE complaint SET status = 'archived' WHERE id IN ($placeholders)";

try {
    $stmt = $conn->prepare($sql);
    // bind values
    foreach (array_values($ids) as $k => $v) {
        $stmt->bindValue($k+1, (int)$v, PDO::PARAM_INT);
    }
    $stmt->execute();
    $_SESSION['success'] = 'Selected complaints archived.';
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error archiving: ' . $e->getMessage();
}

header('Location: complaints.php');
exit;
