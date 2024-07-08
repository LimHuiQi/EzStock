<?php
// Include your database connection script
include 'dbconnect.php';

// Set the header to return JSON, which is what we expect on the client-side
header('Content-Type: application/json');

// Collect user ID from the POST request, assuming it's sent as JSON
$input = json_decode(file_get_contents('php://input'), true);
$user_id = $input['user_id'];

// Prepare a SQL query to fetch customer data based on the user ID and cust_id starting with 'Cust-'
$sql = "SELECT * FROM tbl_customer WHERE user_id = ? AND cust_id LIKE 'Cust-%'";
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
    // Fetch all customers as an associative array
    $customers = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($customers);
} else {
    // No customers found for this user
    echo json_encode(['error' => 'No customers found']);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>