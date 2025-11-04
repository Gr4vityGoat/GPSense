<?php
session_start();
include('/mysqli_connect.php');

// Get and sanitize input
$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
$password = mysqli_real_escape_string($dbc, trim($_POST['password']));

// Basic validation
if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required.");
}

// Check if username or email already exists
$checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$checkResult = mysqli_query($dbc, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    die("Username or email already exists.");
}

// Hash password
$hashedPassword = hash('sha256', $password);

// Insert new user
$insertQuery = "INSERT INTO users (username, email, password, is_admin) VALUES ('$username', '$email', '$hashedPassword', 0)";
$insertResult = mysqli_query($dbc, $insertQuery);

if ($insertResult) {
    $_SESSION['username'] = $username;
    $_SESSION['admin'] = '0';
    header("Location: home.php");
    exit();
} else {
    die("Registration failed: " . mysqli_error($dbc));
}
?>
