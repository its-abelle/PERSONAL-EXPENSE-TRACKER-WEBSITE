<?php
/**
 * Add Expense Handler
 */

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginPage.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $amount = floatval($_POST['amount']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $expense_date = $_POST['expense_date'];
    
    //checks whether the required fields are filled and valid
    if ($amount > 0 && !empty($category) && !empty($expense_date)) {
        $conn = getDBConnection();
        
        // Insert expense into database
        $query = "INSERT INTO expenses (user_id, amount, category, description, expense_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "idsss", $user_id, $amount, $category, $description, $expense_date);
        
        // Execute and check for success
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Expense added successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to add expense. Please try again.";
        }
        //closes the database connection
        closeDBConnection($conn);
    } else {
        $_SESSION['error_message'] = "Please fill in all required fields.";
    }
}

header("Location: dashboard.php");
exit();
?>

