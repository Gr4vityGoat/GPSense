<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.html");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GPSense</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <main class="stacked-container">
    <header>
      <img src="images/thelogo.png" alt="GPSense Logo" class="logo">
    </header>
    <h1 class="app-title">
      <span class="highlight">
        GPS<span class="blue-text">ense</span>
      </span>
    </h1>

    <p class="greeting">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <a href="home.html" class="start-button">Start Quiz</a>
    <a href="account.php" class="start-button">Manage Account</a>
  </main>
</body>
</html>
