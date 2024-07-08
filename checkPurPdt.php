<?php
include 'dbconnect.php';

$searchTerm = $_GET['searchTerm'] ?? '';
$user_id = $_GET['user_id'] ?? null;

if (empty($searchTerm) || is_null($user_id)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required parameters"]);
    exit;
}

$sql = "SELECT prod_SKU, prod_name, prod_brand, prod_category, prod_price, prod_discount FROM tbl_products 
        WHERE (prod_SKU = ? OR prod_barcode = ?) AND user_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $user_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($products);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to execute query: " . $stmt->error]);
    }
    $stmt->close();
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare query: " . $conn->error]);
}

$conn->close();
?>