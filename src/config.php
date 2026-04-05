<?php
// Database configuration
// BUG 1: Hard-coded credentials (Security Issue)
$db_host = "db";
$db_user = "library_user";
$db_pass = "library_pass";
$db_name = "library_db";

// Create connection
// BUG 2: Using mysqli without proper error handling
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Use UTF-8 for the database connection to avoid Thai text corruption
mysqli_set_charset($conn, "utf8mb4");

// Send correct HTTP charset header
header('Content-Type: text/html; charset=UTF-8');

// Session configuration
session_start();

// Helper function for debugging
// BUG 4: Debug mode always on - Security Issue
define('DEBUG_MODE', false);

function debug_log($message) {
    if (DEBUG_MODE) {
        error_log($message);
        echo "<!-- DEBUG: $message -->";
    }
}
?>
