<?php
include 'dbconnect.php'; // Ensure this file sets up a connection to your database

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? ''; // Retrieve user_id from the query string
$cust_name = $_GET['cust_name'] ?? ''; // Retrieve cust_name from the query string

$query = "SELECT cust_id FROM tbl_customer WHERE user_id = ? AND cust_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user_id, $cust_name); // Bind both user_id and cust_name
$stmt->execute();
$stmt->bind_result($cust_id);
$result = $stmt->fetch();

if ($result) {
    echo json_encode(['exists' => true, 'cust_id' => $cust_id]);
} else {
    echo json_encode(['exists' => false]);
}

$stmt->close();
$conn->close();
?>