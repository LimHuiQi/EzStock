<?php
include 'dbconnect.php'; // Include the database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['user_email'];
    $password = $_POST['user_pwd'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT user_id, user_pwd, user_name FROM tbl_users WHERE user_email = ?");
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Fetch result
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $hashed_password = $row['user_pwd'];
        $username = $row['user_name']; // Fetch the username

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set local storage items using JavaScript
            echo "<script>
                    localStorage.setItem('user_email', '$email');
                    localStorage.setItem('user_id', '$user_id');
                    localStorage.setItem('user_name', '$username');
                    window.location.href = 'index.html';
                  </script>";
            exit();
        } else {
            // Password is not correct
            echo "<script>alert('Invalid email or password.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with that email address.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}
?>