<?php 
// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$email = $_POST['email'];
$password = $_POST['password'];

// Query untuk mendapatkan data member berdasarkan email
$login = mysqli_query($koneksi, "SELECT * FROM member WHERE member_email='$email'");
$cek = mysqli_num_rows($login);

if($cek > 0){
    session_start();
    $data = mysqli_fetch_assoc($login);
    
    // Verifikasi password dengan password_verify()
    if(password_verify($password, $data['member_password'])){
        // Hapus session lain agar tidak bentrok dengan session member
        unset($_SESSION['id']);
        unset($_SESSION['nama']);
        unset($_SESSION['username']);
        unset($_SESSION['status']);

        // Buat session member
        $_SESSION['member_id'] = $data['member_id'];
        $_SESSION['member_status'] = "login";
        header("location:member.php");
    } else {
        // Password salah
        header("location:masuk.php?alert=gagal");
    }
} else {
    // Email tidak ditemukan
    header("location:masuk.php?alert=gagal");
}
?>
