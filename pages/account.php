<?php
session_start();
require_once ('../includes/mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT username, email FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>


</body>
<!DOCTYPE html> <!-- Declaration -->
<html lang="en"> <!-- Root Element -->
<head>
  <meta charset="UTF-8"> <!-- Character set (supports most characters and symbols) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!-- Standard viewport (sets the width of the page to follow the screen-width of the device with initial zoom level) -->
    <title>Account Settings</title>

    <link rel="stylesheet" href="/assets/css/account.css">
</head>
<body>
<?php
if (isset($_SESSION['update_success'])) {
    echo "<div style='background-color: #e0ffe0; border:1px solid #00aa00; padding:10px; margin-bottom:15px;'>
      Account updated successfully!
    </div>";
    unset($_SESSION['update_success']);
}
?>
  <div class="title-container">
    <h1>👤 Account Settings</h1>
  </div>

  <div class="account-container">
      <img src="/assets/images/blank_profile.jpeg" alt="Profile Picture" class="profile-picture">

  <?php
  // Welcome message to user
  echo "<h2>".$_SESSION['username'] ."</h2>";
  ?>
  </div>

  <form action="update_account.php" method="POST">
    <label>Username:</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

    <label>New Password:</label>
    <input type="password" name="password"><br>

    <button type="submit">Update Account</button>
  </form>

  <h3>Danger Zone</h3>
  <form action="delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
    <button type="submit" name="confirm_delete" value="yes" style="color:red;">Delete My Account</button>
  </form>

  <form action="home.php" method="GET">
    <button type="submit">Back to Home</button>
  </form>

  <form action="logout.php" method="POST">
    <button type="submit">Sign Out</button>
  </form>
  <!-- Footer Include -->
  <?php include(__DIR__ . '/../includes/footer.php') ?>
</body>
</html>