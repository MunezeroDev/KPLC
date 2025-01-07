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
                        <a href="#" class="profile-tab active">Report Outage</a>
                    </nav>

                    <form id="report_outage" method="post">
                        <div class="form-box">

                            <div class="form-groups">

                                <!-- type_of_outage -->
                                <div class="form-group medium">
                                    <label>Type of Outage</label>
                                    <select name="type_of_outage" required>
                                        <option disabled selected>Select what you're experiencing</option>
                                        <option>Complete Power Loss</option>
                                        <option>Partial Power Loss </option>
                                        <option>Flickering or Dimming Lights</option>
                                        <option>Equipment Acting Strange</option>
                                        <option>Intermittent Power</option>
                                    </select>
                                </div>

                                <!-- time_of_outage -->
                                <div class="form-group small">
                                    <label>When did the outage start?</label>
                                    <input type="datetime-local" name="outage_start_time" required>
                                </div>

                                <!-- duration_of_outage -->
                                <div class="form-group small">
                                    <label>Approximate Duration </label>
                                    <input type="number" name="duration_minutes" min="1" placeholder="(in minutes)">
                                </div>

                            </div>

                            <div class="form-groups">
                                <!-- priority of_outage -->
                                <div class="form-group small">
                                    <label>Priority Level</label>
                                    <select name="priority_level" required>
                                        <option disabled selected>How urgent is this issue?</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>

                                <!-- location of_outage -->
                                <div class="form-group small">
                                    <label>Specific Location</label>
                                    <input type="text" name="location" required placeholder="Street address, area, or landmark">
                                </div>
                            </div>

                            <div class="form-groups">
                                <!-- suspected reason of_outage -->
                                <div class="form-group small">
                                    <label>Suspected Reason</label>
                                    <select name="suspected_reason">
                                        <option disabled selected>What might have caused this?</option>
                                        <option value="weather">Bad Weather (Storm, Lightning, etc.)</option>
                                        <option value="transformer">Transformer Issues (loud noises, sparks)</option>
                                        <option value="vehicle">Vehicle Accident with Power Line</option>
                                        <option value="construction">Construction or Maintenance Work</option>
                                        <option value="unknown">Not Sure</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group small">
                                    <label>How should we contact you?</label>
                                    <select name="preferred_contact">
                                        <option disabled selected>Select contact method</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone Call</option>
                                        <option value="sms">SMS Text Message</option>
                                    </select>
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