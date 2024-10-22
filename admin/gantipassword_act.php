<?php 
include '../koneksi.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("location:login.php"); // Redirect to login if not logged in
    exit();
}

$id = $_SESSION['id'];
$new_password = $_POST['password'];

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($koneksi, "UPDATE admin SET admin_password=? WHERE admin_id=?");
mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $id);

if (mysqli_stmt_execute($stmt)) {
    header("location:gantipassword.php?alert=sukses");
} else {
    header("location:gantipassword.php?alert=gagal"); // Redirect if there is an error
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>
