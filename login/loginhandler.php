<?php
session_start();  // use session_start() to start session first, make sure no html output (spaces,empty lines,html tags) before this line
include('../mysqli_connect.php');

// Pass form data
$username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
$password = mysqli_real_escape_string($mysqli, trim($_POST['password']));

// Formulate the query to check if password matches with the database
$query = "SELECT * from users WHERE username = '$username' AND password = SHA2('$password', 256)";

// Run the query
$result = mysqli_query($mysqli, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Set a session variable
    $_SESSION['user_id'] = $row['id']; // primary key from database
    $_SESSION['username'] = $row['username'];

    

    header("Location: ../index.php");
    exit();


} else { // no match send back
    header("Location: login.html");
    exit();

}
?>