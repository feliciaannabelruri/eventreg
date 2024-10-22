<?php 
include '../koneksi.php';

$nama_event  = $_POST['nama_event'];
$tanggal     = $_POST['tanggal'];
$waktu       = $_POST['waktu'];
$lokasi      = $_POST['lokasi'];
$deskripsi   = $_POST['deskripsi'];
$max_partisipan = $_POST['max_partisipan'];
$status      = $_POST['status'];

// Upload gambar dan banner event
$rand = rand();
$allowed = array('gif','png','jpg','jpeg');
$banner_filename = $_FILES['banner']['name'];
$image_filename = $_FILES['image']['name'];

if($banner_filename != "") {
    $ext = pathinfo($banner_filename, PATHINFO_EXTENSION);
    if(!in_array($ext, $allowed)) {
        header("location:event.php?alert=gagal");
    } else {
        move_uploaded_file($_FILES['banner']['tmp_name'], '../gambar/event/'.$rand.'_'.$banner_filename);
        $banner_path = $rand.'_'.$banner_filename;
    }
} else {
    $banner_path = '';
}

if($image_filename != "") {
    $ext = pathinfo($image_filename, PATHINFO_EXTENSION);
    if(!in_array($ext, $allowed)) {
        header("location:event.php?alert=gagal");
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], '../gambar/event/'.$rand.'_'.$image_filename);
        $image_path = $rand.'_'.$image_filename;
    }
} else {
    $image_path = '';
}

// Insert event data into database
mysqli_query($koneksi, "INSERT INTO event (event_nama, event_tanggal, event_waktu, event_lokasi, event_deskripsi, event_max_partisipan, event_status, event_banner, event_image) VALUES ('$nama_event', '$tanggal', '$waktu', '$lokasi', '$deskripsi', '$max_partisipan', '$status', '$banner_path', '$image_path')");
header("location:event.php?alert=berhasil");
?>
