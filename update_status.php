<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = intval($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');

    if ($id > 0 && in_array($status, ['summon', 'cfa'])) {
        $stmt = $conn->prepare("UPDATE blotter SET status = :status, updated_at = NOW() WHERE id = :id");
        $stmt->execute([':status' => $status, ':id' => $id]);
    }
}
?>
