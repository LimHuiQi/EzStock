<?php
// loadSalesCust.php
header('Content-Type: application/json');
include 'dbconnect.php'; // Include the database connection file

$query = $_GET['query'] ?? ''; // Get the query parameter from URL
$user_id = $_GET['user_id'] ?? 0; // Get the user_id parameter from URL, default to 0 if not provided
$query = "%$query%"; // Prepare query for LIKE statement

$stmt = $conn->prepare("SELECT cust_name FROM tbl_customer WHERE cust_name LIKE ? AND user_id = ?");
$stmt->bind_param("ss", $query, $user_id); // Bind parameters for cust_name and user_id
$stmt->execute();

$result = $stmt->get_result();
$customers = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($customers);

$stmt->close();
$conn->close();
?>