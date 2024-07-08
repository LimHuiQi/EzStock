<?php
include 'dbconnect.php'; // Ensure this file sets up a database connection correctly

header('Content-Type: application/json');

// Get the JSON input from the client
$input = json_decode(file_get_contents('php://input'), true);

// Check if user_id is provided
if (!isset($input['user_id'])) {
    echo json_encode(['error' => 'User ID not provided']);
    exit;
}

$user_id = $input['user_id'];

// Prepare the query to select brands for the specific user_id
$query = "SELECT brand_name FROM tbl_brands WHERE user_id = ? AND brand_status = 'Active'";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    exit;
}

// Bind the user_id to the prepared statement
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$brands = [];
while ($row = $result->fetch_assoc()) {
    $brands[] = $row;
}

$stmt->close();
$conn->close();

// Output the brands as JSON
echo json_encode($brands);
?>