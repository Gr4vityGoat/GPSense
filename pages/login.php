<!DOCTYPE html> <!-- Declarition -->
<html lang="en"> <!-- Root Element -->
<head>
    <meta charset="UTF-8"> <!-- Character set (supports most characters and symbols) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!-- Standard viewport (sets the width of the page to follow the screen-width of the device with intial zoom level) -->
    <title>Log In — GPSense</title>

    <link rel="stylesheet" href="/assets/css/login.css"> <!-- Links external CSS file-->
</head>
<body>
    <div class="login-container"> <!-- Main login box -->
        <img src="/assets/images/thelogo.png" alt="GPSense Logo" class="logo">
        
        <h2>Login to 
            <span class="highlight">GPS<span>ense</span></span>
        </h2>

        <!-- Show error if login fails -->
        <?php if (!empty($_GET['error']) && $_GET['error'] == 1): ?>
            <p class="error-message">Invalid username or password. Please try again</p>
        <?php endif; ?> 

        <!-- Login Form -->
        <form action="/pages/loginhandler.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <a href="/pages/register.html" class="register-link">Don't have an account? Create one!</a>
    </div>
    <!-- Footer Include -->
    <?php include('/includes/footer.php') ?>
</body>
</html>