<?php

function check_login()
{
    if (
        !isset($_SESSION['user_id']) ||
        !isset($_SESSION['email']) ||
        !isset($_SESSION['logged_in'])
    ) {
        redirect_to_login("Incomplete session data");
    }

    if (
        empty($_SESSION['user_id']) ||
        empty($_SESSION['email']) ||
        $_SESSION['logged_in'] !== true
    ) {
        redirect_to_login("Invalid session data");
    }

    if (!isset($_SESSION['last_activity'])) {
        redirect_to_login("Session timing information missing");
    }

    $inactive_duration = time() - $_SESSION['last_activity'];
    $timeout_duration = 30 * 60; // 30 minutes in seconds

    if ($inactive_duration > $timeout_duration) {
        // Clear all session data
        session_unset();
        session_destroy();
        redirect_to_login("Session expired");
    }

    $_SESSION['last_activity'] = time();
}

/**
 * Helper function to handle redirects to login page
 * Centralizes redirect logic and session cleanup
 */
function redirect_to_login($reason = "")
{
    // Clear sensitive session data
    $_SESSION = array();

    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = "../client/client-login.php";

    header("Location: http://$host$uri/$extra");
    exit;
}

if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}
