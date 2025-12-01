<?php
/**
 * Add Income Handler
 */

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginPage.php");
    exit();
}

//This block handles the form submission for adding income
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $amount = floatval($_POST['amount']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $income_date = $_POST['income_date'];
    

    //checks whether the required fields are filled and valid
    if ($amount > 0 && !empty($category) && !empty($income_date)) {
        $conn = getDBConnection();
        
        $query = "INSERT INTO income (user_id, amount, category, description, income_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "idsss", $user_id, $amount, $category, $description, $income_date);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Income added successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to add income. Please try again.";
        }
        
        closeDBConnection($conn);
    } else {
        $_SESSION['error_message'] = "Please fill in all required fields.";
    }
}

header("Location: dashboard.php");
exit();
?>

