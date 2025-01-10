<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

// $user_id = $_SESSION['national_id'];
$user_id = $_SESSION['user_id'];

// Fetch all users
$allUsersQuery = "SELECT * FROM users";
$resultAllUsers = $mysqliObj->query($allUsersQuery);

// Fetch staff users
$staffQuery = "SELECT * FROM users WHERE role = 'STAFF'";
$resultStaff = $mysqliObj->query($staffQuery);

// Fetch admin users
$adminQuery = "SELECT * FROM users WHERE role = 'ADMIN'";
$resultAdmin = $mysqliObj->query($adminQuery);

// Fetch clients
$clientQuery = "SELECT * FROM users WHERE role = 'CLIENT'";
$resultClient = $mysqliObj->query($clientQuery);

// Fetch connection requests
$connectionQuery = "SELECT * FROM connections";
$resultConnections = $mysqliObj->query($connectionQuery);

// Fetch faults requests
$faultsQuery = "SELECT * FROM faults";
$resultfaults = $mysqliObj->query($faultsQuery);

// Fetch outage requests
$outagesQuery = "SELECT * FROM outages";
$resultOutages = $mysqliObj->query($outagesQuery);

// Fetch frauds requests
$fraudsQuery = "SELECT * FROM frauds";
$resultFrauds = $mysqliObj->query($fraudsQuery);

// Count the number of each category
$countAllUsers = $resultAllUsers->num_rows;
$countStaff = $resultStaff->num_rows;
$countAdmins = $resultAdmin->num_rows;
$countClients = $resultClient->num_rows;

$countConns = $resultConnections->num_rows;
$countFaults = $resultfaults->num_rows;
$countOutages = $resultOutages->num_rows;
$countFrauds = $resultFrauds->num_rows;

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

                <div class="metrics-container">
                    <div class="metric-card customers">
                        <div class="metric-title">
                            TOTAL USERS
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countAllUsers; ?></div>
                    </div>

                    <div class="metric-card orders">
                        <div class="metric-title">
                            REGULAR CITIZENS
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countClients; ?></div>
                    </div>

                    <div class="metric-card delivered">
                        <div class="metric-title">
                            STAFF MEMBERS
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countStaff; ?></div>
                    </div>

                    <div class="metric-card pending">
                        <div class="metric-title">
                            ADMINISTRATORS
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countAdmins; ?></div>
                    </div>
                </div>

                <div class="metrics-container">
                    <div class="metric-card orders">
                        <div class="metric-title">
                            CONNECTION REQUESTS
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countConns; ?></div>
                    </div>

                    <div class="metric-card customers">
                        <div class="metric-title">
                            OUTAGES REPORTED
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M23 11h-3v-2h3V11zM8 11v2h8v-2h-8zm-4 2h2v-2H4v2zm18.32 3.89C21.27 19.18 18.91 21 16 21c-2.91 0-5.27-1.82-6.32-4.11-.33.09-.68.11-1.03.11-2.13 0-3.92-1.53-4.24-3.57C2.88 12.88 2 11.55 2 10c0-1.94 1.44-3.55 3.32-3.87C6.51 3.62 8.97 2 12 2c3.03 0 5.49 1.62 6.68 4.13C20.56 6.45 22 8.06 22 10c0 1.55-.88 2.88-2.41 3.43-.32 2.04-2.11 3.57-4.24 3.57-.35 0-.7-.02-1.03-.11z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countOutages; ?></div>
                    </div>

                    <div class="metric-card faults">
                        <div class="metric-title">
                            FAULTS REPORTED
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countFaults; ?></div>
                    </div>

                    <div class="metric-card frauds">
                        <div class="metric-title">
                            FRAUDS REPORTED
                            <svg class="metric-icon" viewBox="0 0 24 24">
                                <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                            </svg>
                        </div>
                        <div class="metric-value"><?php echo $countFrauds; ?></div>
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