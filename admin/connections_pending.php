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
// $query_conn = "SELECT * FROM connections ORDER BY connection_id";
$query_conn = "SELECT * FROM connections WHERE application_progress = 'Pending' ORDER BY connection_id";
$stmt = $mysqliObj->prepare($query_conn);
$stmt->execute();
$result_conn = $stmt->get_result();

$query_staff = "
        SELECT 
            u.user_id as staff_id,  
            u.first_name,
            u.last_name,
            s.availability
        FROM 
            users u
        INNER JOIN 
            staff_details s
        ON 
            u.user_id = s.staff_id
        WHERE 
            u.role = 'STAFF' AND 
            s.availability = 'available'
        ORDER BY 
            u.seq_id
        ";

$stmt = $mysqliObj->prepare($query_staff);
$stmt->execute();
$result_staff = $stmt->get_result();
$staff_count = $result_staff->num_rows;

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

                <!-- message  -->
                <div class="full-width-alert">
                    <div class="alert-content">
                        <span class="message"></span>
                    </div>
                    <button class="action-button">Cancel</button>
                </div>

                <div class="members">
                    <div class="members-tabs">
                        <a href="connection_view.php" class="members-tab ">All Connections</a>
                        <a href="connections_pending.php" class="members-tab active">Pending Connections</a>
                        <a href="connections_review.php" class="members-tab">Connections Under Review</a>
                    </div>
                </div>

                <!-- Table Container with Pagination -->
                <div class="table-container">
                    <div class="member-management">
                        <div class="search-box">
                            <i class='bx bx-search'></i>
                            <input type="text" class="search-input" placeholder="Search members...">
                        </div>
                    </div>

                    <div class="assign-task-container">
                        <div class="assign-task-close">
                            <a href="" class="assign-close-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                    <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                                </svg>
                            </a>
                        </div>

                        <div class='assign-header-section'>
                            <?php if ($staff_count > 0): ?>
                                <span>Available Staff</span>
                                <span class='assign-header-label'><?= $staff_count ?></span>
                            <?php else: ?>
                                <span>Available Staff</span>
                                <span class='assign-header-label'>Oops, no staff available now</span>
                            <?php endif; ?>
                        </div>

                        <ul class="assign-staff-list">
                            <?php
                            if ($staff_count > 0) {
                                while ($row = $result_staff->fetch_assoc()) {
                                    echo "
                                    <li class='assign-staff-item'>
                                        <div class='assign-staff-checkbox'></div>
                                        <div class='assign-staff-content'>
                                            <div class='task-name'>" .   htmlspecialchars($row['first_name']),  htmlspecialchars($row['last_name'])  . "</div>
                                            <div class='assign-staff-meta'>
                                                <a class='assign-staff-link' data-staff-id='" . htmlspecialchars($row['staff_id']) . "'>Assign</a>
                                            </div>
                                        </div>
                                    </li>
                                ";
                                }
                            }
                            ?>
                        </ul>


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


                                <th>Task Status</th>
                                <th>Progress</th>
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

                                            
                                            <td>" . htmlspecialchars($conn['connection_status']) . "</td>
                                            <td>" . htmlspecialchars($conn['application_progress']) . "</td>

                                            <td>
                                                 <button class='assign-btn'  data-id='" . htmlspecialchars($conn['connection_id']) . "'>Assign Staff</button>
                                            </td>
                                        </tr>";
                                }

                                // Clean up our database resources
                                $result_conn->free();
                            }

                            ?>


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