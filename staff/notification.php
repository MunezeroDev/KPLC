<?php
session_start();
header('Content-Type: application/json'); // Ensure response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['staff_id'], $_POST['connection_id'], $_POST['message'])) {
        $staff_id = $_POST['staff_id'];
        $connection_id = $_POST['connection_id'];
        $message = $_POST['message'];

        sendStaffNotification($staff_id, $connection_id, $message);

        // Respond with JSON success message
        echo json_encode(['status' => 'success', 'message' => 'Notification sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data received.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

function sendStaffNotification($staff_id, $connectionId, $message)
{
    // Store the notification in session
    $_SESSION['notification_message'] = json_encode([
        'staff_id' => $staff_id,
        'connection_id' => $connectionId,
        'message' => $message
    ]);
}
