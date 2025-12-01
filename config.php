<?php
/**
 * Database Configuration File
 */

// Database configuration for XAMPP
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Default XAMPP MySQL username
define('DB_PASS', '');            // Default XAMPP MySQL password (empty)
define('DB_NAME', 'expense_tracker');

// Create database connection
function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Set charset to utf8mb4 for proper character encoding
    mysqli_set_charset($conn, "utf8mb4");
    
    return $conn;
}

// Close database connection
function closeDBConnection($conn) {
    mysqli_close($conn);
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

