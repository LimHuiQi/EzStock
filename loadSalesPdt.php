<?php
// Include the database connection file
include 'dbconnect.php';

// Get the search term from the request
$searchTerm = $_GET['searchTerm'];

// Prepare and execute the SQL query
$sql = "SELECT prod_id, prod_sku, prod_name, prod_price, prod_discount FROM tbl_products WHERE prod_sku = ? OR prod_barcode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the results
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($products);

// Close the connection
$stmt->close();
$conn->close();
?>