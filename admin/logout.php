<?php 
session_start(); // Start the session

// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the index page with a logout alert
header("Location: ../index.php?alert=logout");
exit(); // Ensure no further code is executed after redirection
?>
