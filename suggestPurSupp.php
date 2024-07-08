<?php
include 'dbconnect.php'; // Ensure this file sets up a connection to your database

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? '';
$partial_name = $_GET['partial_name'] ?? '';

$query = "SELECT supp_name FROM tbl_supplier WHERE user_id = ? AND supp_name LIKE ?";
$stmt = $conn->prepare($query);
$like_partial_name = '%' . $partial_name . '%';
$stmt->bind_param("ss", $user_id, $like_partial_name);
$stmt->execute();
$result = $stmt->get_result();

$names = [];
while ($row = $result->fetch_assoc()) {
    $names[] = $row['supp_name'];
}

echo json_encode($names);

$stmt->close();
$conn->close();
?>