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

// Fetch connection information 
$query_outage = "SELECT * FROM outages ORDER BY outage_id";
$stmt = $mysqliObj->prepare($query_outage);
$stmt->execute();
$result_outage = $stmt->get_result();


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

                <div class="members">
                    <div class="members-tabs">
                        <a href="outage_history.php" class="members-tab active">Outage History </a>
                        <a href="fault_history.php" class="members-tab">Fault History </a>
                    </div>
                </div>

                <!-- Table Container with Pagination -->
                <div class="table-container">
                    <div class="member-management">
                        <div class="search-box">
                            <i class='bx bx-search'></i>
                            <input type="text" class="search-input" placeholder="Search members...">
                        </div>
                        <!-- <button class="add-new-btn">
                        <i class='bx bx-plus'></i>
                        Add new
                    </button> -->
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Report ID</th>

                                <th>Outage Type</th>
                                <th>Start Time</th>
                                <th>Duration</th>
                                <th>Priority</th>
                                <th>Preferred Contact</th>
                                <th>Reason Given</th>

                                <th>Progress</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Display the results
                            if ($result_outage) {

                                while ($outage = $result_outage->fetch_assoc()) {
                                    echo "
                                        <tr>
                                            <td>
                                                <div class='user-id'>" . htmlspecialchars($outage['outage_id']) . "</div>
                                            </td>

                                            <td>" . htmlspecialchars($outage['type_of_outage']) . "</td>
                                            <td>" . htmlspecialchars($outage['outage_start_time']) . "</td>
                                            <td>" . htmlspecialchars($outage['duration_minutes']) . "</td>
                                             <td>" . htmlspecialchars($outage['priority_level']) . "</td>
                                            <td>" . htmlspecialchars($outage['preferred_contact']) . "</td>

                                            <td>" . htmlspecialchars($outage['suspected_reason']) . "</td>
                                            <td>" . htmlspecialchars($outage['report_progress']) . "</td>
                                            <td>
                                                <div class='operations'>
                                                    <i class='bx bx-trash operation-icon delete' title='Delete' data-id='" . htmlspecialchars($outage['outage_id']) . "'></i>
                                                </div>
                                            </td>
                                        </tr>";
                                }

                                // Clean up our database resources
                                $result_outage->free();
                            }

                            ?>

                            <!-- More rows can be added here -->
                        </tbody>
                    </table>

                    <!-- Pagination within table container -->
                    <div class="pagination">
                        <div class="pagination-info">
                            Showing 1 to 10 of 57 entries
                        </div>
                        <div class="pagination-controls">
                            <button class="page-btn">Previous</button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <button class="page-btn">4</button>
                            <button class="page-btn">5</button>
                            <button class="page-btn">6</button>
                            <button class="page-btn">Next</button>
                        </div>
                    </div>
                </div>

            </section>
        </main>

        <script src="../assets/js/main.js"></script>
    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>