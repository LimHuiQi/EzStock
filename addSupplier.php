<?php
include 'dbconnect.php'; // Include database connection file

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suppName = $_POST['supp_name'];
    $suppEmail = $_POST['supp_email'];
    $suppPhone = $_POST['supp_phone'];
    $suppAddr = $_POST['supp_addr'];
    $suppState = $_POST['supp_state'];
    $suppDesc = isset($_POST['supp_desc']) ? $_POST['supp_desc'] : '';
    $userId = $_POST['user_id'];

    // Validate that all fields are filled
    if (empty($suppName) || empty($suppEmail) || empty($suppPhone) || empty($suppAddr) || empty($suppState) || empty($userId)) {
        echo json_encode(['success' => false, 'error' => 'All fields must be filled out.']);
        exit;
    }

    // Validate email format
    if (!filter_var($suppEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
        exit;
    }

    // Validate phone number (digits only, length 10-11)
    if (!preg_match('/^\d{9,11}$/', $suppPhone)) {
        echo json_encode(['success' => false, 'error' => 'Phone number must be 10 to 11 digits.']);
        exit;
    }

    // Check if the supplier name already exists for the given user_id
    $stmt = $conn->prepare("SELECT * FROM tbl_supplier WHERE supp_name = ? AND user_id = ?");
    $stmt->bind_param("ss", $suppName, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Supplier name already exists. Please use a different name.']);
        exit; // Stop execution if supplier name already exists
    }
    $stmt->close();

    // Generate supp_id based on user_id
    $idQuery = "SELECT MAX(CAST(SUBSTRING(supp_id, 6) AS UNSIGNED)) AS max_id FROM tbl_supplier WHERE supp_id LIKE 'Supp-%' AND user_id = ?";
    $idStmt = $conn->prepare($idQuery);
    $idStmt->bind_param("s", $userId);
    $idStmt->execute();
    $idResult = $idStmt->get_result();
    $idRow = $idResult->fetch_assoc();
    $nextIdNumber = ($idRow['max_id'] ?? 0) + 1; // Start at 1 if no existing supp_id found
    $suppId = "Supp-" . $nextIdNumber;

    // Insert supplier details into the database
    $stmt = $conn->prepare("INSERT INTO tbl_supplier (supp_id, supp_name, supp_email, supp_phone, supp_addr, supp_state, supp_desc, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $suppId, $suppName, $suppEmail, $suppPhone, $suppAddr, $suppState, $suppDesc, $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
}
?>