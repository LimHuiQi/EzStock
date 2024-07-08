<?php
// getCustomerData.php
include 'dbconnect.php'; // Ensure you have a file to handle DB connection

$user_id = $_POST['user_id'];
$cust_id = $_POST['cust_id'];

$response = ['success' => false];

if (!empty($user_id) && !empty($cust_id)) {
    $query = "SELECT cust_id, user_id, cust_name, cust_email, cust_phone, cust_gender, cust_addr, cust_state FROM tbl_customer WHERE cust_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cust_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $response['success'] = true;
        $response['customer'] = $customer;
    } else {
        $response['error'] = 'No customer found with the given ID.';
    }
} else {
    $response['error'] = 'User ID or Customer ID is missing.';
}

echo json_encode($response);
?>