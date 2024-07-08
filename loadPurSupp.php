<?php
// loadPurSupp.php
header('Content-Type: application/json');
include 'dbconnect.php'; // Include the database connection file

$query = $_GET['query'] ?? ''; // Get the query parameter from URL
$user_id = $_GET['user_id'] ?? 0; // Get the user_id parameter from URL, default to 0 if not provided
$query = "%$query%"; // Prepare query for LIKE statement

$stmt = $conn->prepare("SELECT supp_name FROM tbl_supplier WHERE supp_name LIKE ? AND user_id = ?");
$stmt->bind_param("ss", $query, $user_id); // Bind parameters for supp_name and user_id
$stmt->execute();

$result = $stmt->get_result();
$suppliers = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($suppliers);

$stmt->close();
$conn->close();
?>