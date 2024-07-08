<?php
// getNextSequenceNumber.php
include 'dbconnect.php'; // Include your database connection script

// Check if 'user_id' and 'date' are provided in the URL, if not, handle the error or assign a default
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : exit('User ID not provided.');
$date = isset($_GET['date']) ? $_GET['date'] : exit('Date not provided.');

// Ensure that user_id and date are properly sanitized to prevent SQL Injection
$user_id = mysqli_real_escape_string($conn, $user_id);
$date = mysqli_real_escape_string($conn, $date);

// Convert the date to the format used in the sales_id (yymmdd)
$yymmdd = date('ymd', strtotime($date));

// Database query to get the highest sequence number for the given date
$query = "SELECT sales_id FROM tbl_sales WHERE sales_date = '$date' AND user_id = '$user_id' ORDER BY sales_id DESC LIMIT 1";$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    // Extract the last four digits as the current sequence number
    $currentSequence = substr($row['sales_id'], -4);
    $nextSequenceNumber = (int)$currentSequence + 1;
    echo json_encode(['success' => true, 'nextSequenceNumber' => $nextSequenceNumber]);
} else {
    // If no existing orders are found for this date, start with sequence number 1
    echo json_encode(['success' => true, 'nextSequenceNumber' => 1]);
}
?>