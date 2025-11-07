<?php # Handle login script
session_start();  // Start session first
include('../mysqli_connect.php');

# Pass form data
$username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
$password = mysqli_real_escape_string($mysqli, trim($_POST['password']));

# Formulate the query to check if password matches with the database
$query = "SELECT * from users WHERE username = '$username' AND password = SHA2('$password', 256)";

# Run the query
$result = mysqli_query($mysqli, $query);

$row_count = mysqli_num_rows($results)

#If a match found
if ($row_count == 1) {

    # Set up a session variable
    $_SESSION['user_id'] = $row['id']; // primary key from database used to define a session var
    $row =  mysqli_fetch_array($result,MYSQLI_ASSOC); //fetch user's row from database
    
    # After we set up a session var, and before redirect
    $_SESSION['username'] = $row['username']; //set up 2nd session var set -> can be accessed later
    

    header("Location: ../.html");
    exit();


} else { // no match send back
    header("Location: login.html?error=1");
    exit();

}
?>