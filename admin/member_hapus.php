<?php 
include '../koneksi.php';
$id = $_GET['id'];

// Delete from event registration
mysqli_query($koneksi, "DELETE FROM event_registration WHERE member_id='$id'");

// Finally, delete the member
mysqli_query($koneksi, "DELETE FROM member WHERE member_id='$id'");

// Redirect to member page
header("location:member.php");
?>
