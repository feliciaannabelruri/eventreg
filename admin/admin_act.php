<?php 
include '../koneksi.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']); // Consider using password_hash for better security

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

// Start transaction for better error handling
mysqli_begin_transaction($koneksi);

try {
    if ($filename == "") {
        // Insert admin without a photo
        mysqli_query($koneksi, "INSERT INTO admin VALUES (NULL, '$nama', '$username', '$password', '')");
    } else {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed)) {
            throw new Exception("Invalid file type.");
        } else {
            move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/' . $rand . '_' . $filename);
            $file_gambar = $rand . '_' . $filename;

            // Insert admin with photo
            mysqli_query($koneksi, "INSERT INTO admin VALUES (NULL, '$nama', '$username', '$password', '$file_gambar')");
        }
    }

    // Commit transaction
    mysqli_commit($koneksi);
    header("location:admin.php");
} catch (Exception $e) {
    // Rollback transaction in case of error
    mysqli_rollback($koneksi);
    // Redirect or handle the error accordingly
    header("location:admin.php?alert=gagal");
}
?>
