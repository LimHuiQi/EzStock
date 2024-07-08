<?php
include 'dbconnect.php'; // Include database connection file

// Function to delete a category by name
function deleteCategory($name) {
    global $conn;

    // First, retrieve the image filename associated with the category name
    $sql = "SELECT ctg_img FROM tbl_category WHERE ctg_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($imageFilename);
    $stmt->fetch();
    $stmt->close();

    // Delete the category data from the database
    $sqlDelete = "DELETE FROM tbl_category WHERE ctg_name = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $name);

    // Delete the image file if it exists
    if ($stmtDelete->execute()) {
        if ($imageFilename && file_exists("uploads/category/$imageFilename")) {
            unlink("uploads/category/$imageFilename");
        }
        return true; // Category deleted successfully
    } else {
        error_log("Error deleting category: " . $stmtDelete->error);
        return false; // Failed to delete category
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $categoryName = $data['categoryName'];

    if (deleteCategory($categoryName)) {
        echo "Category deleted successfully.";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Failed to delete category. Check server logs for more details.";
    }
}
?>
