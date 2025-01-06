<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT first_name, last_name, email, mobile_number, county, town FROM users WHERE user_id = ?";

    // Collect and sanitize form data
    $connection_type = $mysqliObj->real_escape_string($_POST['connection_type']);
    $premise_type = $mysqliObj->real_escape_string($_POST['premises_type']);
    $property_ownership = $mysqliObj->real_escape_string($_POST['property_ownership']);
    $phase_type = $mysqliObj->real_escape_string($_POST['phase_type']);
    $location = $mysqliObj->real_escape_string($_POST['location']);

    $query = "INSERT INTO connections (
        user_id, 
        connection_type, 
        premises_type,
        property_ownership, 
        phase_type,
        location
    ) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $mysqliObj->prepare($query);

    $stmt->bind_param(
        'ssssss',
        $user_id,  // From session
        $connection_type,
        $premise_type,
        $property_ownership,
        $phase_type,
        $location,
    );

    // Update your error handling:
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'New Connection Request Submitted .'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to submit request: ' . $mysqliObj->error
        ]);
    }

    $stmt->close();
    $mysqliObj->close();
}

// i WANT TO TIE EACH CONNECTION TO A SPECIFIC USER WHO SENT IT : SUCH THAT LATER IN ANOTHER FILE, I WILL DISPLAY WHO SENT THE 
// DATA AND RELEVANT USER WHO SENT INFO