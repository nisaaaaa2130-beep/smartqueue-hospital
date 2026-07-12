<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // PENTING: Gunakan 'username' sesuai dengan nama kolom di database kamu
    $nama_baru = mysqli_real_escape_string($conn, $_POST['nama_baru']);
    $user_id = $_SESSION['user_id'];

    // Update kolom 'username' bukan 'nama'
    $sql = "UPDATE users SET username = '$nama_baru' WHERE id = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_nama'] = $nama_baru; 
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='index.php?page=pengaturan';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil</title>
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #fdfaf6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 300px; text-align: center; border: 2px solid #2ec4b6; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 2px solid #ddd; border-radius: 10px; box-sizing: border-box; }
        button { background: #2ec4b6; color: white; border: none; padding: 10px; width: 100%; border-radius: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h3>✏️ Edit Profil</h3>
        <form method="POST">
            <input type="text" name="nama_baru" value="<?= htmlspecialchars($_SESSION['user_nama'] ?? ''); ?>" required>
            <button type="submit" name="simpan">Simpan Perubahan</button>
        </form>
        <a href="index.php?page=pengaturan" style="color: #666; text-decoration: none; margin-top: 15px; display: block;">Kembali</a>
    </div>
</body>
</html>