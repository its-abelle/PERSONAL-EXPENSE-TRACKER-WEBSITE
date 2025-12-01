<?php
/**
 * View Records Page
 * Displays all expenses, savings, and income for the logged-in user
 */

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$conn = getDBConnection();

// Fetch expenses
$expenses_query = "SELECT * FROM expenses WHERE user_id = ? ORDER BY expense_date DESC, created_at DESC";
$stmt = mysqli_prepare($conn, $expenses_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$expenses = mysqli_stmt_get_result($stmt);

// Fetch savings
$savings_query = "SELECT * FROM savings WHERE user_id = ? ORDER BY savings_date DESC, created_at DESC";
$stmt = mysqli_prepare($conn, $savings_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$savings = mysqli_stmt_get_result($stmt);

// Fetch income
$income_query = "SELECT * FROM income WHERE user_id = ? ORDER BY income_date DESC, created_at DESC";
$stmt = mysqli_prepare($conn, $income_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$income = mysqli_stmt_get_result($stmt);

// Connection is closed after all data is fetched in the HTML section
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records — Personal Expense Tracker</title>
    <link rel="stylesheet" href="html/css/style.css">
    <style>
        .records-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .back-btn, .logout-btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 10px;
        }
        .logout-btn {
            background: #dc3545;
        }
        .section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .total {
            font-weight: bold;
            font-size: 1.1em;
            color: #007bff;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="records-container">
        <div class="header-section">
            <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
            <a href="logout.php" class="logout-btn">Logout</a>
            <h1>Your Records</h1>
            <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        </div>

        <!-- Income Section -->
        <div class="section">
            <h2>Income</h2>
            <?php
            $total_income = 0;
            if (mysqli_num_rows($income) > 0) {
                echo '<table>';
                echo '<tr><th>Date</th><th>Amount</th><th>Category</th><th>Description</th></tr>';
                while ($row = mysqli_fetch_assoc($income)) {
                    $total_income += $row['amount'];
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['income_date']) . '</td>';
                    echo '<td>$' . number_format($row['amount'], 2) . '</td>';
                    echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '</tr>';
                }
                echo '<tr class="total"><td colspan="3">Total Income:</td><td>$' . number_format($total_income, 2) . '</td></tr>';
                echo '</table>';
            } else {
                echo '<p class="no-records">No income recorded yet.</p>';
            }
            ?>
        </div>

        <!-- Expenses Section -->
        <div class="section">
            <h2>Expenses</h2>
            <?php
            $total_expenses = 0;
            if (mysqli_num_rows($expenses) > 0) {
                echo '<table>';
                echo '<tr><th>Date</th><th>Amount</th><th>Category</th><th>Description</th></tr>';
                while ($row = mysqli_fetch_assoc($expenses)) {
                    $total_expenses += $row['amount'];
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['expense_date']) . '</td>';
                    echo '<td>$' . number_format($row['amount'], 2) . '</td>';
                    echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '</tr>';
                }
                echo '<tr class="total"><td colspan="3">Total Expenses:</td><td>$' . number_format($total_expenses, 2) . '</td></tr>';
                echo '</table>';
            } else {
                echo '<p class="no-records">No expenses recorded yet.</p>';
            }
            ?>
        </div>

        <!-- Savings Section -->
        <div class="section">
            <h2>Savings</h2>
            <?php
            $total_savings = 0;
            if (mysqli_num_rows($savings) > 0) {
                echo '<table>';
                echo '<tr><th>Date</th><th>Amount</th><th>Description</th></tr>';
                while ($row = mysqli_fetch_assoc($savings)) {
                    $total_savings += $row['amount'];
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['savings_date']) . '</td>';
                    echo '<td>$' . number_format($row['amount'], 2) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '</tr>';
                }
                echo '<tr class="total"><td colspan="2">Total Savings:</td><td>$' . number_format($total_savings, 2) . '</td></tr>';
                echo '</table>';
            } else {
                echo '<p class="no-records">No savings recorded yet.</p>';
            }
            ?>
        </div>

        

        <!-- Summary Section -->
        <div class="section">
            <h2>Summary</h2>
            <table>
                <tr>
                    <td>Total Income:</td>
                    <td class="total">$<?php echo number_format($total_income, 2); ?></td>
                </tr>
                <tr>
                    <td>Total Expenses:</td>
                    <td class="total">$<?php echo number_format($total_expenses, 2); ?></td>
                </tr>
                <tr>
                    <td>Total Savings:</td>
                    <td class="total">$<?php echo number_format($total_savings, 2); ?></td>
                </tr>                
                <tr>
                    <td>Net Balance (Income - Savings - Expenses):</td>
                    <td class="total">$<?php echo number_format($total_income - $total_savings - $total_expenses, 2); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Close database connection after all data has been fetched and displayed
closeDBConnection($conn);
?>

