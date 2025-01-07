<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

// $user_id = $_SESSION['national_id'];
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $mysqliObj->prepare($query);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();

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

                <!-- message  -->
                <div class="full-width-alert">
                    <div class="alert-content">
                        <span class="message"></span>
                    </div>
                    <button class="action-button">Cancel</button>
                </div>

                <!-- Request  -->
                <div class="profile-details-container report">
                    <nav class="profile-tabs">
                        <a href="#" class="profile-tab active">Request Connection</a>
                    </nav>

                    <form id="conn_form" method="post">
                        <div class="form-box">

                            <div class="form-groups">
                                <!-- connection type-->
                                <div class="form-group medium">
                                    <label>Type of Connection</label>
                                    <select name="connection_type" required>
                                        <option disabled selected>Select Connection</option>
                                        <option>Residential</option>
                                        <option>Commercial</option>
                                        <option>Industrial</option>
                                        <option>Temporary</option>
                                        <option>Others</option>
                                    </select>
                                </div>

                                <!-- premise type-->
                                <div class="form-group small">
                                    <label>Type of Premise</label>
                                    <select name="premises_type" required>
                                        <option disabled selected>Select Premises </option>
                                        <option>House</option>
                                        <option>Flat/Apartment</option>
                                        <option>Shop/Office</option>
                                        <option>Warehouse/Factory</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <!-- property_ownership  -->
                                <div class="form-group small">
                                    <label>Property Ownership</label>
                                    <select name="property_ownership">
                                        <option disabled selected>Property Ownership</option>
                                        <option>Owned</option>
                                        <option>Rented</option>
                                        <option>Leased</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-groups">
                                <!-- phase  -->
                                <div class="form-group small">
                                    <label>Phase Type</label>
                                    <select required name="phase_type">
                                        <option disabled selected>Select Phase</option>
                                        <option>Single-phase</option>
                                        <option>Three-phase</option>
                                    </select>
                                </div>

                                <!-- specific location  -->
                                <div class="form-group small">
                                    <label>Specific Location</label>
                                    <input type="text" name="location" required placeholder="Street address, area, or landmark">
                                </div>

                            </div>

                        </div>
                        <button type="submit" class="update-button">Submit Report</button>
                    </form>
                </div>
            </section>
        </main>

        <script src="js/main.js"></script>
    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>