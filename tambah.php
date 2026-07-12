<?php
include 'koneksi.php';

if (isset($_POST['Simpan'])) {
    $judul    = $_POST['judul'];
    $penulis  = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $usia     = $_POST['usia'];
    $deskripsi = $_POST['deskripsi'];
    $cover    = $_POST['cover'];

    // LOGIKA SAKTI BARU: Deteksi kategori otomatis kalau link cover kosong
    if (empty($cover)) {
        if (strtolower($kategori) == 'dongeng') {
            // Gambar buku cerita dongeng kastil ajaib yang lucu
            $cover = "https://img.freepik.com/free-vector/fairytale-castle-book-concept_23-2148496429.jpg";
        } else {
            // Gambar astronot/roket untuk petualangan fiksi anak
            $cover = "https://img.freepik.com/free-vector/cute-astronaut-flying-with-rocket-cartoon-vector-icon-illustration-science-technology-icon_138676-6355.jpg";
        }
    }

    $query = "INSERT INTO buku_anak (judul, penulis, kategori, usia, deskripsi, cover) 
              VALUES ('$judul', '$penulis', '$kategori', '$usia', '$deskripsi', '$cover')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Buku Berhasil Ditambah! 🚀'); window.location='index.php?page=daftar_buku';</script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku Baru ✨</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #c1dfc4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 450px; border: 5px solid #ff9f1c; }
        h2 { text-align: center; color: #2ec4b6; margin-top: 0; }
        label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; font-size: 14px; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 2px solid #eee; border-radius: 10px; box-sizing: border-box; font-family: 'Quicksand'; }
        textarea { height: 80px; }
        .btn-simpan { width: 100%; background: #ff9f1c; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 16px; transition: 0.3s; }
        .btn-simpan:hover { background: #e78e13; transform: scale(1.02); }
        .btn-batal { display: block; text-align: center; margin-top: 10px; color: #999; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>🦁 Tambah Buku Baru</h2>
    <form method="POST">
        <label>Judul Buku</label>
        <input type="text" name="judul" placeholder="Contoh: Petualangan Kiko" required>

        <label>Penulis</label>
        <input type="text" name="penulis" placeholder="Nama penulis..." required>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label>Kategori</label>
                <input type="text" name="kategori" placeholder="Dongeng/Fiksi" required>
            </div>
            <div style="flex: 1;">
                <label>Usia</label>
                <input type="text" name="usia" placeholder="4-6 Tahun" required>
            </div>
        </div>

        <label>Link Cover Buku (Boleh dikosongkan)</label>
        <input type="text" name="cover" placeholder="Tempel link gambar di sini...">

        <label>Deskripsi</label>
        <textarea name="deskripsi" placeholder="Ceritakan sedikit tentang buku ini..."></textarea>

        <button type="submit" name="Simpan" class="btn-simpan">✨ Simpan Buku</button>
        <a href="index.php?page=daftar_buku" class="btn-batal">Batal & Kembali</a>
    </form>
</div>

</body>
</html>