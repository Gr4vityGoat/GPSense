<!DOCTYPE html> <!-- Declarition -->
<html lang="en"> <!-- Root Element -->

<head>
    <meta charset="UTF-8"> <!-- Character set (supports most characters and symbols) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Standard viewport (sets the width of the page to follow the screen-width of the device with intial zoom level) -->
    <title>Register — GPSense</title>

    <link rel="stylesheet" href="/assets/css/register.css"> <!-- Links external CSS file-->
</head>

<body>
    <div class="register-container"> <!-- Main register box -->
        <img src="/assets/images/thelogo.png" alt="GPSense Logo">

        <h2>Create your
            <span class="highlight">GPS<span>ense</span></span> Account!
        </h2>

        <!-- Register Form -->
        <form action="/pages/registerhandler.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>

        <p>
            Already have an account?
            <a href="/pages/login.php" class="login-link">Login here!</a>
        </p>
    </div>
    <!-- Footer Include -->
    <?php include(__DIR__ . '/../includes/footer.php') ?>
</body>

</html>