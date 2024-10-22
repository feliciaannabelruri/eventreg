<?php 
include 'koneksi.php';
session_start();

$id = $_SESSION['member_id'];

// Get POST data
$nama = $_POST['nama'];
$email = $_POST['email'];
$hp = $_POST['hp'];
$alamat = $_POST['alamat'];

// Check if a file is uploaded
$allowed_extensions = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

// Fetch the current profile picture from the database
$result = mysqli_query($koneksi, "SELECT member_foto FROM member WHERE member_id='$id'");
$current_member = mysqli_fetch_assoc($result);
$current_foto = $current_member['member_foto'];

if (empty($filename)) {
    // No new file, update other fields only
    mysqli_query($koneksi, "UPDATE member SET member_nama='$nama', member_email='$email', member_hp='$hp', member_alamat='$alamat' WHERE member_id='$id'");
    header("Location: member_profil.php?alert=berhasil");
    exit();
} else {
    // Validate file extension
    if (!in_array($ext, $allowed_extensions)) {
        header("Location: member_profil.php?alert=gagal");
        exit();
    } else {
        // Handle file upload
        $rand = rand();
        $new_filename = $rand . '_' . $filename;
        
        // Delete the old profile picture if it exists
        if (!empty($current_foto)) {
            $old_file_path = 'gambar/member/' . $current_foto;
            if (file_exists($old_file_path)) {
                unlink($old_file_path); // Remove the old file
            }
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['foto']['tmp_name'], 'gambar/member/' . $new_filename)) {
            // Update database with new profile picture
            mysqli_query($koneksi, "UPDATE member SET member_nama='$nama', member_email='$email', member_hp='$hp', member_alamat='$alamat', member_foto='$new_filename' WHERE member_id='$id'");
            header("Location: member_profil.php?alert=berhasil");
            exit();
        } else {
            header("Location: member_profil.php?alert=gagal_upload");
            exit();
        }
    }
}
?>
