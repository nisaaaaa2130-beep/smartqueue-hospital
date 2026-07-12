<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Cek ke database (Asumsi tabelnya 'users')
// Pastikan nama kolom 'username' dan 'password' sesuai dengan di database kamu
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['user_nama'] = $data['username'];

    // Penanda untuk suara login
    $_SESSION['baru_login'] = true;
    
    header("Location: index.php");
} else {
    echo "<script>alert('Login Gagal! Username atau Password salah.'); window.location='login.php';</script>";
}
?>