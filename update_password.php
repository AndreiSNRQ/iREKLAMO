<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $userId = $_SESSION['user_id'];

    try {
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $user = $stmt->fetch();

        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error_message'] = 'Current password is incorrect';
            header('Location: settings.php');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = 'New passwords do not match';
            header('Location: settings.php');
            exit;
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $stmt->execute([
            ':password' => $hashedPassword,
            ':user_id' => $userId
        ]);

        $_SESSION['success_message'] = 'Password updated successfully!';
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error updating password: ' . $e->getMessage();
    }
}

header('Location: settings.php');
exit;