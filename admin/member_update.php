<?php 
include '../koneksi.php';

$id  = $_POST['id'];
$nama  = $_POST['nama'];
$email  = $_POST['email'];
$hp  = $_POST['hp'];
$alamat  = $_POST['alamat'];
$pwd  = $_POST['password'];

// Hash the password only if it's provided
if (!empty($pwd)) {
    $password = password_hash($pwd, PASSWORD_DEFAULT);
}

// Check image
$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

// Update member data based on conditions
if ($pwd == "" && $filename == "") {
    mysqli_query($koneksi, "UPDATE member SET member_nama='$nama', member_email='$email', member_hp='$hp', member_alamat='$alamat' WHERE member_id='$id'");
    header("location:member.php");
} elseif ($pwd == "") {
    if (!in_array($ext, $allowed)) {
        header("location:member.php?alert=gagal");
    } else {
        move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/member/' . $rand . '_' . $filename);
        $x = $rand . '_' . $filename;
        mysqli_query($koneksi, "UPDATE member SET member_nama='$nama', member_email='$email', member_hp='$hp', member_alamat='$alamat', member_foto='$x' WHERE member_id='$id'");		
        header("location:member.php?alert=berhasil");
    }
} elseif ($filename == "") {
    mysqli_query($koneksi, "UPDATE member SET member_nama='$nama', member_email='$email', member_hp='$hp', member_alamat='$alamat', member_password='$password' WHERE member_id='$id'");
    header("location:member.php");
} else {
    if (!in_array($ext, $allowed)) {
        header("location:member.php?alert=gagal");
    } else {
        move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/member/' . $rand . '_' . $filename);
        $x = $rand . '_' . $filename;
        mysqli_query($koneksi, "UPDATE member SET member_nama='$nama', member_email='$email', member_hp='$hp', member_alamat='$alamat', member_password='$password', member_foto='$x' WHERE member_id='$id'");		
        header("location:member.php?alert=berhasil");
    }
}
?>
