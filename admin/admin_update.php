<?php 
include '../koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$pwd = $_POST['password'];
$password = !empty($pwd) ? password_hash($pwd, PASSWORD_DEFAULT) : null; // Hash only if not empty

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

// Start transaction
mysqli_begin_transaction($koneksi);

try {
    // Prepare update query
    $updateQuery = "UPDATE admin SET admin_nama='$nama', admin_username='$username'";

    // Check if password needs to be updated
    if (!empty($password)) {
        $updateQuery .= ", admin_password='$password'";
    }

    // Check if a new file is uploaded
    if (!empty($filename)) {
        if (!in_array($ext, $allowed)) {
            throw new Exception("Invalid file type.");
        } else {
            move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/' . $rand . '_' . $filename);
            $x = $rand . '_' . $filename;
            $updateQuery .= ", admin_foto='$x'";
        }
    }

    $updateQuery .= " WHERE admin_id='$id'";
    mysqli_query($koneksi, $updateQuery);

    // Commit transaction
    mysqli_commit($koneksi);
    header("location:admin.php?alert=berhasil");
} catch (Exception $e) {
    // Rollback transaction in case of error
    mysqli_rollback($koneksi);
    header("location:admin.php?alert=gagal");
}
?>
