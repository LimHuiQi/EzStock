<?php
include 'dbconnect.php'; // Include database connection file

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $custName = $_POST['cust_name'];
    $custGender = isset($_POST['cust_gender']) ? $_POST['cust_gender'] : '';
    $custEmail = $_POST['cust_email'];
    $custPhone = $_POST['cust_phone'];
    $custAddr = $_POST['cust_addr'];
    $custState = $_POST['cust_state'];
    $userId = $_POST['user_id'];

    // Validate that all fields are filled
    if (empty($custName) || empty($custGender) || empty($custEmail) || empty($custPhone) || empty($custAddr) || empty($custState) || empty($userId)) {
        echo json_encode(['success' => false, 'error' => 'All fields must be filled out.']);
        exit;
    }

    // Validate email format
    if (!filter_var($custEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
        exit;
    }

    // Validate phone number (digits only, length 10-11)
    if (!preg_match('/^\d{9,11}$/', $custPhone)) {
        echo json_encode(['success' => false, 'error' => 'Phone number must be 10 to 11 digits.']);
        exit;
    }

    // Check if the customer name already exists for the selected user_id
    $stmt = $conn->prepare("SELECT * FROM tbl_customer WHERE cust_name = ? AND user_id = ?");
    $stmt->bind_param("ss", $custName, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Customer name already exists for this user. Please use a different name.']);
        exit; // Stop execution if customer name already exists for this user
    }
    $stmt->close();
    
    // Generate cust_id based on user_id
    $idQuery = "SELECT MAX(CAST(SUBSTRING(cust_id, 6) AS UNSIGNED)) AS max_id FROM tbl_customer WHERE cust_id LIKE 'Cust-%' AND user_id = ?";
    $idStmt = $conn->prepare($idQuery);
    $idStmt->bind_param("s", $userId);
    $idStmt->execute();
    $idResult = $idStmt->get_result();
    $idRow = $idResult->fetch_assoc();
    $nextIdNumber = ($idRow['max_id'] ?? 0) + 1; // Start at 1 if no existing cust_id found
    $custId = "Cust-" . $nextIdNumber;

    // Insert customer details into the database
    $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_id, cust_name, cust_gender, cust_email, cust_phone, cust_addr, cust_state, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $custId, $custName, $custGender, $custEmail, $custPhone, $custAddr, $custState, $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
}
?>