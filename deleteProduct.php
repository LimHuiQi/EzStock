<?php
include 'dbconnect.php'; // Include database connection file

header('Content-Type: application/json');

// Function to delete a product by name and user_id
function deleteProduct($prodName, $userId) {
    global $conn;

    // Prepare a SQL query to delete the product for a specific user
    $sql = "DELETE FROM tbl_products WHERE prod_name = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        return false;
    }
    $stmt->bind_param("ss", $prodName, $userId);
    
    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return true; // Product deleted successfully
        } else {
            return false; // No product found with the given name for this user
        }
    } else {
        error_log("Error executing delete: " . $stmt->error);
        return false; // Failed to delete product
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $prodName = $data['prod_name'];
    $userId = $data['user_id']; // Assuming user_id is passed in the request

    if (empty($prodName) || empty($userId)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Product name and user ID are required.']);
        exit;
    }

    if (deleteProduct($prodName, $userId)) {
        echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'error' => 'Failed to delete product. No product found with the given name for this user.']);
    }
}
?>