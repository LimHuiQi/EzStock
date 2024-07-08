<?php
// Include database connection settings
require_once 'dbconnect.php'; // Adjust the path as needed

// Check if user_id is passed as a query parameter
if (!isset($_GET['user_id'])) {
    echo "User ID not provided";
    exit;
}

$user_id = $_GET['user_id'];

// Prepare and execute the query to count the products for the user
$stmt = $conn->prepare("SELECT COUNT(*) AS product_count FROM tbl_products WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the result
if ($row = $result->fetch_assoc()) {
    echo $row['product_count']; // Echo the count of products
} else {
    echo "0"; // Default to '0' if no records found
}

// Close statement and connection
$stmt->close();
$conn->close();
?>