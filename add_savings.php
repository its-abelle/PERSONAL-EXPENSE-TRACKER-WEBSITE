<?php
/**
 * Add Savings Handler
 */

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginPage.php");
    exit();
}

//The block handles the form submission for adding savings
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $amount = floatval($_POST['amount']);
    $description = trim($_POST['description']);
    $savings_date = $_POST['savings_date'];
    
    if ($amount > 0 && !empty($savings_date)) {
        $conn = getDBConnection();
        
        // Insert savings into database
        $query = "INSERT INTO savings (user_id, amount, description, savings_date) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "idss", $user_id, $amount, $description, $savings_date);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Savings added successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to add savings. Please try again.";
        }
        
        closeDBConnection($conn);
    } else {
        $_SESSION['error_message'] = "Please fill in all required fields.";
    }
}

header("Location: dashboard.php");
exit();
?>

