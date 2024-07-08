<?php
include 'dbconnect.php'; // Include your existing database connection file

// Get the search term and user ID from the GET request
$searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : '';
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';

// Prepare the SQL query
$sql = "SELECT prod_name, prod_SKU, prod_barcode, prod_qty FROM tbl_products 
        WHERE (prod_name LIKE ? OR prod_SKU LIKE ? OR prod_barcode LIKE ?) AND user_id = ? LIMIT 10";

// Prepare the statement
if ($stmt = $conn->prepare($sql)) {
    // Bind parameters
    $param = "%$searchTerm%";
    $stmt->bind_param("ssss", $param, $param, $param, $userId);

    // Execute the query
    if ($stmt->execute()) {
        // Fetch all matching products
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);

        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode($products);
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

$conn->close();
?>