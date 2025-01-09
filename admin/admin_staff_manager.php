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

$queryrow = "SELECT u.*, sd.availability 
             FROM users u
             LEFT JOIN staff_details sd ON u.user_id = sd.staff_id
             WHERE u.role = ?
             ORDER BY u.user_id";

$stmt = $mysqliObj->prepare($queryrow);
$role = 'STAFF';
$stmt->bind_param('s', $role);
$stmt->execute();
$resultrow = $stmt->get_result();


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
                        <a href="admin_user_manager.php" class="members-tab">Clients</a>
                        <a href="admin_staff_manager.php" class="members-tab active">Staff</a>
                    </div>
                </div>

                <!-- Table Container with Pagination -->
                <div class="table-container">
                    <div class="member-management">
                        <div class="search-box">
                            <i class='bx bx-search'></i>
                            <input type="text" class="search-input" placeholder="Search members...">
                        </div>

                        <a href="admin_add_staff.php">
                            <button class="add-new-btn">
                                <i class='bx bx-plus'></i>
                                Add new staff
                            </button>
                        </a>

                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>userId</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>County </th>
                                <th>Town</th>
                                <th>Availability</th>

                                <th>Action</th>
                                <!-- <th>Operation</th> -->
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Display the results
                            if ($resultrow) {
                                // Fetch each client's data and display in table format
                                while ($row = $resultrow->fetch_assoc()) {
                                    echo "
                                        <tr>
                                            <td>
                                                <div class='user-id'>" . htmlspecialchars($row['user_id']) . "</div>
                                            </td>
                                            <td>" . htmlspecialchars($row['first_name']) . "</td>
                                            <td>" . htmlspecialchars($row['last_name']) . "</td>
                                            <td>" . htmlspecialchars($row['gender']) . "</td>
                                            <td>" . htmlspecialchars($row['email']) . "</td>
                                            <td>" . htmlspecialchars($row['mobile_number']) . "</td>
                                            <td>" . htmlspecialchars($row['county']) . "</td>
                                            <td>" . htmlspecialchars($row['town']) . "</td>
                                            <td>" . htmlspecialchars($row['availability']) . "</td>
                                            <td>
                                                <div class='operations'>
                                                    <i class='bx bx-trash operation-icon delete' title='Delete' data-id='" . htmlspecialchars($row['user_id']) . "'></i>
                                                </div>
                                            </td>
                                             <td>
                                                 <button class='assign-btn'  data-id='" . htmlspecialchars($row['user_id']) . "'>Assign</button>
                                            </td>
                                        </tr>";
                                }

                                // Clean up our database resources
                                $resultrow->free();
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