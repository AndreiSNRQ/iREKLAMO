<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $userId = $_SESSION['user_id'];

    try {
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :user_id");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':user_id' => $userId
        ]);

        $_SESSION['success_message'] = 'Profile updated successfully!';
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error updating profile: ' . $e->getMessage();
    }
}

header('Location: settings.php');
exit;