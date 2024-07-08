<?php
include 'dbconnect.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['ctg_name'];
    $categoryDesc = $_POST['ctg_desc'];
    $userId = $_POST['user_id'];

    // Check if the category name already exists
    $checkQuery = "SELECT * FROM tbl_category WHERE ctg_name = '$categoryName' AND user_id = '$userId'";
    $checkResult = $conn->query($checkQuery);
    if ($checkResult->num_rows > 0) {
        echo '<script>
                alert("Category name already exists. Please choose a different name.");
                window.location.href="categories.html";
              </script>';
        exit; // Stop execution further if category name already exists
    }

    // Handle file upload
    if (isset($_FILES['ctg_img']) && $_FILES['ctg_img']['error'] == 0) {
        $fileTmpPath = $_FILES['ctg_img']['tmp_name'];
        $fileName = $_FILES['ctg_img']['name'];
        $fileSize = $_FILES['ctg_img']['size'];
        $fileType = $_FILES['ctg_img']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file-name
        $newFileName = preg_replace('/[^A-Za-z0-9\-]/', '', $userId . '-' . $categoryName) . '.' . 'png';        // Directory in which the uploaded file will be moved
        $uploadFileDir = 'uploads/category/';
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // Insert category details into the database including user_id
            $sql = "INSERT INTO tbl_category (ctg_name, ctg_desc, ctg_img, user_id)
                    VALUES ('$categoryName', '$categoryDesc', '$newFileName', '$userId')";

            if ($conn->query($sql) === TRUE) {
                echo '<script>
                        alert("Category successfully added!");
                        window.location.href="category.html";
                      </script>';
            } else {
                echo '<script>
                        alert("Error: ' . $sql . '<br>' . $conn->error . '");
                        window.location.href="category.html";
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Error uploading the file.");
                    window.location.href="category.html";
                  </script>';
        }
    }
}
?>