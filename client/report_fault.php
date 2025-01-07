<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

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
                        <a href="#" class="profile-tab active">Report Fault</a>
                    </nav>

                    <form id="report_fault" method="post">
                        <div class="form-box">
                            <!-- outage details  -->
                            <div class="form-groups">

                                <!-- nature of fault-->
                                <div class="form-group medium">
                                    <label>Nature of Fault</label>
                                    <select name="nature_of_fault" required>
                                        <option disabled selected>Select Nature of Fault</option>
                                        <option>Sparking pole</option>
                                        <option>Damaged Cables</option>
                                        <option>Damaged Transformer </option>
                                        <option>Flickering or Dimming Lights</option>
                                        <option>Infrastructure Damage</option>
                                        <option>Fires</option>
                                        <option>Others</option>
                                    </select>
                                </div>

                                <!-- severe nature-->
                                <div class="form-group small">
                                    <label>Severe level</label>
                                    <select name="severity_level" required>
                                        <option disabled selected>How urgent is this issue?</option>
                                        <option value="Critical">Critical</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>

                            <!-- location  -->
                            <div class="form-groups">
                                <!-- prefered method of communication  -->
                                <div class="form-group small">
                                    <label>How should we contact you?</label>
                                    <select name="preferred_contact">
                                        <option disabled selected>Select contact method</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone Call</option>
                                        <option value="sms">SMS Text Message</option>
                                    </select>
                                </div>

                                <div class="form-group small">
                                    <label>Specific Location</label>
                                    <input type="text" name="location" required placeholder="Street address, area, or landmark">
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="form-group large">
                                <label>Description</label>
                                <textarea name="description_of_issue" rows="4"
                                    placeholder="Please provide description of the fault at hand"></textarea>
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