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

<!DOCTYPE html>
<html>
<head>
  <title>Account Settings</title>
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
  <h2><span class="icon">👤</span>Account Info</h2>
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
</body>
</html>