<?php
session_start();  // use session_start() to start session first, make sure no html output (spaces,empty lines,html tags) before this line
include('connect.php');
// Pass form data
$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$password = mysqli_real_escape_string($dbc, trim($_POST['password']));

// Formulate the query to check if password matches with the database
$query = "SELECT * from users WHERE username = '$username' AND password = SHA2('$password', 256)"; 

// Run the query
$result = mysqli_query($dbc, $query);

$row_cnt = mysqli_num_rows($result);

//verify login
if($row_cnt == 1){ 
    // Set a session variable
    $_SESSION['username'] = $username;

    // retrieve database info
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    
    
    // direction of handle
    if($row['is_admin'] == '1'){ 
        $_SESSION['admin'] = '1';
        header('Location: admin_home.html');
        exit();
    }else {
        $_SESSION['admin'] = '0';
        header("Location: home.html");
        exit();
    }
    

}else{ // no match send back
    header("Location: login.html");
    exit();
    
}
?>