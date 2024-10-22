<?php
session_start();
include 'koneksi.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: masuk.php?alert=belum_login");
    exit();
}

// Get event ID from the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
} else {
    // If there's no event ID in the URL, redirect to the event list page
    header("Location: member.php?alert=no_event");
    exit();
}

// Retrieve the logged-in user's ID
$member_id = $_SESSION['member_id'];
$member_nama = isset($_SESSION['member_nama']) ? $_SESSION['member_nama'] : '';

// Check if the user has already registered for this event
$cek_pendaftaran = mysqli_query($koneksi, "SELECT * FROM event_registration WHERE event_id = '$event_id' AND member_id = '$member_id'");
if (mysqli_num_rows($cek_pendaftaran) > 0) {
    // If already registered, redirect to the event list page with a message
    header("Location: member.php?alert=already_registered");
    exit();
}

// Retrieve the maximum number of participants for the event
$event_query = mysqli_query($koneksi, "SELECT event_max_partisipan FROM event WHERE event_id = '$event_id'");
$event_data = mysqli_fetch_assoc($event_query);
$max_participants = $event_data['event_max_partisipan'];

// Count the current number of participants registered for the event
$current_count_query = mysqli_query($koneksi, "SELECT COUNT(*) AS current_count FROM event_registration WHERE event_id = '$event_id'");
$current_count_data = mysqli_fetch_assoc($current_count_query);
$current_participants = $current_count_data['current_count'];

// Check if the current participants exceed the maximum limit
if ($current_participants >= $max_participants) {
    // If the event is full, redirect with a message
    header("Location: member.php?alert=event_full");
    exit();
}

// Process event registration
$daftar_event = mysqli_query($koneksi, "INSERT INTO event_registration (event_id, member_id, registration_date) VALUES ('$event_id', '$member_id', NOW())");

if ($daftar_event) {
    // If registration is successful
    header("Location: member.php?alert=registered_success");
} else {
    // If registration fails
    header("Location: member.php?alert=failed");
}
exit();
?>
