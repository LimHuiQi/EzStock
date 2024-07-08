<?php
include 'dbconnect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log(print_r($_POST, true));  // Debug POST data

    $userId = $_POST['user_id'] ?? null;
    $userName = $_POST['user_name'] ?? null;
    $userEmail = $_POST['user_email'] ?? null;
    $userPhone = $_POST['user_phone'] ?? null;
    $userBillingAddr = $_POST['user_billingAddr'] ?? null;  // Retrieve the billing address from POST data

    if (empty($userId) || empty($userName) || empty($userEmail) || empty($userPhone) || empty($userBillingAddr)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        exit;
    }

    // Update SQL query to include userBillingAddr
    $sql = "UPDATE tbl_users SET user_name = ?, user_email = ?, user_phone = ?, user_billingAddr = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters including userBillingAddr
        $stmt->bind_param("sssss", $userName, $userEmail, $userPhone, $userBillingAddr, $userId);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
    }
}
?>