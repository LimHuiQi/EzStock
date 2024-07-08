<?php
include 'dbconnect.php'; // Include database connection file

header('Content-Type: application/json');

// Function to delete a supplier by name
function deleteSupplier($suppName) {
    global $conn;

    // Prepare a SQL query to delete the supplier
    $sql = "DELETE FROM tbl_supplier WHERE supp_name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        return false;
    }
    $stmt->bind_param("s", $suppName);
    
    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return true; // Supplier deleted successfully
        } else {
            return false; // No supplier found with the given name
        }
    } else {
        error_log("Error executing delete: " . $stmt->error);
        return false; // Failed to delete supplier
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $supplierName = $data['supp_name'];

    if (empty($supplierName)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Supplier Name is required.']);
        exit;
        
    }

    if (deleteSupplier($supplierName)) {
        echo json_encode(['success' => true, 'message' => 'Supplier deleted successfully.']);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'error' => 'Failed to delete supplier. No supplier found with the given name.']);
    }
}
?>