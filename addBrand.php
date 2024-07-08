<?php
include 'dbconnect.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brandName = $_POST['brand_name'];
    $brandDesc = $_POST['brand_desc'];
    $brandStatus = isset($_POST['status']) ? $_POST['status'] : 'default_value';// Get brand status from the dropdown
    $userId = $_POST['user_id'];

    // Check if the brand name already exists
    $checkQuery = "SELECT * FROM tbl_brands WHERE brand_name = '$brandName' AND user_id = '$userId'";
    $checkResult = $conn->query($checkQuery);
    if ($checkResult->num_rows > 0) {
        echo '<script>
                alert("Brand name already exists. Please choose a different name.");
                window.location.href="brands.html";
              </script>';
        exit; // Stop execution further if brand name already exists
    }

    if (isset($_FILES['brand_img']) && $_FILES['brand_img']['error'] == 0) {
        $fileTmpPath = $_FILES['brand_img']['tmp_name'];
        $fileName = $_FILES['brand_img']['name'];
        $fileSize = $_FILES['brand_img']['size'];
        $fileType = $_FILES['brand_img']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file-name
        $newFileName = preg_replace('/[^A-Za-z0-9\-]/', '', $userId . ' - ' . $brandName) . '.' . 'png';

        // Directory in which the uploaded file will be moved
        $uploadFileDir = 'uploads/brands/';
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // Insert brand details into the database including user_id
            $sql = "INSERT INTO tbl_brands (brand_name, brand_desc, brand_img, brand_status, user_id)
                    VALUES ('$brandName', '$brandDesc', '$newFileName', '$brandStatus', '$userId')";

            if ($conn->query($sql) === TRUE) {
                echo '<script>
                        alert("Brand successfully added!");
                        window.location.href="brands.html";
                      </script>';
            } else {
                echo '<script>
                        alert("Error: ' . $sql . '<br>' . $conn->error . '");
                        window.location.href="brands.html";
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Error uploading the file.");
                    window.location.href="brands.html";
                  </script>';
        }
    }
}
?>
