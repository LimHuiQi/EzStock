<?php
include 'dbconnect.php'; // Ensure this file sets up a database connection correctly

// Function to handle file upload
function uploadFile($file, $conn, $prod_name, $suffix, $user_id) {
    if (empty($file) || $file['error'] != UPLOAD_ERR_OK) {
        echo "No file uploaded or upload error.";
        return null;
    }

    $target_dir = "uploads/products/";
    $newFileName = $user_id . ' - ' . $prod_name . '-' . $suffix . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $newFileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    if (!file_exists($file["tmp_name"]) || !is_uploaded_file($file["tmp_name"])) {
        echo "File does not exist on the temporary path or is not an uploaded file.";
        $uploadOk = 0;
    } else {
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ". ";
        } else {
            echo "File is not an image. ";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($file["size"] > 500000) { // 500KB limit
        echo "Sorry, your file is too large. ";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded. ";
        return null; // Return null if the upload failed
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars($newFileName) . " has been uploaded. ";
            return $target_file; // Return the file path if the upload was successful
        } else {
            echo "Sorry, there was an error uploading your file. ";
            return null;
        }
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $prod_name = $_POST['prod_name'];
    $user_id = $_POST['user_id']; // Ensure user_id is retrieved from POST data

    // Handle file uploads
    $prod_img1 = isset($_FILES['prod_img1']) ? uploadFile($_FILES['prod_img1'], $conn, $prod_name, '1', $user_id) : null;

    // Generate prod_id
    $idQuery = "SELECT MAX(CAST(SUBSTRING(prod_id, 6) AS UNSIGNED)) AS max_id FROM tbl_products WHERE prod_id LIKE 'Prod-%'";
    $idStmt = $conn->prepare($idQuery);
    $idStmt->execute();
    $idResult = $idStmt->get_result();
    $idRow = $idResult->fetch_assoc();
    $nextIdNumber = ($idRow['max_id'] ?? 0) + 1; // Start at 1 if no existing prod_id found
    $prod_id = "Prod-" . $nextIdNumber;

    // Retrieve other form data
    $prod_category = $_POST['prod_category'];
    $prod_brand = $_POST['prod_brand'];
    $prod_SKU = $_POST['prod_SKU'];
    $prod_desc = $_POST['prod_desc'];
    $prod_price = $_POST['prod_price'];
    $prod_discount = $_POST['prod_discount'];
    $prod_barcode = $_POST['prod_barcode'];
    $user_id = $_POST['user_id'];
    $prod_qty = $_POST['prod_qty'];  // Retrieve product quantity from POST data


    // SQL query to insert data into tbl_products
    $sql = "INSERT INTO tbl_products (prod_id, prod_img1, prod_name, prod_category, prod_brand, prod_SKU, prod_qty, prod_desc, prod_price, prod_discount, prod_barcode, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssisddss", $prod_id, $prod_img1, $prod_name, $prod_category, $prod_brand, $prod_SKU, $prod_qty, $prod_desc, $prod_price, $prod_discount, $prod_barcode, $user_id);
    // At the end of your form processing logic, after the product is successfully added
    if ($stmt->execute()) {
        // Redirect to the same page or to a confirmation page
        header("Location: product.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>