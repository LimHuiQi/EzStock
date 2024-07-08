<?php
include 'dbconnect.php';  // Ensure this file contains the necessary database connection setup
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['Current_Password'] ?? null;
    $newPassword = $_POST['New_Password'] ?? null;
    $confirmPassword = $_POST['Confirm_Password'] ?? null;
    $userId = $_POST['user_id'] ?? null;

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword) || empty($userId)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'New passwords do not match']);
        exit;
    }

    $stmt = $conn->prepare("SELECT user_pwd FROM tbl_users WHERE user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (!password_verify($currentPassword, $hashedPassword)) {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
        exit;
    }

    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateStmt = $conn->prepare("UPDATE tbl_users SET user_pwd = ? WHERE user_id = ?");
    $updateStmt->bind_param("ss", $newHashedPassword, $userId);
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update password']);
    }

    $stmt->close();
    $updateStmt->close();
}
?>