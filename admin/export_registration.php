<?php
include '../koneksi.php';

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch event name for the header
    $event_query = mysqli_query($koneksi, "SELECT event_nama FROM event WHERE event_id = '$event_id'");
    $event = mysqli_fetch_array($event_query);
    $event_name = $event['event_nama'];

    // Prepare the CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="registrations_' . $event_name . '.csv"');

    $output = fopen('php://output', 'w');

    // Set CSV headers
    fputcsv($output, ['ID Anggota', 'Nama Anggota', 'HP Anggota', 'Email Anggota', 'Alamat Anggota', 'Tanggal Pendaftaran']);

    // Query to get registrants data
    $registrants_query = mysqli_query($koneksi, "
        SELECT m.member_id, m.member_nama, m.member_hp, m.member_email, m.member_alamat, er.registration_date 
        FROM event_registration er 
        JOIN member m ON er.member_id = m.member_id 
        WHERE er.event_id = '$event_id'
    ");

    // Fetch and write each row to CSV
    while ($registrant = mysqli_fetch_array($registrants_query)) {
        fputcsv($output, [
            $registrant['member_id'], 
            $registrant['member_nama'], 
            $registrant['member_hp'], 
            $registrant['member_email'], 
            $registrant['member_alamat'], 
            $registrant['registration_date']
        ]);
    }

    fclose($output);
    exit();
}
?>
