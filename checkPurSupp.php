<?php
include 'dbconnect.php'; // Ensure this file sets up a connection to your database

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? ''; // Retrieve user_id from the query string
$supp_name = $_GET['supp_name'] ?? ''; // Retrieve supp_name from the query string

$query = "SELECT supp_id FROM tbl_supplier WHERE user_id = ? AND supp_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user_id, $supp_name); // Bind both user_id and supp_name
$stmt->execute();
$stmt->bind_result($supp_id);
$result = $stmt->fetch();

if ($result) {
    echo json_encode(['exists' => true, 'supp_id' => $supp_id]);
} else {
    echo json_encode(['exists' => false]);
}

$stmt->close();
$conn->close();
?>