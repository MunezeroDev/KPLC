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

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div>
                        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </section>
        </main>

        <script src="js/main.js"></script>
        <script>
            
        </script>
    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>