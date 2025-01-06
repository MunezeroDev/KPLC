<?php
require_once 'config.php';

$response = ['success' => false, 'message' => '', 'redirect' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $email = $_POST['email'] ?? '';
    $number = $_POST['number'] ?? '';
    $id = $_POST['id'] ?? '';
    $county = $_POST['countySelect'] ?? '';
    $town = $_POST['townSelect'] ?? '';
    $connection = $_POST['connection'] ?? '';
    $password = $_POST['create-pass'] ?? '';
    $role = $_POST['role'] ?? 'regularUser';

    // Check for existing email or ID
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR id_number = ?");
    $check_stmt->bind_param('ss', $email, $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $response['message'] = 'A user with this email or ID already exists.';
        echo json_encode($response);
        $check_stmt->close();
        exit;
    }
    $check_stmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert data into the database
    // Update the insert query to include the role field
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, dob, gender, email, phone, id_number, county, town, connection_type, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssssssss', $fname, $lname, $dob, $gender, $email, $number, $id, $county, $town, $connection, $hashedPassword, $role);

    //IF REGISTRATION SUCESSFUL ON INDEX.PHP 'S , SHOW SUCCESS MESSAGE FOR 10 SECONDS BEFORE REROUTING TO LOGIN PAGE
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'User registered successfully.';
        $response['redirect'] = 'index.php'; // New redirect URL
    } else {
        $response['message'] = 'Database error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = 'Invalid request method.';
}

// Close the database connection
echo json_encode($response);
$conn->close();
