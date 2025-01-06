<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $user_id = $_SESSION['user_id'];

    // Collect and sanitize form data
    $outage_type = $mysqliObj->real_escape_string($_POST['type_of_outage']);
    $outage_time = $mysqliObj->real_escape_string($_POST['outage_start_time']);
    $duration = $mysqliObj->real_escape_string($_POST['duration_minutes']);

    $priority_level = $mysqliObj->real_escape_string($_POST['priority_level']);
    $location = $mysqliObj->real_escape_string($_POST['location']);
    $preferred_contact = $mysqliObj->real_escape_string($_POST['preferred_contact']);
    $reason = $mysqliObj->real_escape_string($_POST['suspected_reason']);

    $query = "INSERT INTO outages (
        user_id,

        type_of_outage, 
        outage_start_time,
        duration_minutes,

        priority_level,
        location,
        preferred_contact,
        suspected_reason 
   
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqliObj->prepare($query);

    $stmt->bind_param(
        'ssssssss',
        $user_id,  // From session
        $outage_type,
        $outage_time,
        $duration,
        $priority_level,
        $location,
        $preferred_contact,
        $reason
    );

    // Update your error handling:
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Outage report submitted successfully.'
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
