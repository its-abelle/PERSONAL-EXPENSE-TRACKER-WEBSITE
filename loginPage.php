<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login — Personal Expense Tracker</title>
    <link rel="stylesheet" href="html/css/style.css">
</head>
<body>
    <div class="loginBody">
        <!-- Navigation Bar -->
        <nav>
            <ul>
                      <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>

        <!-- Page Header -->
        <div class="loginHeader">
            <h1>Personal Expense Tracker</h1>
            <h4>Login</h4>
        </div>

        <!-- Error and Success Messages -->
        <?php
        session_start();
        if (isset($_SESSION['login_errors'])) {
            echo '<div class="error-message">';
            foreach ($_SESSION['login_errors'] as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['login_errors']);
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">';
            echo '<p>' . htmlspecialchars($_SESSION['success_message']) . '</p>';
            echo '</div>';
            unset($_SESSION['success_message']);
        }
        ?>

        <!-- Login Form -->
        <form action="login.php" method="post">
            <div class="loginForm">
                <label for="username">Username:</label>
                <input placeholder="Username" type="text" id="username" name="username" required>
            </div>

            <div class="loginForm">
                <label for="password">Password:</label>
                <input placeholder="Password" type="password" id="password" name="password" required>
            </div>

            <div class="loginButton">
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signupPage.php">Sign up</a></p>
            </div>
        </form>
    </div>
</body>
</html>