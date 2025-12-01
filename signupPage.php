<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign Up — Personal Expense Tracker</title>
    <link rel="stylesheet" href="html/css/style.css">
</head>
<body>
    <div class="signup-page">
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>

        <!-- Page Header -->
        <div class="signupHeader">
            <h1>Personal Expense Tracker</h1>
            <h4>Sign Up</h4>
        </div>

        <!-- Error Message -->
        <?php
        session_start();
        if (isset($_SESSION['signup_errors'])) {
            echo '<div class="error-message">';
            foreach ($_SESSION['signup_errors'] as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['signup_errors']);
        }
        ?>

        <!-- Sign Up Form -->
        <form action="signup.php" method="post">
            <div class="signupForm">
                <label for="username">Username</label>
                <input placeholder="Username" id="username" name="username" type="text" required>
            </div>
            
            <div class="signupForm">
                <label for="su-email">Email</label>
                <input placeholder="Email" id="su-email" name="email" type="email" required>
            </div>

            <div class="signupForm">
                <label for="su-password">Password</label>
                <input placeholder="Password" id="su-password" name="password" type="password" required>
            </div>

            <div class="signupButton">
                <button type="submit">Create account</button>
                <p>Already have an account? <a href="loginPage.php">Login</a></p>
            </div>
        </form>
    </div>
</body>

</html>