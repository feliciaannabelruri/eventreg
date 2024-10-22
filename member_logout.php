<?php 
include 'koneksi.php';

session_start();

// Check if a session is active
if (session_status() === PHP_SESSION_ACTIVE) {
    // Clear all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();
}

// Redirect to the index page
header("Location: index.php?alert=logout_success");
exit();
?>
