<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt1 = $koneksi->prepare("DELETE FROM event_registration WHERE event_id = ?");
    if ($stmt1) {
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();
    }

    $stmt2 = $koneksi->prepare("DELETE FROM event WHERE event_id = ?");
    if ($stmt2) {
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        if ($stmt2->affected_rows > 0) {
            header("Location: event.php?alert=hapus");
        } else {
            echo "Event ID not found or could not be deleted.";
        }
        $stmt2->close();
    } else {
        echo "SQL Error: " . mysqli_error($koneksi);
    }
} else {
    echo "No ID provided.";
}

$koneksi->close();
?>
