<?php 
include 'koneksi.php';

// Ambil input dari form
$nama  = $_POST['nama'];
$email = $_POST['email'];
$hp = $_POST['hp'];
$alamat = $_POST['alamat'];
$password = $_POST['password'];

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location:daftar.php?alert=invalid_email");
    exit;
}

// Hash password dengan password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah email sudah ada
$cek_email = $koneksi->prepare("SELECT * FROM member WHERE member_email = ?");
$cek_email->bind_param("s", $email);
$cek_email->execute();
$result = $cek_email->get_result();

if($result->num_rows > 0){
    // Jika email sudah terdaftar
    header("location:daftar.php?alert=duplikat");
} else {
    // Jika email belum terdaftar, masukkan data ke database
    $stmt = $koneksi->prepare("INSERT INTO member (member_nama, member_email, member_hp, member_password, member_alamat) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $email, $hp, $hashed_password, $alamat);
    $stmt->execute();

    // Redirect ke halaman login
    header("location:masuk.php?alert=terdaftar");
}
?>
