<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $captain = $_POST['captain'];
    $secretary = $_POST['secretary'];
    $kagawad = $_POST['kagawad'];
    $president = $_POST['president'] ?? '';
    $vp = $_POST['vp'] ?? '';

    try {
        // First clear existing officials
        $conn->exec("DELETE FROM barangay_officials");
        
        // Insert new officials
        $stmt = $conn->prepare("INSERT INTO barangay_officials (position, name) VALUES 
                              ('Captain', :captain),
                              ('Secretary', :secretary),
                              ('Kagawad', :kagawad),
                              ('President', :president),
                              ('Vice President', :vp)");
        $stmt->execute([
            ':captain' => $captain,
            ':secretary' => $secretary,
            ':kagawad' => $kagawad,
            ':president' => $president,
            ':vp' => $vp
        ]);

        $_SESSION['success_message'] = 'alert-success Officials updated successfully!';
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error updating officials: ' . $e->getMessage();
    }
}

header('Location: settings.php');
exit;