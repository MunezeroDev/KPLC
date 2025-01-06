<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $user_id = $_SESSION['user_id'];

    // Collect and sanitize form data
    $fault_nature = $mysqliObj->real_escape_string($_POST['nature_of_fault']);
    $severity_level = $mysqliObj->real_escape_string($_POST['severity_level']);
    $preferred_contact = $mysqliObj->real_escape_string($_POST['preferred_contact']);
    $location = $mysqliObj->real_escape_string($_POST['location']);
    $description = $mysqliObj->real_escape_string($_POST['description_of_issue']);

    $query = "INSERT INTO faults (
        user_id, 
        nature_of_fault, 

        description_of_issue,
        severity_level,
        preferred_contact, 
        location
    ) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $mysqliObj->prepare($query);

    $stmt->bind_param(
        'ssssss',
        $user_id,  // From session
        $fault_nature,
        $description,
        $severity_level,
        $preferred_contact,
        $location
    );

    // Update your error handling:
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Fault report submitted successfully.'
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
