<?php

if (file_exists(__DIR__ . '/.env')) {
    $env = parse_ini_file(__DIR__ . '/.env');
    $host = $env['DB_HOST'];
    $username = $env['DB_USERNAME'];
    $password = $env['DB_PASSWORD'];
    $database = $env['DB_NAME'];
} else {
    // Update with your actual database credentials
    $host = "localhost";
    $username = "u571101154_eventregist";
    $password = "Eventregist123";
    $database = "u571101154_eventregist";
}

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (!mysqli_set_charset($koneksi, "utf8")) {
    die("Error loading character set utf8: " . mysqli_error($koneksi));
}

// // Koneksi berhasil
// echo "Koneksi berhasil!";

// Ingat untuk selalu menutup koneksi saat selesai menggunakan
// mysqli_close($koneksi);

?>
