<?php
// Include the database connection file
include 'dbconnect.php';

// Start the session to access session variables
session_start();

// Get JSON POST body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Debugging: Output the raw input and decoded data
file_put_contents("debug.txt", "Raw Input: " . $input . "\nDecoded Data: " . print_r($data, true));

$response = []; // Initialize an array to hold the response

if (is_array($data)) {
    foreach ($data as $entry) {
        // Prepare and bind the sales insert statement
        $stmt = $conn->prepare("INSERT INTO tbl_sales (user_id, cust_name, sales_id, sales_pdt, sales_date, sales_subtotal, sales_discount, sales_paid, sales_remark, sales_shipping, sales_type, sales_createdTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())");

        // Bind parameters
        $stmt->bind_param("ssssddddsds", $userId, $custName, $salesId, $salesPdt, $salesDate, $salesSubtotal, $salesDiscount, $salesPaid, $salesRemark, $salesShipping, $salesType);
        // Assign values from $data array
        $userId = $entry['userId'] ?? 'default-user_id';
        $custName = $entry['custName'];
        $salesId = $entry['salesOrderTitle'];
        $salesPdt = implode("\n", $entry['productDetails']);
        $salesDate = $entry['salesDateInput'];
        $salesSubtotal = $entry['subtotal'];
        $salesDiscount = $entry['totalDiscount'];
        $salesPaid = $entry['salesPaid'];
        $salesRemark = $entry['remark'];
        $salesShipping = $entry['shippingCharge'];
        $salesType = $entry['selectedValue'];

        // Execute the statement
        if ($stmt->execute()) {
            $response[] = ['success' => true, 'userId' => $userId];
            
            // Update product quantities in tbl_products
            foreach ($entry['productDetails'] as $productDetail) {
                // Assuming productDetail is in the format "SKU ----- Quantity"
                list($sku, $quantity) = explode(" ----- ", $productDetail);

                // Prepare the update statement for product quantity
                $updateStmt = $conn->prepare("UPDATE tbl_products SET prod_qty = prod_qty - ? WHERE prod_SKU = ?");
                $updateStmt->bind_param("ds", $quantity, $sku);

                // Execute the update statement
                if (!$updateStmt->execute()) {
                    $response[] = ['success' => false, 'error' => $updateStmt->error];
                }

                // Close the update statement
                $updateStmt->close();
            }
        } else {
            $response[] = ['success' => false, 'error' => $stmt->error];
        }

        // Close the sales insert statement
        $stmt->close();
    }
} else {
    $response[] = ['success' => false, 'error' => 'Invalid data'];
}

// Close the connection
$conn->close();

// Send JSON response
echo json_encode($response);
?>
