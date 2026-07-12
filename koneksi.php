<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_baca_anak";

// Membuat koneksi dengan penanganan error yang lebih rapi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$conn) {
    // Memberikan pesan error yang jelas dan menghentikan proses
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Opsional: Set charset ke utf8 agar tidak ada masalah dengan karakter unik
mysqli_set_charset($conn, "utf8");
?>