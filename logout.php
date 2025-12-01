<?php
/**
 * Logout Handler
 */

require_once 'config.php';

// Destroy session
session_destroy();

// Redirect to login page
header("Location: loginPage.php");
exit();
?>

