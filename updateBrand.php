<?php
// updateBrand.php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['brand_name'])) {
    $brandName = $_POST['brand_name'];
    $brandDesc = $_POST['brand_desc'];
    $brandStatus = $_POST['brand_status']; // Retrieve the brand status from the form

    // Prepare SQL statement to update the brand details
    $stmt = $conn->prepare("UPDATE tbl_brands SET brand_name = ?, brand_desc = ?, brand_status = ? WHERE brand_name = ?");
    // Correct the types in bind_param: all are strings ('ssss')
    $stmt->bind_param("ssss", $brandName, $brandDesc, $brandStatus, $brandName);

    if ($stmt->execute()) {
        echo "Brand updated successfully.";
        // Optionally redirect back to a listing page or elsewhere
        header('Location: brands.html');
    } else {
        echo "Error updating brand: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
$conn->close();
?>