<?php
session_start();
header('Content-Type: application/json');
include('../config/config.php');
include('../config/checklogin.php');

check_login();

// Retrieve and sanitize the POST parameters
$staff_id = mysqli_real_escape_string($mysqliObj, $_POST['staff_id'] ?? '');
$connection_id = mysqli_real_escape_string($mysqliObj, $_POST['connection_id'] ?? '');

// Initialize response array
$response = array();

// Validate required parameters
if (empty($staff_id) || empty($connection_id)) {
    $response['status'] = 'error';
    $response['message'] = 'Missing required parameters';
    $response['details'] = array(
        'staff_id' => empty($staff_id) ? 'Missing staff ID' : 'Present',
        'connection_id' => empty($connection_id) ? 'Missing connection ID' : 'Present'
    );
    error_log("Validation Error: Missing required parameters for staff assignment");
    echo json_encode($response);
    exit();
}

try {
    // Begin database operations
    $staff_check = mysqli_query($mysqliObj, "SELECT staff_id FROM staff_details WHERE staff_id = '$staff_id'");
    $conn_check = mysqli_query($mysqliObj, "SELECT connection_id FROM connections WHERE connection_id = '$connection_id'");

    // Verify existence of records
    if (!mysqli_num_rows($staff_check)) {
        throw new Exception("Invalid staff ID: $staff_id");
    }
    if (!mysqli_num_rows($conn_check)) {
        throw new Exception("Invalid connection ID: $connection_id");
    }

    // Start transaction
    mysqli_begin_transaction($mysqliObj) or throw new Exception("Transaction start failed");

    // Prepare and execute staff update
    $update_staff = mysqli_prepare(
        $mysqliObj,
        "UPDATE staff_details SET availability = 'unavailable' WHERE staff_id = ?"
    ) or throw new Exception("Staff update preparation failed");

    mysqli_stmt_bind_param($update_staff, 's', $staff_id);
    mysqli_stmt_execute($update_staff) or throw new Exception("Staff update failed");

    if (mysqli_stmt_affected_rows($update_staff) === 0) {
        throw new Exception("No changes made to staff record");
    }

    // Prepare and execute connection update
    $update_connection = mysqli_prepare(
        $mysqliObj,
        "UPDATE connections SET connection_status = 'assigned', application_progress = 'Under Review' 
         WHERE connection_id = ?"
    ) or throw new Exception("Connection update preparation failed");

    mysqli_stmt_bind_param($update_connection, 's', $connection_id);
    mysqli_stmt_execute($update_connection) or throw new Exception("Connection update failed");

    if (mysqli_stmt_affected_rows($update_connection) === 0) {
        throw new Exception("No changes made to connection record");
    }

    // Commit transaction
    mysqli_commit($mysqliObj) or throw new Exception("Transaction commit failed");

    // Log success and prepare response
    error_log("SUCCESS: Staff assignment completed - Staff ID: $staff_id, Connection ID: $connection_id");

    $response['status'] = 'success';
    $response['message'] = 'Staff assignment completed successfully';
    $response['details'] = array(
        'staff_id' => $staff_id,
        'connection_id' => $connection_id,
        'timestamp' => date('Y-m-d H:i:s')
    );
} catch (Exception $e) {
    // Rollback transaction and log error
    if (mysqli_errno($mysqliObj)) {
        mysqli_rollback($mysqliObj);
    }

    error_log("ERROR: Staff assignment failed - " . $e->getMessage() .
        " | Staff ID: $staff_id | Connection ID: $connection_id");

    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
    $response['details'] = array(
        'error_type' => get_class($e),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    );
} finally {
    // Clean up prepared statements
    if (isset($update_staff)) mysqli_stmt_close($update_staff);
    if (isset($update_connection)) mysqli_stmt_close($update_connection);
}

// Send response
echo json_encode($response);
