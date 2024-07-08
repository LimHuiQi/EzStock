<?php

// Include the database connection file
include_once ('dbconnect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $phone = $_POST['user_phone'];
    $password = $_POST['user_pwd'];
    $confirmPassword = $_POST['confirmPassword'];
    $terms = isset($_POST['terms']);

    // Validate form data
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        echo "<script>window.alert('Please fill in all fields.'); window.history.back();</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>window.alert('Invalid email format.'); window.history.back();</script>";
    } elseif (!preg_match('/^01\d{8,9}$/', $phone)) {
        echo "<script>window.alert('Invalid phone number.'); window.history.back();</script>";
    } elseif ($password !== $confirmPassword) {
        echo "<script>window.alert('Passwords do not match.'); window.history.back();</script>";
    } elseif (!$terms) {
        echo "<script>window.alert('Please agree to the terms and conditions.'); window.history.back();</script>";
    } else {
        if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] == 0) {
            $fileTmpPath = $_FILES['user_img']['tmp_name'];
            $fileName = $_FILES['user_img']['name'];
            $fileSize = $_FILES['user_img']['size'];
            $fileType = $_FILES['user_img']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Sanitize file-name
            $newFileName = preg_replace('/[^A-Za-z0-9\-]/', '', $userName) . '.' . $fileExtension;
    
            // Directory in which the uploaded file will be moved
            $uploadFileDir = 'uploads/users/';
            $dest_path = $uploadFileDir . $newFileName;

            // Check file size and type for additional security
            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if ($fileSize < 5000000 && in_array($fileExtension, $allowedFileTypes)) {
                if (move_uploaded_file($fileTmpPath, $target_file)) {
                    $imagePath = $target_file;
                } else {
                    echo "<script>window.alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
                    exit;
                }
            } else {
                echo "<script>window.alert('Invalid file type or size.'); window.history.back();</script>";
                exit;
            }
        } else {
            // Handle cases where no image is uploaded or there is an error
            $imagePath = null; // You can set a default image path or handle this as required
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generate the next user_id
        $userIdQuery = "SELECT MAX(CAST(SUBSTRING(user_id, 6) AS UNSIGNED)) AS max_id FROM tbl_users WHERE user_id LIKE 'User-%'";
        $userIdResult = $conn->query($userIdQuery);
        $userIdRow = $userIdResult->fetch_assoc();
        $nextUserIdNumber = $userIdRow['max_id'] + 1;
        $newUserId = "User-" . $nextUserIdNumber;

        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM tbl_users WHERE user_email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailQuery);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();
        $existingUser = $result->fetch_assoc();

        if ($existingUser) {
            echo "<script>window.alert('Email already exists.'); window.history.back();</script>";
        } else {
            // Insert the new user
            $insertUserQuery = "INSERT INTO tbl_users (user_id, user_name, user_email, user_phone, user_pwd, user_img) VALUES (?, ?, ?, ?, ?, ?)";
            $insertUserStmt = $conn->prepare($insertUserQuery);
            $insertUserStmt->bind_param("ssssss", $newUserId, $name, $email, $phone, $hashedPassword, $imagePath);

            if ($insertUserStmt->execute()) {
                echo "<script>window.alert('Registration successful!');
                window.location.href = 'login.html';
                </script>";
            } else {
                echo "<script>window.alert('Error: " . $insertUserStmt->error . "');</script>";
            }

            $insertUserStmt->close();
        }

        $checkEmailStmt->close();
        $conn->close();
    }
}
?>
