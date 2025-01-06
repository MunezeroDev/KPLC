<?php
// File 1: process_connection.php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $user_id = $_SESSION['user_id'];

    // First verify that the user exists and get their details
    $user_check = $mysqliObj->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $user_check->bind_param('s', $user_id);
    $user_check->execute();
    $result = $user_check->get_result();

    if ($result->num_rows === 0) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
        exit;
    }

    // Collect and sanitize form data
    $connection_type = $mysqliObj->real_escape_string($_POST['connection_type']);
    $premise_type = $mysqliObj->real_escape_string($_POST['premises_type']);
    $property_ownership = $mysqliObj->real_escape_string($_POST['property_ownership']);
    $phase_type = $mysqliObj->real_escape_string($_POST['phase_type']);
    $location = $mysqliObj->real_escape_string($_POST['location']);

    // Add timestamp for when the connection request was made
    $created_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO connections (
        user_id, 
        connection_type, 
        premises_type,
        property_ownership, 
        phase_type,
        location,
        created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqliObj->prepare($query);

    $stmt->bind_param(
        'sssssss',
        $user_id,
        $connection_type,
        $premise_type,
        $property_ownership,
        $phase_type,
        $location,
        $created_at
    );

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'New Connection Request Submitted.',
            'connection_id' => $mysqliObj->insert_id // Return the new connection ID
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

// File 2: view_connections.php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

function getConnections($mysqliObj, $user_id = null)
{
    // Join query to get connection details along with user information
    $query = "
        SELECT 
            c.*,
            u.first_name,
            u.last_name,
            u.email,
            u.mobile_number,
            u.county,
            u.town
        FROM 
            connections c
        INNER JOIN 
            users u ON c.user_id = u.user_id
    ";

    // If user_id is provided, only show that user's connections
    if ($user_id) {
        $query .= " WHERE c.user_id = ?";
        $stmt = $mysqliObj->prepare($query);
        $stmt->bind_param('s', $user_id);
    } else {
        $stmt = $mysqliObj->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $connections = [];

    while ($row = $result->fetch_assoc()) {
        $connections[] = [
            'connection_id' => $row['connection_id'],
            'connection_type' => $row['connection_type'],
            'premises_type' => $row['premises_type'],
            'property_ownership' => $row['property_ownership'],
            'phase_type' => $row['phase_type'],
            'location' => $row['location'],
            'created_at' => $row['created_at'],
            'user' => [
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'email' => $row['email'],
                'mobile' => $row['mobile_number'],
                'location' => $row['county'] . ', ' . $row['town']
            ]
        ];
    }

    return $connections;
}

// Example usage for viewing connections
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin']; // Assuming you have admin flag
$user_id = $_SESSION['user_id'];

// Get connections based on user role
$connections = $is_admin ? getConnections($mysqliObj) : getConnections($mysqliObj, $user_id);
?>

<!-- HTML for displaying connections -->
<!DOCTYPE html>
<html>

<head>
    <title>Connection Requests</title>
</head>

<body>
    <h1>Connection Requests</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Connection ID</th>
                <th>Requester</th>
                <th>Contact Info</th>
                <th>Connection Type</th>
                <th>Premises Type</th>
                <th>Location</th>
                <th>Date Requested</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($connections as $connection): ?>
                <tr>
                    <td><?php echo htmlspecialchars($connection['connection_id']); ?></td>
                    <td><?php echo htmlspecialchars($connection['user']['name']); ?></td>
                    <td>
                        Email: <?php echo htmlspecialchars($connection['user']['email']); ?><br>
                        Phone: <?php echo htmlspecialchars($connection['user']['mobile']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($connection['connection_type']); ?></td>
                    <td><?php echo htmlspecialchars($connection['premises_type']); ?></td>
                    <td><?php echo htmlspecialchars($connection['location']); ?></td>
                    <td><?php echo htmlspecialchars($connection['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>