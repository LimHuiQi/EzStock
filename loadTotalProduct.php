<?php
// Include your database connection script
include 'dbconnect.php';

// Set the header to return JSON, which is what we expect on the client-side
header('Content-Type: application/json');

// Collect user ID from the POST request, assuming it's sent as JSON
$input = json_decode(file_get_contents('php://input'), true);
$user_id = $input['user_id'];

// Prepare a SQL query to count products data where prod_id starts with 'prod_id-' and matches the user_id
$sql = "SELECT COUNT(*) AS total FROM tbl_products WHERE prod_id LIKE 'Prod-%' AND user_id = ?";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared correctly
if ($stmt === false) {
    echo json_encode(['error' => 'Failed to prepare the statement']);
    exit;
}

// Bind the user ID to the prepared statement
$stmt->bind_param("s", $user_id);

// Execute the query
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Output the total count
echo json_encode(['total' => $row['total']]);

// Close statement and connection
$stmt->close();
$conn->close();
?>