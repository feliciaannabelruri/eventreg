<?php
include 'koneksi.php'; // Make sure to include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration_id = $_POST['registration_id'];

    // Prepare and execute the deletion query
    $delete_query = "DELETE FROM event_registration WHERE registration_id = '$registration_id'";

    if (mysqli_query($koneksi, $delete_query)) {
        echo "Registration cancelled successfully.";
    } else {
        echo "Error cancelling registration: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi); // Close the connection
}
?>
