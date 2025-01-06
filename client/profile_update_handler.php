<?php

session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    // Sanitize and validate input data
    // $user_id = $_SESSION['national_id'];
    $user_id = $_SESSION['user_id'];
    $first_name = mysqli_real_escape_string($mysqliObj, $_POST['fname']);
    $last_name = mysqli_real_escape_string($mysqliObj, $_POST['lname']);
    $dob = mysqli_real_escape_string($mysqliObj, $_POST['dob']);
    $gender = mysqli_real_escape_string($mysqliObj, $_POST['gender']);
    $email = mysqli_real_escape_string($mysqliObj, $_POST['email']);
    $mobile = mysqli_real_escape_string($mysqliObj, $_POST['number']);
    $national_id = mysqli_real_escape_string($mysqliObj, $_POST['nationID']);
    $county = mysqli_real_escape_string($mysqliObj, $_POST['countySelect']);
    $town = mysqli_real_escape_string($mysqliObj, $_POST['townSelect']);
    $connection = mysqli_real_escape_string($mysqliObj, $_POST['connection']);

    // Update query with prepared statement
    $query = "UPDATE users SET 
            first_name = ?, 
            last_name = ?, 
            date_of_birth = ?, 
            gender = ?, 
            email = ?, 
            mobile_number = ?, 
            national_id = ?, 
            county = ?, 
            town = ?, 
            connection_type = ? 
        WHERE national_id = ?";

    $stmt = $mysqliObj->prepare($query);
    $stmt->bind_param(
        'sssssssssss',
        $first_name,
        $last_name,
        $dob,
        $gender,
        $email,
        $mobile,
        $national_id,
        $county,
        $town,
        $connection,
        $user_id
    );

    // Update your error handling:
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        http_response_code(500); // Set appropriate error status code
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile: ' . $mysqliObj->error]);
    }

    $stmt->close();
    $mysqliObj->close();
}
