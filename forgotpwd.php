<?php
include 'dbconnect.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];

    // Generate a new password (you may implement your own logic for generating a new password)

    // Update the user's password in the database
    $sql = "UPDATE users SET password='$new_password' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Password reset successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
