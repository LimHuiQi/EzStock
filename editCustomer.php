<?php
include 'dbconnect.php'; // Ensure this path is correct

header('Content-Type: application/json'); // Set the header to return JSON

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $cust_id = isset($_POST['cust_id']) ? $_POST['cust_id'] : null;
    $cust_name = isset($_POST['cust_name']) ? $_POST['cust_name'] : null;
    $cust_email = isset($_POST['cust_email']) ? $_POST['cust_email'] : null;
    $cust_phone = isset($_POST['cust_phone']) ? $_POST['cust_phone'] : null;
    $cust_gender = isset($_POST['cust_gender']) ? $_POST['cust_gender'] : null;
    $cust_addr = isset($_POST['cust_addr']) ? $_POST['cust_addr'] : null;
    $cust_state = isset($_POST['cust_state']) ? $_POST['cust_state'] : null;

    // Prepare an update statement
    $sql = "UPDATE tbl_customer SET cust_name=?, cust_email=?, cust_phone=?, cust_gender=?, cust_addr=?, cust_state=? WHERE cust_id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'MySQL prepare error: ' . $conn->error]);
        exit;
    }

    // Bind parameters to statement
    $stmt->bind_param("sssssss", $cust_name, $cust_email, $cust_phone, $cust_gender, $cust_addr, $cust_state, $cust_id);

    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No changes were made or customer not found.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>