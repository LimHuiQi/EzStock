<?php
include 'dbconnect.php'; // Include database connection file

// Function to delete a brand by name
function deleteBrand($name) {
    global $conn;

    // First, retrieve the image filename associated with the brand name
    $sql = "SELECT brand_img FROM tbl_brands WHERE brand_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($imageFilename);
    $stmt->fetch();
    $stmt->close();

    // Delete the brand data from the database
    $sqlDelete = "DELETE FROM tbl_brands WHERE brand_name = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $name);

    // Delete the image file if it exists
    if ($stmtDelete->execute()) {
        if ($imageFilename && file_exists("uploads/brands/$imageFilename")) {
            unlink("uploads/brands/$imageFilename");
        }
        return true; // Brand deleted successfully
    } else {
        error_log("Error deleting brand: " . $stmtDelete->error);
        return false; // Failed to delete brand
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $brandName = $data['brandName'];

    if (deleteBrand($brandName)) {
        echo "Brand deleted successfully.";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Failed to delete brand. Check server logs for more details.";
    }
}
?>
