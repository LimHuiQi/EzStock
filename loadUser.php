<?php
header('Content-Type: application/json');

// Read JSON input
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

function getUserInfo($input) {
    if (isset($input['user_id'])) {
        $userDetails = [
            'user_id' => $input['user_id'],
            'name' => isset($input['user_name']) ? $input['user_name'] : 'Guest',
            'user_img' => isset($input['user_img']) ? $input['user_img'] : 'User.png' // Default image if not set
        ];
        return $userDetails;
    } else {
        return ['name' => 'Guest', 'user_img' => 'User.png'];
    }
}

echo json_encode(getUserInfo($input));
?>