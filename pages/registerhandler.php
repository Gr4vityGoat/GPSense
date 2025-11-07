<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Debug: Print the attempted include path
$includePath = __DIR__ . '/../includes/mysqli_connect.php';
echo "Trying to include: " . $includePath . "<br>";

include $includePath;

// Get and sanitize input
$username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
$email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
$password = mysqli_real_escape_string($mysqli, trim($_POST['password']));

// Basic validation
if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required.");
}

// Check if username or email already exists
$checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$checkResult = mysqli_query($mysqli, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    die("Username or email already exists.");
}

// Hash password using SHA2 256-bit
$hashedPassword = mysqli_real_escape_string($mysqli, hash('sha256', $password));

// Insert new user
$insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
$insertResult = mysqli_query($mysqli, $insertQuery);

if ($insertResult) {
    header("Location: login.php");
    exit();
} else {
    die("Registration failed: " . mysqli_error($mysqli));
}
?>