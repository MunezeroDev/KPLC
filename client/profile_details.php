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

while ($obj = $result->fetch_object()) {
    // echo $obj->first_name;
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
                        <a href="#" class="profile-tab active">User Profile Setting</a>
                    </nav>

                    <form id="profile-form" method="post">
                        <div class="form-grid">

                            <!-- UserID  -->
                            <div class="form-group">
                                <label for="nationID" class="form-label">UserID</label>
                                <input type="tel" type="text" id="nationID" name="nationID" class="form-input readonly" value="<?php echo $obj->user_id; ?>" readonly>
                            </div>

                            <!-- first-name  -->
                            <div class="form-group">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-input" id="fname" name="fname" value="<?php echo $obj->first_name; ?>">
                            </div>

                            <!-- last-name  -->
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" id="lname" name="lname" class="form-input" value="<?php echo $obj->last_name; ?>">
                            </div>

                            <!-- d-o-b -->
                            <div class="form-group">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-input" value="<?php echo $obj->date_of_birth; ?>">
                            </div>

                            <!-- gender  -->
                            <div class="form-group">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="<?php echo $obj->gender; ?>" selected><?php echo $obj->gender; ?></option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Others</option>
                                </select>
                            </div>

                            <!-- email  -->
                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-input" name="email" id="email" value="<?php echo $obj->email; ?>">
                            </div>

                            <!-- mobile-number  -->
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" id="number" name="number" class="form-input" value="<?php echo $obj->mobile_number; ?>">
                            </div>

                            <!-- Id-number  -->
                            <div class="form-group">
                                <label for="nationID" class="form-label">ID/PC Number</label>
                                <input type="tel" type="text" id="nationID" name="nationID" class="form-input" value="<?php echo $obj->national_id; ?>">
                            </div>

                            <!-- county  -->
                            <div class="form-group">
                                <label for="countySelect" class="form-label">County</label>
                                <select id="countySelect" name="countySelect" class="form-select">
                                    <option value="<?php echo $obj->county; ?>" selected><?php echo $obj->county; ?></option>
                                </select>
                            </div>

                            <!-- town  -->
                            <div class="form-group">
                                <label for="townSelect" class="form-label">Town</label>
                                <select id="townSelect" name="townSelect" class="form-select">
                                    <option value="<?php echo $obj->town; ?>" selected><?php echo $obj->town; ?></option>
                                </select>
                            </div>

                            <!-- connection  -->
                            <div class="form-group">
                                <label for="connection" class="form-label">Home Connection Type</label>
                                <select id="connection" name="connection" class="form-select">
                                    <option value="<?php echo $obj->connection_type; ?>" selected><?php echo $obj->connection_type; ?></option>
                                    <option>Residential</option>
                                    <option>Commercial</option>
                                    <option>Industrial</option>
                                </select>
                            </div>

                            <!-- no of connection  -->

                            <!-- accounttype  -->

                        </div>

                        <button type="submit" class="update-button">Update</button>
                    </form>
                </div>
            </section>
        </main>

        <script src="js/main.js"></script>
        <script src="js/credentials.js"></script>
    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>