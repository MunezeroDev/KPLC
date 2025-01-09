<?php

/**
 * Secure logout script that:
 * 1. Unsets all session variables
 * 2. Destroys the session
 * 3. Redirects to login page
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to login page using same path construction as in the login script
$host = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = "../staff/staff-login.php";

header("Location: http://$host$uri/$extra");
exit;
