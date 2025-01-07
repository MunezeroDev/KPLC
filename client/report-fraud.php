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
                <div class="full-width-alert">
                    <div class="alert-content">
                        <span class="message"></span>
                    </div>
                    <button class="action-button">Cancel</button>
                </div>

                <div class="profile-details-container report">
                    <nav class="profile-tabs">
                        <a href="#" class="profile-tab active">Report Fraud</a>
                    </nav>

                    <form id="report-fraud" method="post">
                        <div class="form-box">
                            <div class="form-groups">

                                <!-- fraud type  -->
                                <div class="form-group inner">
                                    <label>Type of Fraud</label>
                                    <select name="fraud_type" required>
                                        <option disabled selected>Select type of fraud</option>
                                        <option>Meter Tampering</option>
                                        <option>Illegal Connection</option>
                                        <option>Billing Fraud</option>
                                        <option>Employee Misconduct</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <!-- date of observation  -->
                                <div class="form-group inner">
                                    <label>Date of Observation </label>
                                    <input type="date" name="date_of_observation" required>
                                </div>


                            </div>

                            <div class="form-groups">
                                <!-- prefered method of communication  -->
                                <div class="form-group inner">
                                    <label>Preferred Communication Mode</label>
                                    <select name="preferred_contact" required>
                                        <option disabled selected>Select Method of Communication</option>
                                        <option>Email</option>
                                        <option>Phone Contact</option>
                                        <option>SMS </option>
                                    </select>
                                </div>

                                <!-- locations  -->
                                <div class="form-group inner">
                                    <label>Location of Incident </label>
                                    <input type="text" name="location" required placeholder="Street address, area, or landmark">
                                </div>
                            </div>

                            <div class="form-groups">
                                <!-- detailed description  -->
                                <div class="form-group inner">
                                    <label>Detailed Description </label>
                                    <textarea name="detailed_description" required placeholder="Please provide as much detail as possible about the suspected fraud"></textarea>
                                </div>


                            </div>
                        </div>

                        <button type="submit" class="update-button">Submit Report</button>
                    </form>
                </div>
            </section>
        </main>

        <!-- success modal  -->

        <!-- ./success modal -->

        <script src="js/main.js"></script>
    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>