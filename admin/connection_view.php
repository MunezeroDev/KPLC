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
$query_conn = "SELECT * FROM connections ORDER BY connection_id";
$stmt = $mysqliObj->prepare($query_conn);
$stmt->execute();
$result_conn = $stmt->get_result();

while ($obj = $result->fetch_object()) {
?>

    <!DOCTYPE html>
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
                        <a href="admin_user_manager.php" class="members-tab active">Connections</a>
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
                                <th>Connection ID</th>
                                <th>Connection</th>

                                <th>Premise</th>
                                <th>Ownership</th>
                                <th>Phase</th>

                                <th>Location</th>


                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Display the results
                            if ($result_conn) {
                                // Fetch each client's data and display in table format
                                while ($conn = $result_conn->fetch_assoc()) {
                                    echo "
                                        <tr>
                                            <td>
                                                <div class='user-id'>" . htmlspecialchars($conn['connection_id']) . "</div>
                                            </td> 
                                            <td>" . htmlspecialchars($conn['connection_type']) . "</td>

                                            <td>" . htmlspecialchars($conn['premises_type']) . "</td>
                                            <td>" . htmlspecialchars($conn['property_ownership']) . "</td>
                                            <td>" . htmlspecialchars($conn['phase_type']) . "</td>
                                         
                                            <td>" . htmlspecialchars($conn['location']) . "</td>

                                            <td>" . htmlspecialchars($conn['application_progress']) . "</td>
                                            <td>
                                                <div class='operations'>
                                                    <i class='bx bx-trash operation-icon delete' title='Delete' data-id='" . htmlspecialchars($conn['connection_id']) . "'></i>
                                                </div>
                                            </td>
                                        </tr>";
                                }

                                // Clean up our database resources
                                $result_conn->free();
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

        <script src="js/main.js"></script>
    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>