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

                <section class="welcome-section">
                    <h1> Welcome <?php echo $obj->last_name; ?> </h1>
                </section>

                <div class="summary-container">
                    <div class="summary">
                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Total Connections</h3>
                                <p class="value">40,876</p>
                                <p class="summary-status up">
                                    <i class='bx bx-up-arrow-alt'></i>
                                    Up from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M460-200h40v-74l140-140v-186H320v186l140 140v74Zm-80 80v-120L240-380v-220q0-33 23.5-56.5T320-680h40l-40 40v-200h80v160h160v-160h80v200l-40-40h40q33 0 56.5 23.5T720-600v220L580-240v120H380Zm100-280Z" />
                                </svg>
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Recent Connections</h3>
                                <p class="value">38,876</p>
                                <p class="summary-status up">
                                    <i class='bx bx-up-arrow-alt'></i>
                                    Up from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M460-200h40v-74l140-140v-186H320v186l140 140v74Zm-80 80v-120L240-380v-220q0-33 23.5-56.5T320-680h40l-40 40v-200h80v160h160v-160h80v200l-40-40h40q33 0 56.5 23.5T720-600v220L580-240v120H380Zm100-280Z" />
                                </svg>
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Total Profit</h3>
                                <p class="value">$12,876</p>
                                <p class="summary-status up">
                                    <i class='bx bx-up-arrow-alt'></i>
                                    Up from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <i class='bx bx-dollar-circle'></i>
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Total Outages</h3>
                                <p class="value">11,086</p>
                                <p class="summary-status down">
                                    <i class='bx bx-down-arrow-alt'></i>
                                    Down from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <i class='bx bx-refresh'></i>
                            </div>
                        </div>
                    </div>

                    <div class="summary">
                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Total Connections</h3>
                                <p class="value">40,876</p>
                                <p class="summary-status up">
                                    <i class='bx bx-up-arrow-alt'></i>
                                    Up from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M460-200h40v-74l140-140v-186H320v186l140 140v74Zm-80 80v-120L240-380v-220q0-33 23.5-56.5T320-680h40l-40 40v-200h80v160h160v-160h80v200l-40-40h40q33 0 56.5 23.5T720-600v220L580-240v120H380Zm100-280Z" />
                                </svg>
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Recent Connections</h3>
                                <p class="value">38,876</p>
                                <p class="summary-status up">
                                    <i class='bx bx-up-arrow-alt'></i>
                                    Up from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M460-200h40v-74l140-140v-186H320v186l140 140v74Zm-80 80v-120L240-380v-220q0-33 23.5-56.5T320-680h40l-40 40v-200h80v160h160v-160h80v200l-40-40h40q33 0 56.5 23.5T720-600v220L580-240v120H380Zm100-280Z" />
                                </svg>
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Total Profit</h3>
                                <p class="value">$12,876</p>
                                <p class="summary-status up">
                                    <i class='bx bx-up-arrow-alt'></i>
                                    Up from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <i class='bx bx-dollar-circle'></i>
                            </div>
                        </div>

                        <div class="summary-item">
                            <div class="admin-content-left">
                                <h3>Total Outages</h3>
                                <p class="value">11,086</p>
                                <p class="summary-status down">
                                    <i class='bx bx-down-arrow-alt'></i>
                                    Down from yesterday
                                </p>
                            </div>
                            <div class="icon-wrapper">
                                <i class='bx bx-refresh'></i>
                            </div>
                        </div>
                    </div>

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