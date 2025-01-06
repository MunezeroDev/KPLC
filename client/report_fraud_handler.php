<?php

session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $user_id = $_SESSION['user_id'];

    // Collect and sanitize form data
    $type_of_fraud = $mysqliObj->real_escape_string($_POST['fraud_type']);
    $date_of_observation = $mysqliObj->real_escape_string($_POST['date_of_observation']);
    $preferred_contact = $mysqliObj->real_escape_string($_POST['preferred_contact']);
    $description = $mysqliObj->real_escape_string($_POST['detailed_description']);
    $location = $mysqliObj->real_escape_string($_POST['location']);

    $query = "INSERT INTO frauds (
        user_id, 
        fraud_type, 
        date_of_observation, 
        detailed_description, 
        preferred_contact,
        location
    ) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $mysqliObj->prepare($query);

    $stmt->bind_param(
        'ssssss',
        $user_id,  // From session
        $type_of_fraud,
        $date_of_observation,
        $description,
        $preferred_contact,
        $location
    );

    // Update your error handling:
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Fraud report submitted successfully.'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to submit report: ' . $mysqliObj->error
        ]);
    }

    $stmt->close();
    $mysqliObj->close();
}
