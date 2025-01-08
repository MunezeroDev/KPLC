<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

// $user_id = $_SESSION['national_id'];
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $mysqliObj->prepare($query);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Get the form data (previous code remains the same until password_hash)
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $date_of_birth = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $mobile_number = $_POST['number'];
    $national_id = $_POST['nationID'];
    $county = $_POST['countySelect'];
    $town = $_POST['townSelect'];
    $connection_type = $_POST['connection'];
    $password_hash = sha1(md5($_POST['password']));

    // Define the default availability status for new staff members
    $availability = 'available';

    // Start transaction
    $mysqliObj->begin_transaction();

    try {
        // Email and National ID check remains the same
        $email_check_query = "SELECT email, national_id FROM users WHERE email = ? OR national_id = ?";
        $email_check_stmt = $mysqliObj->prepare($email_check_query);
        $email_check_stmt->bind_param('ss', $email, $national_id);
        $email_check_stmt->execute();
        $email_check_stmt->store_result();
        $email_check_stmt->bind_result($db_email, $db_national_id);
        $email_check_stmt->fetch();

        if ($email_check_stmt->num_rows > 0) {
            if ($db_email === $email) {
                throw new Exception('Email already exists. Please use a different email.');
            } elseif ($db_national_id === $national_id) {
                throw new Exception('National ID already exists. Please use a different National ID.');
            }
        }

        // User insertion remains the same
        $user_query = "INSERT INTO users (first_name, last_name, date_of_birth, gender, email, 
                      mobile_number, national_id, county, town, connection_type, password_hash, role) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'STAFF')";

        $user_stmt = $mysqliObj->prepare($user_query);
        $user_stmt->bind_param(
            'sssssssssss',
            $first_name,
            $last_name,
            $date_of_birth,
            $gender,
            $email,
            $mobile_number,
            $national_id,
            $county,
            $town,
            $connection_type,
            $password_hash
        );

        if (!$user_stmt->execute()) {
            throw new Exception('Failed to create user record');
        }

        // Get the user_id (same as before)
        $user_id_query = "SELECT user_id FROM users WHERE seq_id = ?";
        $user_id_stmt = $mysqliObj->prepare($user_id_query);
        $seq_id = $mysqliObj->insert_id;
        $user_id_stmt->bind_param('i', $seq_id);
        $user_id_stmt->execute();
        $user_id_stmt->bind_result($user_id);

        if (!$user_id_stmt->fetch()) {
            throw new Exception('Failed to retrieve user ID');
        }
        $user_id_stmt->close();

        // Insert staff details with the default availability status
        $staff_query = "INSERT INTO staff_details (staff_id, availability) VALUES (?, ?)";
        $staff_stmt = $mysqliObj->prepare($staff_query);
        $staff_stmt->bind_param('ss', $user_id, $availability);

        if (!$staff_stmt->execute()) {
            throw new Exception('Failed to create staff details record');
        }

        $mysqliObj->commit();
        echo json_encode(['type' => 'success', 'message' => 'Staff Account Created Successfully']);
    } catch (Exception $e) {
        $mysqliObj->rollback();
        echo json_encode(['type' => 'error', 'message' => $e->getMessage()]);
    } finally {
        // Clean up statements
        if (isset($email_check_stmt)) $email_check_stmt->close();
        if (isset($user_stmt)) $user_stmt->close();
        if (isset($staff_stmt)) $staff_stmt->close();
    }

    exit;
}


while ($obj = $result->fetch_object()) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <!-- head  -->
    <?php include("includes/head.php"); ?>
    <!-- ./head  -->

    <body>

        <!-- sidebar  -->
        <?php include("includes/sidebar.php"); ?>
        <!-- ./sidebar  -->

        <!-- topbar  -->
        <?php include("includes/topbar.php"); ?>
        <!-- ./topbar  -->

        <!-- main section   -->
        <main class="main-section">
            <section class="main-section-wrapper">
                <div class="full-width-alert">
                    <div class="alert-content">
                        <span class="message"></span>
                    </div>
                    <button class="action-button">Cancel</button>
                </div>

                <div class="profile-details-container">
                    <nav class="profile-tabs">
                        <a href="#" class="profile-tab active">Staff Registration</a>
                    </nav>

                    <form id="staff-register-form" method="post">
                        <div class="form-grid">

                            <!-- first-name  -->
                            <div class="form-group">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-input" id="fname" name="fname">
                            </div>

                            <!-- last-name  -->
                            <div class=" form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" id="lname" name="lname" class="form-input">
                            </div>

                            <!-- d-o-b -->
                            <div class="form-group">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-input">
                            </div>

                            <!-- gender  -->
                            <div class="form-group">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Others</option>
                                </select>
                            </div>

                            <!-- email  -->
                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-input" name="email" id="email">
                            </div>

                            <!-- mobile-number  -->
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" id="number" name="number" class="form-input">
                            </div>

                            <!-- Id-number  -->
                            <div class="form-group">
                                <label for="nationID" class="form-label">ID/Passport Number</label>
                                <input type="tel" type="text" id="nationID" name="nationID" class="form-input">
                            </div>

                            <!-- county  -->
                            <div class="form-group">
                                <label for="countySelect" class="form-label">County</label>
                                <select class="form-select" id="countySelect" name="countySelect" required>
                                    <option value="" disabled selected>Select your County</option>
                                </select>
                            </div>

                            <!-- town  -->
                            <div class="form-group">
                                <label for="townSelect" class="form-label">Town</label>
                                <select class="form-select" id="townSelect" name="townSelect" required>
                                    <option value="" disabled selected>Select your Town</option>
                                </select>
                            </div>

                            <!-- connection  -->
                            <div class="form-group">
                                <label for="connection" class="form-label">Home Connection Type</label>
                                <select id="connection" name="connection" class="form-select">
                                    <option disabled selected>Select Home Connection Type</option>
                                    <option>Residential</option>
                                    <option>Commercial</option>
                                    <option>Industrial</option>
                                </select>
                            </div>

                            <!-- password  -->
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>

                                <div class="password-wrapper">
                                    <input type="password" class="form-select password" id="create-pass" name="password"
                                        placeholder="Create a password" required>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon">
                                        <path id="icon-path"
                                            d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- confirm password  -->
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>

                                <div class="password-wrapper">
                                    <input type="password" class="form-select password" id="confirm-pass" name="password"
                                        placeholder="Confirm password" required>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon">
                                        <path id="icon-path"
                                            d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z" />
                                    </svg>
                                </div>
                                <small id="confirm-pass-error" class="password-text" role="alert"></small>
                            </div>
                        </div>

                        <button type="submit" class="update-button">Register Staff</button>
                    </form>

                    <!-- Success Modal -->
                    <?php include("includes/sucess-modal.php"); ?>
                    <!-- ./success modal -->
                </div>
            </section>
        </main>

        <!-- <script src="js/main.js"></script> -->
        <script src="js/credentials.js"></script>
    </body>

    </html>

<?php
}

$stmt->close();
$mysqliObj->close();
?>