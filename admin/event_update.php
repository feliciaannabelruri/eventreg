<?php 
include '../koneksi.php';

$id = $_POST['id'];
$nama_event  = $_POST['nama_event'];
$tanggal     = $_POST['tanggal'];
$waktu       = $_POST['waktu'];
$lokasi      = $_POST['lokasi'];
$deskripsi   = $_POST['deskripsi'];
$max_partisipan = $_POST['max_partisipan'];
$status      = $_POST['status'];

// Upload gambar dan banner event jika ada yang diupload
$rand = rand();
$allowed = array('gif','png','jpg','jpeg');
$banner_filename = $_FILES['banner']['name'];
$image_filename = $_FILES['image']['name'];

// Mengupdate event data
$query = "UPDATE event SET 
    event_nama='$nama_event', 
    event_tanggal='$tanggal', 
    event_waktu='$waktu', 
    event_lokasi='$lokasi', 
    event_deskripsi='$deskripsi', 
    event_max_partisipan='$max_partisipan', 
    event_status='$status'";

if($banner_filename != "") {
    $ext = pathinfo($banner_filename, PATHINFO_EXTENSION);
    if(in_array($ext, $allowed)) {
        move_uploaded_file($_FILES['banner']['tmp_name'], '../gambar/event/'.$rand.'_'.$banner_filename);
        $banner_path = $rand.'_'.$banner_filename;
        $query .= ", event_banner='$banner_path'";
    }
}

if($image_filename != "") {
    $ext = pathinfo($image_filename, PATHINFO_EXTENSION);
    if(in_array($ext, $allowed)) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../gambar/event/'.$rand.'_'.$image_filename);
        $image_path = $rand.'_'.$image_filename;
        $query .= ", event_image='$image_path'";
    }
}

$query .= " WHERE event_id='$id'";
mysqli_query($koneksi, $query);
header("location:event.php?alert=update");
?>
