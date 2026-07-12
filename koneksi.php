<?php
$host = "sql213.infinityfree.com";
$user = "if0_42394017";
$pass = "AMPYqikfQD"; // Masukkan password akun InfinityFree kamu di sini
$db   = "if0_42394017_perpustakaan";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
