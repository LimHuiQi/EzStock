<?php
// Include your database connection script
include 'dbconnect.php';

// Set the header to return JSON, which is what we expect on the client-side
header('Content-Type: application/json');

// Collect user ID from the POST request, assuming it's sent as JSON
$input = json_decode(file_get_contents('php://input'), true);
$user_id = $input['user_id'];

$sql = "SELECT * FROM tbl_supplier WHERE user_id = ? AND supp_id LIKE 'Supp-%'";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared correctly
if ($stmt === false) {
    echo json_encode(['error' => 'Failed to prepare the statement']);
    exit;
}

// Bind the user ID to the prepared statement and execute it
$stmt->bind_param("s", $user_id);
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

// Check if we have any rows returned
if ($result->num_rows > 0) {
    // Fetch all suppliers as an associative array
    $suppliers = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($suppliers);
} else {
    // No suppliers found for this user
    echo json_encode(['error' => 'No suppliers found']);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>