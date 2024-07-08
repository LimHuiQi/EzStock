<?php
// Include database connection file
include_once 'dbconnect.php';

// Get JSON POST body and decode it
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); // Convert JSON into array

// Log the received JSON for debugging
file_put_contents('log.txt', $inputJSON);

// Check if user_id is provided
if (!isset($input['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
    exit;
}

$user_id = $input['user_id'];

// Prepare SQL query to fetch user details
$query = "SELECT user_name, user_email, user_phone, user_billingAddr FROM tbl_users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id); // 's' specifies the variable type 'string'

// Execute the query
$stmt->execute();
$result = $stmt->get_result();  // Corrected from 'get result()' to 'get_result()'

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(['success' => true, 'user_name' => $user['user_name'], 'user_email' => $user['user_email'], 'user_phone' => $user['user_phone'], 'user_billingAddr' => $user['user_billingAddr']]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>