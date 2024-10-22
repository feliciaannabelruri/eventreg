<?php 
include '../koneksi.php';

// Get data from POST request
$nama  = $_POST['nama'];
$email  = $_POST['email'];
$hp  = $_POST['hp'];
$alamat = $_POST['alamat'];
$pwd  = $_POST['password'];

// Hash the password
$password = password_hash($pwd, PASSWORD_DEFAULT);

// Handle file upload
$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

if ($filename == "") {
    // Insert without photo
    $stmt = $koneksi->prepare("INSERT INTO member (member_nama, member_email, member_hp, member_password, member_alamat, member_foto) VALUES (?, ?, ?, ?, ?, '')");
    $stmt->bind_param("ssssss", $nama, $email, $hp, $password, $alamat);
    if ($stmt->execute()) {
        header("location:member.php");
    } else {
        header("location:member.php?alert=gagal");
    }
    $stmt->close();
} else {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
        header("location:member.php?alert=gagal");
    } else {
        // Move uploaded file and insert data
        move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/member/' . $rand . '_' . $filename);
        $file_gambar = $rand . '_' . $filename;

        // Prepare statement to insert with photo
        $stmt = $koneksi->prepare("INSERT INTO member (member_nama, member_email, member_hp, member_password, member_alamat, member_foto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nama, $email, $hp, $password, $alamat, $file_gambar);
        
        if ($stmt->execute()) {
            header("location:member.php");
        } else {
            header("location:member.php?alert=gagal");
        }
        $stmt->close();
    }
}
?>
