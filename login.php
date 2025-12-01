<?php
/**
 * Login Handler
 * Authenticates users and creates session
 */

require_once 'config.php';

// Checks if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validates whether input is filled
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no errors, proceed with authentication
    if (empty($errors)) {
        $conn = getDBConnection();
        
        // Get user from database
        $login_query = "SELECT id, username, email, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $login_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password is correct, create session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['logged_in'] = true;
                
                // Redirects to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid username or password";
            }
        } else {
            $errors[] = "Invalid username or password";
        }
        
        closeDBConnection($conn);
    }
    
    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        header("Location: loginPage.php");
        exit();
    }
} else {
    // If accessed directly without POST, redirect to login page
    header("Location: loginPage.php");
    exit();
}
?>

