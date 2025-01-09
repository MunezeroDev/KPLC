<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// require_once('notification.php');
// include('notification.php');

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


                <?php
                if (isset($_SESSION['notification_message'])) {
                    // Decode the notification message
                    $notification = json_decode($_SESSION['notification_message'], true);

                    // Access individual parts of the message
                    $staff_id = $notification['staff_id'];
                    $connection_id = $notification['connection_id'];
                    $message = $notification['message'];

                    if ($staff_id === $obj->user_id) {
                ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>New Tasks: </strong> <?php echo $message; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                    }
                    // Clear the notification message after processing
                    unset($_SESSION['notification_message']);
                } else {
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>New Tasks: </strong> No New Task assigned at this time.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                }
                ?>

            </section>
        </main>

        <script src="js/main.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const closeButtons = document.querySelectorAll('[data-dismiss="alert"]');
                closeButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        const alert = this.closest('.alert');
                        alert.classList.remove('show');
                        setTimeout(function() {
                            alert.remove();
                        }, 150);
                    });
                });
            });
        </script>

    </body>

    </html>

<?php
}
$stmt->close();
$mysqliObj->close();
?>