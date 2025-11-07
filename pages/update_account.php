<?php
session_start();
require_once ('../includes/mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = mysqli_real_escape_string($mysqli, $_POST['username']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$password = trim($_POST['password']);

if (!empty($password)) {
    $query = "UPDATE users SET username = ?, email = ?, password = SHA2(?, 256) WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssi", $username, $email, $password, $user_id);
} else {
    $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssi", $username, $email, $user_id);
}

$stmt->execute();
$_SESSION['username'] = $username; // update session
$_SESSION['update_success'] = true;

header("Location: account.php");
exit;

