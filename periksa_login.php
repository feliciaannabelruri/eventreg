<?php 
// Connect to the database
include 'koneksi.php';

// Capture data sent from the form
$username = $_POST['username'];
$password = $_POST['password']; // Get the plain text password

// Prepare the SQL statement to prevent SQL injection
$stmt = $koneksi->prepare("SELECT * FROM admin WHERE admin_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching record was found
if ($result->num_rows > 0) {
    session_start(); // Start the session
    $data = $result->fetch_assoc();
    
    // Verify password with password_verify()
    if (password_verify($password, $data['admin_password'])) {
        // Set session variables
        $_SESSION['id'] = $data['admin_id'];
        $_SESSION['nama'] = $data['admin_nama'];
        $_SESSION['username'] = $data['admin_username'];
        $_SESSION['status'] = "login";

        header("Location: admin/"); // Redirect to admin panel
        exit(); // Ensure no further code is executed
    } else {
        // Password is incorrect
        header("Location: login.php?alert=gagal"); // Redirect back to login with error
        exit(); // Ensure no further code is executed
    }
} else {
    // Username not found
    header("Location: login.php?alert=gagal"); // Redirect back to login with error
    exit(); // Ensure no further code is executed
}
?>
