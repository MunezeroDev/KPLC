<?php
session_start();
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Get the form data
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

    // Check if the email already exists
    $email_check_query = "SELECT email, national_id FROM users WHERE email = ? OR national_id = ?";
    $email_check_stmt = $mysqliObj->prepare($email_check_query);
    $email_check_stmt->bind_param('ss', $email, $national_id);
    $email_check_stmt->execute();
    $email_check_stmt->store_result();

    // Fetch results
    $email_check_stmt->bind_result($db_email, $db_national_id);
    $email_check_stmt->fetch();

    if ($email_check_stmt->num_rows > 0) {
        if ($db_email === $email) {
            echo json_encode(['type' => 'error', 'message' => 'Email already exists. Please use a different email.']);
        } elseif ($db_national_id === $national_id) {
            echo json_encode(['type' => 'error', 'message' => 'National ID already exists. Please use a different National ID.']);
        }
    } else {
        // Proceed to register the user
        $query = "INSERT INTO users (first_name, last_name, date_of_birth, gender, email, mobile_number, national_id, county, town, connection_type, password_hash) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqliObj->prepare($query);
        $stmt->bind_param(
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

        if ($stmt->execute()) {
            echo json_encode(['type' => 'success', 'message' => 'Account Created']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Please Try Again Or Try Later']);
        }

        $stmt->close();
    }
    $email_check_stmt->close();
    exit; // End the script to avoid rendering HTML
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
        <article class="registration" aria-labelledby="">

            <header class="form-header">Registration</header>

            <!-- register-form  -->
            <form method="post" id="register-form" class="register-form">

                <div class="form-groups">
                    <!-- first-name  -->
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="fname" placeholder="Enter your First Name"
                            aria-placeholder="Enter your First Name" aria-describedby="fname-error" required>

                        <small id="fname-error" role="alert"></small>
                    </div>

                    <!-- last-name  -->
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lname" placeholder="Enter your Last Name"
                            aria-placeholder="Enter your Last Name" aria-describedby="lname-error" class="inputs" required>

                        <small id="lname-error" role="alert"></small>
                    </div>

                    <!-- d-o-b -->
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" aria-describedby="date-error" required>

                        <small id="date-error" role="alert"></small>
                    </div>

                </div>

                <div class="form-groups">
                    <!-- gender  -->
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option disabled selected>Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Others</option>
                        </select>
                        <small id="gender-error" role="alert"></small>
                    </div>

                    <!-- email  -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="email" placeholder="Enter your email"
                            aria-describedby="email-error" title="Enter a valid email address." autocomplete="email">

                        <small class="email-error" role="alert"></small>
                    </div>

                    <!-- mobile-number  -->
                    <div class="form-group">
                        <label for="number">Mobile Number</label>
                        <input type="tel" id="number" name="number" placeholder="Enter your phone number"
                            aria-describedby="number-error" required>

                        <small id="number-error" role="alert"></small>
                    </div>
                </div>

                <div class="form-groups">
                    <!-- Id-number  -->
                    <div class="form-group">
                        <label for="nationID">ID Number</label>
                        <input type="text" id="nationID" name="nationID" placeholder="Enter ID/Passport Number" aria-describedby="id-error"
                            required>

                        <small id="id-error" role="alert"></small>
                    </div>

                    <!-- county  -->
                    <div class="form-group">
                        <label for="countySelect">County</label>
                        <select id="countySelect" name="countySelect" required>
                            <option value="" disabled selected>Select your County</option>
                        </select>
                        <small id="county-error" role="alert"></small>
                    </div>

                    <!-- town  -->
                    <div class="form-group">
                        <label for="townSelect">Town</label>
                        <select id="townSelect" name="townSelect" required>
                            <option value="" disabled selected>Select your Town</option>
                        </select>
                        <small id="town-error" role="alert"></small>
                    </div>

                </div>

                <div class="form-groups">
                    <!-- connection  -->
                    <div class="form-group">
                        <label for="connection">Home Connection Type</label>
                        <select id="connection" name="connection" required>
                            <option disabled selected>Select Home Connection Type</option>
                            <option>Residential</option>
                            <option>Commercial</option>
                            <option>Industrial</option>
                        </select>
                        <small id="connection-error" role="alert"></small>
                    </div>

                    <!-- password-creation  -->
                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="password-wrapper">
                            <input type="password" class="password create-pass" id="create-pass" name="password"
                                placeholder="Create a password" required>

                            <svg xmlns=" http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon">
                                <path id="icon-path"
                                    d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z" />
                            </svg>
                        </div>

                        <small id="create-pass-error" class="password-text" role="alert">Use 8 or more characters with a mix
                            ofletters, numbers & symbols
                        </small>
                    </div>

                    <!-- password-confirmation  -->
                    <div class="form-group">
                        <label for="confirm-pass">Password</label>

                        <div class="password-wrapper">
                            <input type="password" class="password create-pass" id="confirm-pass" name="confirm-pass"
                                placeholder="Confirm Passoword" aria-describedby="password-error password-strength"
                                title="Enter a valid password." required>

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="icon">
                                <path id="icon-path"
                                    d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z" />
                            </svg>
                        </div>

                        <small id="confirm-pass-error" class="password-text" role="alert">Use 8 or more characters with
                            a mix of letters, numbers & symbols</small>
                    </div>
                </div>

                <footer class="form-groups actions">
                    <!-- submit btn  -->
                    <button type="submit" name="sign_up" class="auth-button" id="register-btn" aria-label="Sign Up">
                        Register
                        <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" class="icon">
                            <path
                                d="M20.17,9.23l-14-5.78a3,3,0,0,0-4,3.7L3.71,12,2.13,16.85A3,3,0,0,0,2.94,20a3,3,0,0,0,2,.8,3,3,0,0,0,1.15-.23l14.05-5.78a3,3,0,0,0,0-5.54ZM5.36,18.7a1,1,0,0,1-1.06-.19,1,1,0,0,1-.27-1L5.49,13H19.22ZM5.49,11,4,6.53a1,1,0,0,1,.27-1A1,1,0,0,1,5,5.22a1,1,0,0,1,.39.08L19.22,11Z">
                            </path>
                        </svg>
                    </button>

                    <nav>
                        <span>Already a member?</span>
                        <a href="client-login.php" id="login-link" class="signUp-link">Login In</a>
                    </nav>

                </footer>
            </form>

            <!-- Success Modal -->
            <?php include("includes/sucess-modal.php"); ?>
            <!-- ./success modal -->
        </article>
    </main>

    <script src="js/credentials.js"></script>
</body>

</html>