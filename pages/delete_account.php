<?php
session_start();
require_once ('../includes/mysqli_connect.php');

if (!isset($_SESSION['user_id']) || $_POST['confirm_delete'] !== 'yes') {
    header("Location: account.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "DELETE FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$_SESSION['account_deleted'] = true;
header("Location: register.html");
exit;
?>
