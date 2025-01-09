<?php
session_start();
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); // Ensure the response is JSON-formatted

    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? sha1(md5($_POST['password'])) : '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
        exit;
    }

    // Check if the email exists
    $emailCheckStmt = $mysqliObj->prepare("SELECT email FROM users WHERE email = ?");
    $emailCheckStmt->bind_param('s', $email);
    $emailCheckStmt->execute();
    $emailCheckStmt->store_result();

    if ($emailCheckStmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email does not exist']);
        $emailCheckStmt->close();
        $mysqliObj->close();
        exit;
    }

    $emailCheckStmt->close();

    // Check if the password matches
    $stmt = $mysqliObj->prepare("SELECT email, password_hash, user_id FROM users WHERE email = ? AND password_hash = ?");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($fetched_email, $fetched_password, $client_id);
    $rs = $stmt->fetch();

    if ($rs) {
        $_SESSION['user_id'] = $client_id;
        $_SESSION['email'] = $fetched_email;
        $_SESSION['logged_in'] = true;

        echo json_encode(['status' => 'success', 'message' => 'Staff Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    }

    $stmt->close();
    $mysqliObj->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Authentication Portal</title>
    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="../assets/css/credentials.css">
</head>

<body>
    <main>
        <article class="login" aria-labelledby="">
            <!-- message box  -->
            <div role="status" aria-live="polite" class="alert-message">
                <h1></h1>
                <button class="alert-close">
                    <!-- close icon -->
                    <svg id="close-alert" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon">
                        <path
                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg>
                </button>
            </div>

            <!-- header  -->
            <header class="form-header">Login</header>

            <!-- login-form  -->
            <form method="post" id="staff-form" class="register-form">
                <!-- email -->
                <div class="form-group">
                    <div class="password-wrapper">
                        <input type="email" name="email" class="email" placeholder="Enter your email"
                            aria-describedby="password-error password-strength" required>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon left">
                            <path
                                d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                        </svg>
                    </div>
                    <small class="email-error" role="alert"></small>
                </div>

                <!-- password -->
                <div class="form-group">
                    <div class="password-wrapper">
                        <input type="password" class="password create-pass" id="create-pass" name="password"
                            placeholder="Create a password" required>

                        <svg xmlns=" http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon">
                            <path id="icon-path"
                                d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon left">
                            <path
                                d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                        </svg>
                    </div>
                </div>

                <!-- checkbox-->
                <div class="checkbox">
                    <div class="checkbox-content">
                        <input name="logCheck" type="checkbox" id="logCheck" />
                        <label for="logCheck" class="text">Remember me</label>
                    </div>

                    <a href="#" id="forgot-link" class="text">Forgot password?</a>
                </div>

                <footer class="login-action">
                    <!-- submit btn  -->
                    <button type="submit" name="login" class="auth-button" id="login-btn" aria-label="Sign Up">
                        Login
                    </button>
                </footer>
            </form>
        </article>
    </main>

    <script src="js/credentials.js"></script>
</body>

</html>