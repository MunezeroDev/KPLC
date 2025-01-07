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
                    <h1> Welcome <?php echo $obj->first_name; ?> </h1>
                </section>

                <div class="summary">
                    <div class="summary-item item-1">
                        <div class="content-left">
                            <h3>Power up</h3>
                            <p class="value">Get Connected</p>
                            <a href="new_connection.php"><button>Learn more</button></a>
                        </div>
                    </div>

                    <div class="summary-item item-2">
                        <div class="content-left">
                            <h3>How to</h3>
                            <p class="value">Report Fault</p>
                            <a href="report_fault.php"><button>Learn more</button></a>
                        </div>
                    </div>
                </div>

                <div class="summary">
                    <div class="summary-item item-3">
                        <div class="content-left">
                            <h3>How to</h3>
                            <p class="value">Report an outage</p>
                            <a href="report_outage.php"><button>Learn more</button></a>
                        </div>
                    </div>

                    <div class="summary-item item-4">
                        <div class="content-left">
                            <h3>How to</h3>
                            <p class="value">Report fraud </p>
                            <a href="report-fraud.php"><button>Learn more</button></a>
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