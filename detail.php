<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM buku_anak WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Buku: <?= $data['judul']; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #e3faf2; padding: 50px; }
        .card { background: white; padding: 30px; border-radius: 20px; max-width: 600px; margin: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .cover-besar { width: 100%; border-radius: 15px; margin-bottom: 20px; }
        .btn-back { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #2ec4b6; color: white; text-decoration: none; border-radius: 10px; }
    </style>
</head>
<body>
<div class="card">
    <img src="<?= $data['cover']; ?>" class="cover-besar">
    <h1><?= $data['judul']; ?></h1>
    <p><strong>Penulis:</strong> <?= $data['penulis']; ?></p>
    <p><strong>Kategori:</strong> <?= $data['kategori']; ?></p>
    <p><strong>Usia:</strong> <?= $data['usia']; ?></p>
    <hr>
   <div style="background: #ffffff; padding: 25px; border-radius: 15px; border: 1px solid #e0e0e0; max-height: 500px; overflow-y: auto; text-align: justify; line-height: 1.8; color: #444; font-size: 16px;">
    
    <?php echo nl2br($data['deskripsi']); ?>

</div>
<div class="detail-container">
    <a href="index.php" style="display: block; margin-bottom: 20px; text-decoration: none; color: #555;">
        ⬅️ Kembali ke Daftar Buku
    </a>

    <h1><?= $data['judul']; ?></h1>
    <p>Oleh: <?= $data['penulis']; ?></p>
    
    <div class="isi-cerita">
        <?= $data['sinopsis']; ?> </div>

    <a href="index.php" style="display: block; margin-top: 40px; padding: 15px; background: #eee; text-align: center; border-radius: 10px; text-decoration: none; color: #333; font-weight: bold;">
        ⬅️ Selesai Membaca, Kembali ke Beranda
    </a>
</div>
<audio id="auto-bg-audio" loop></audio>

<script>
    // Ambil kategori dari database PHP kamu
    // Pastikan $data adalah variabel yang berisi data buku di detail.php
    const kategoriBuku = "<?= $data['kategori'] ?? 'default'; ?>"; 

    // 1. Daftar File (Pastiin sama persis nama filenya)
    const daftarMusik = {
        dashboard: "audio/Dashboard.MP3",
        dongeng: "audio/Dongeng.MP3",
        fiksi: "audio/Fiksi.MP3"
    };

    // 2. Fungsi Tentukan Lagu (Sesuai Kategori Buku)
    function tentukanLagu() {
        if (kategoriBuku === 'Dongeng') return daftarMusik.dongeng;
        if (kategoriBuku === 'Fiksi') return daftarMusik.fiksi;
        return daftarMusik.dashboard;
    }

    // 3. Simpan waktu saat pindah halaman
    let audioSistem = document.getElementById("auto-bg-audio");
    window.onbeforeunload = function() {
        sessionStorage.setItem("laguWaktu", audioSistem.currentTime);
    };

    // 4. Load & Play (Memastikan musik lanjut terus)
    window.onload = function() {
        audioSistem.src = tentukanLagu();
        audioSistem.load();
        
        let waktuTerakhir = sessionStorage.getItem("laguWaktu");
        if (waktuTerakhir) audioSistem.currentTime = parseFloat(waktuTerakhir);
        
        audioSistem.volume = parseFloat(localStorage.getItem("volumeMusik") || "0.5");
        
        if (localStorage.getItem("statusMusik") === "ON") {
            audioSistem.play().catch(() => {});
        }
        syncTampilan();
    };

    // 5. Sinkronisasi tampilan
    function syncTampilan() {
        let toggle = document.getElementById("globalMusicToggle");
        if (toggle) toggle.checked = (localStorage.getItem("statusMusik") === "ON");
    }

    // 6. Fungsi Switch ON/OFF
    function switchMusikGlobal() {
        let checkbox = document.getElementById("globalMusicToggle");
        if (checkbox && checkbox.checked) {
            localStorage.setItem("statusMusik", "ON");
            audioSistem.play();
        } else {
            localStorage.setItem("statusMusik", "OFF");
            audioSistem.pause();
        }
    }

    // 7. Fungsi Kontrol Volume
    function ubahVolumeGlobal(val) {
        audioSistem.volume = parseFloat(val);
        localStorage.setItem("volumeMusik", val);
    }
</script>
</body>
</html>