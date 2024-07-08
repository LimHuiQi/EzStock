<?php
include 'dbconnect.php'; // Include database connection file

header('Content-Type: application/json');

// Function to delete a customer by name
function deleteCustomer($custName) {
    global $conn;

    // Prepare a SQL query to delete the customer
    $sql = "DELETE FROM tbl_customer WHERE cust_name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        return false;
    }
    $stmt->bind_param("s", $custName);
    
    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return true; // Customer deleted successfully
        } else {
            return false; // No customer found with the given name
        }
    } else {
        error_log("Error executing delete: " . $stmt->error);
        return false; // Failed to delete customer
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $customerName = $data['cust_name'];

    if (empty($customerName)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Customer Name is required.']);
        exit;
    }

    if (deleteCustomer($customerName)) {
        echo json_encode(['success' => true, 'message' => 'Customer deleted successfully.']);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'error' => 'Failed to delete customer. No customer found with the given name.']);
    }
}
?>