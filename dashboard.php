<?php
/**
 * Dashboard Page
 * Main page after user login - displays expense tracker interface
 */

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginPage.php");
    exit();
}

//Get the users information from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Personal Expense Tracker</title>
    <link rel="stylesheet" href="html/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #1b6c72 0%, #2a8a92 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 20px;
        }
        .sidebar-header h2 {
            margin: 0;
            font-size: 20px;
            color: white;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            margin: 0;
        }
        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: #fff;
        }
        .sidebar-menu a i {
            margin-right: 10px;
            width: 20px;
        }
        /* Main Content Area */
        .dashboard-container {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background: #f5f5f5;
        }
        .welcome-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .welcome-section h1 {
            margin: 0;
            color: #333;
        }
        .logout-btn {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #c82333;
        }
        .form-section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-section h3 {
            margin-top: 0;
            color: #1b6c72;
            border-bottom: 2px solid #1b6c72;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #1b6c72;
        }
        .btn {
            padding: 10px 20px;
            background: #1b6c72;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2a8a92;
        }
        .view-records-btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .view-records-btn:hover {
            background: #0056b3;
        }
        html {
            scroll-behavior: smooth;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .dashboard-container {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- This is the Sidebar code -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>💰 Expense Tracker</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
                <li><a href="dashboard.php#add-income">💰 Add Income</a></li>
                <li><a href="dashboard.php#add-expense">➕ Add Expense</a></li>
                <li><a href="dashboard.php#add-savings">💵 Add Savings</a></li>
                <li><a href="view_records.php">📋 View Records</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="dashboard-container">
            <div class="welcome-section">
                <div>
                    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
                    <p style="margin: 5px 0; color: #666;">Personal Expense Tracker Dashboard</p>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>

        <!-- This displays success and error messages after form submission -->
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div style="color: green; padding: 10px; margin: 10px 0; background: #e6ffe6; border-radius: 5px; text-align: center;">';
            echo '<p>' . htmlspecialchars($_SESSION['success_message']) . '</p>';
            echo '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div style="color: red; padding: 10px; margin: 10px 0; background: #ffe6e6; border-radius: 5px; text-align: center;">';
            echo '<p>' . htmlspecialchars($_SESSION['error_message']) . '</p>';
            echo '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <!-- Add Income Form -->
        <div class="form-section" id="add-income">
            <h3>Add Income</h3>
            <form action="add_income.php" method="post">
                <div class="form-group">
                    <label for="income_amount">Amount:</label>
                    <input type="number" step="0.01" name="amount" id="income_amount" required>
                </div>
                <div class="form-group">
                    <label for="income_category">Category:</label>
                    <select name="category" id="income_category" required>
                        <option value="">Select Category</option>
                        <option value="Salary">Salary</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Investment">Investment</option>
                        <option value="Business">Business</option>
                        <option value="Gift">Gift</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="income_description">Description:</label>
                    <textarea name="description" id="income_description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="income_date">Date:</label>
                    <input type="date" name="income_date" id="income_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" class="btn">Add Income</button>
            </form>
        </div>

        <!-- Add Expense Form -->
        <div class="form-section" id="add-expense">
            <h3>Add Expense</h3>
            <form action="add_expense.php" method="post">
                <div class="form-group">
                    <label for="expense_amount">Amount:</label>
                    <input type="number" step="0.01" name="amount" id="expense_amount" required>
                </div>
                <div class="form-group">
                    <label for="expense_category">Category:</label>
                    <select name="category" id="expense_category" required>
                        <option value="">Select Category</option>
                        <option value="Food">Food</option>
                        <option value="Transport">Transport</option>
                        <option value="Shopping">Shopping</option>
                        <option value="Bills">Bills</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="expense_description">Description:</label>
                    <textarea name="description" id="expense_description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="expense_date">Date:</label>
                    <input type="date" name="expense_date" id="expense_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" class="btn">Add Expense</button>
            </form>
        </div>

        <!-- Add Savings Form -->
        <div class="form-section" id="add-savings">
            <h3>Add Savings</h3>
            <form action="add_savings.php" method="post">
                <div class="form-group">
                    <label for="savings_amount">Amount:</label>
                    <input type="number" step="0.01" name="amount" id="savings_amount" required>
                </div>
                <div class="form-group">
                    <label for="savings_description">Description:</label>
                    <textarea name="description" id="savings_description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="savings_date">Date:</label>
                    <input type="date" name="savings_date" id="savings_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" class="btn">Add Savings</button>
            </form>
        </div>

        <!-- View Records Section -->
        <div class="form-section">
            <h3>View Your Records</h3>
            <p><a href="view_records.php" class="view-records-btn">View All Records</a></p>
        </div>
        </div>
    </div>
</body>
</html>

