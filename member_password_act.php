<?php 
// Menghubungkan dengan koneksi
include 'koneksi.php';

// Memulai session
session_start();

// Ambil ID member dari session
$id = $_SESSION['member_id'];

// Ambil password baru dari form
$new_password = $_POST['password'];

// Validasi panjang password (opsional, tapi direkomendasikan)
if(strlen($new_password) < 5) {
    header("location:member_password.php?alert=short_password");
    exit;
}

// Hash password baru menggunakan password_hash()
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update password di database
mysqli_query($koneksi, "UPDATE member SET member_password='$hashed_password' WHERE member_id='$id'");

// Redirect ke halaman member_password.php dengan alert sukses
header("location:member_password.php?alert=sukses");
?>
