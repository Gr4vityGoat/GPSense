<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.html");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>GPSense | Home</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
  <a href="home.html">Start Quiz</a>
  <a href="account.php">Manage Account</a>
</body>
</html>
