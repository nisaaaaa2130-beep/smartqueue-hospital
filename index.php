<?php
// WAJIB: Mulai sesi di baris paling atas!
session_start();

// 1. Cek Login: Jika user belum login, tendang ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit; // Berhenti di sini, kode di bawah tidak dijalankan
}
// 2. Panggil koneksi database
include 'koneksi.php';

// 3. Ambil data dengan filter dan pencarian
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Kueri dasar mengambil semua buku
$query = "SELECT * FROM buku_anak WHERE 1=1";

// Jika ada kategori yang dipilih
if ($filter != '') {
    $query .= " AND kategori = '$filter'";
}

// Jika kolom pencarian diisi dan di-enter
if ($keyword != '') {
    $query .= " AND (judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%')";
}

$tampil = mysqli_query($conn, $query);

// 4. Nama user dinamis (nanti bisa diambil dari database)
$nama_user = $_SESSION['user_nama'] ?? "Teman"; // Mengambil dari sesi login
$page = isset($_GET['page']) ? $_GET['page'] : 'daftar_buku';
?>

<!DOCTYPE html>
<html>

<head>
    <title id="app_title">Perpustakaan Digital Anak</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap">
    <link rel="stylesheet" href="style.css?v=5">
</head>

<body>

    <div class="main-wrapper">
        <div class="safari-bg">

            <div class="top-header">
                <a href="index.php?page=daftar_buku" style="text-decoration: none;">
                    <div class="nav-btn <?= ($page == 'daftar_buku') ? 'active' : ''; ?>"><span class="icon">🏠</span> Beranda</div>
                </a>
                <div class="logo-area">
                    <h1>Perpustakaan<br><span>Digital Anak</span></h1>
                    <p class="tagline">Tempat Membaca, Belajar, dan Berpetualang! ✨</p>
                </div>
                <div class="user-profile-container" style="position: relative;">
                    <div class="user-profile" onclick="toggleDropdown()" style="display: flex; align-items: center; cursor: pointer; background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px;">
                        <img src="profile.png" id="main-avatar" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #ff9f1c;">
                        <span style="margin-left: 10px; font-weight: bold;">Halo, <?= $nama_user; ?> 🔽</span>
                    </div>

                    <div id="avatar-dropdown" style="display: none; position: absolute; top: 55px; right: 0; background: white; padding: 15px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1000; width: 200px;">
                        <p style="margin: 0 0 10px 0; font-size: 14px;">Pilih Avatar:</p>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                            <img src="avatar1.jpg" onclick="changeAvatar('avatar1.jpg')" style="width: 60px; cursor: pointer; border-radius: 60%;">
                            <img src="avatar2.jpg" onclick="changeAvatar('avatar2.jpg')" style="width: 60px; cursor: pointer; border-radius: 60%;">
                            <img src="avatar3.jpg" onclick="changeAvatar('avatar3.jpg')" style="width: 75px; cursor: pointer; border-radius: 75%;">
                            <img src="avatar4.jpg" onclick="changeAvatar('avatar4.jpg')" style="width: 50px; cursor: pointer; border-radius: 50%;">
                            <img src="avatar5.jpg" onclick="changeAvatar('avatar5.jpg')" style="width: 70px; cursor: pointer; border-radius: 70%;">
                            <img src="profile.png" onclick="changeAvatar('profile.png')" style="width: 50px; cursor: pointer; border-radius: 50%;">

                        </div>
                    </div>
                </div>
                <script>
                    function toggleDropdown() {
                        var dropdown = document.getElementById("avatar-dropdown");
                        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
                    }

                    function changeAvatar(imgName) {
                        document.getElementById("main-avatar").src = imgName;
                        // Di sini kamu bisa tambahkan AJAX untuk simpan ke database tanpa refresh
                        alert("Avatar diubah ke: " + imgName);
                    }
                </script>
            </div>

            <div class="content-container">

                <div class="sidebar">
                    <a href="index.php?page=daftar_buku" style="text-decoration: none; color: inherit;">
                        <div class="menu-item <?= ($page == 'daftar_buku') ? 'active' : ''; ?>">📋 Daftar Buku</div>
                    </a>
                    <a href="index.php?page=kategori" style="text-decoration: none; color: inherit;">
                        <div class="menu-item <?= ($page == 'kategori') ? 'active' : ''; ?>">🎨 Kategori</div>
                    </a>
                    <a href="index.php?page=penulis" style="text-decoration: none; color: inherit;">
                        <div class="menu-item <?= ($page == 'penulis') ? 'active' : ''; ?>">✏️ Penulis</div>
                    </a>
                    <a href="index.php?page=pembaca" style="text-decoration: none; color: inherit;">
                        <div class="menu-item <?= ($page == 'pembaca') ? 'active' : ''; ?>">👶 Pembaca</div>
                    </a>
                    <a href="index.php?page=pengaturan" style="text-decoration: none; color: inherit;">
                        <div class="menu-item <?= ($page == 'pengaturan') ? 'active' : ''; ?>">⚙️ Pengaturan</div>
                    </a>
                </div>

                <div class="main-content">

                    <?php if ($page == 'daftar_buku') { ?>
                        <div class="content-header" style="display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-bottom: 20px;">

                            <h3 id="nav_daftar" style="margin: 0;">Daftar Buku Safari</h3>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <a href="tambah.php" class="btn-tambah" style="white-space: nowrap; margin: 0;">+ Tambah Buku Baru</a>

                                <form method="GET" action="index.php" style="margin: 0; flex: 1; max-width: 300px;">
                                    <input type="hidden" name="page" value="daftar_buku">
                                    <?php if ($filter != '') { ?>
                                        <input type="hidden" name="filter" value="<?= $filter; ?>">
                                    <?php } ?>
                                    <input type="text" name="keyword" placeholder="🔍 Cari buku..." value="<?= htmlspecialchars($keyword); ?>" style="width: 100%; padding: 10px; border-radius: 20px; border: 1px solid #ccc;">
                                </form>
                            </div>
                        </div>

                        <table class="safari-table">
                            <thead>
                                <tr>
                                    <th style="width: 8%;">No</th>
                                    <th style="width: 35%;">Judul Buku</th>
                                    <th style="width: 20%;">Penulis</th>
                                    <th style="width: 15%;">Kategori</th>
                                    <th style="width: 12%;">Usia</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data = mysqli_fetch_array($tampil)) {
                                ?>
                                    <tr>
                                        <td><span class="badge-no"><?= $no++; ?></span></td>
                                        <td class="book-title">
                                            <img src="<?= $data['cover']; ?>" alt="Cover" class="cover-mini">
                                            <a href="detail.php?id=<?= $data['id']; ?>" style="text-decoration:none; color:inherit; font-weight:bold;">
                                                <?= $data['judul']; ?>
                                            </a>
                                        </td>
                                        <td><?= $data['penulis']; ?></td>
                                        <td>
                                            <span class="badge-kategori <?= (strtolower($data['kategori']) == 'fiksi') ? 'fiksi' : 'dongeng'; ?>">
                                                <?= $data['kategori']; ?>
                                            </span>
                                        </td>
                                        <td class="age-text"><?= $data['usia']; ?></td>
                                        <td>
                                            <a href="edit.php?id=<?= $data['id']; ?>" class="action-btn btn-edit">✏️</a>
                                            <a href="hapus.php?id=<?= $data['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">🗑️</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } elseif ($page == 'kategori') { ?>
                        <div class="content-header">
                            <h3>🎨 Pembagian Kategori Buku</h3>
                        </div>
                        <p style="font-size: 15px; color: #555;">Pilih kategori petualangan membaca kamu hari ini:</p>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px;">
                            <a href="index.php?page=daftar_buku&filter=Dongeng" style="text-decoration: none;">
                                <div style="background: #e3faf2; padding: 25px; border-radius: 15px; border: 2px dashed #2ec4b6; text-align: center;">
                                    <h4 style="color: #2ec4b6; font-size: 20px; margin-bottom: 10px; margin-top: 0;">🧚 Dongeng Anak</h4>
                                    <p style="color: #666; font-size: 14px; margin: 0;">Kumpulan cerita legenda, fabel hewan, dan kisah ajaib yang seru.</p>
                                </div>
                            </a>
                            <a href="index.php?page=daftar_buku&filter=Fiksi" style="text-decoration: none;">
                                <div style="background: #fff3cd; padding: 25px; border-radius: 15px; border: 2px dashed #ffc107; text-align: center;">
                                    <h4 style="color: #ff9f1c; font-size: 20px; margin-bottom: 10px; margin-top: 0;">🚀 Fiksi & Petualangan</h4>
                                    <p style="color: #666; font-size: 14px; margin: 0;">Penjelajahan ruang angkasa, misteri hutan rahasia, dan petualangan pahlawan.</p>
                                </div>
                            </a>
                        </div>
                        
                        

                    <?php } elseif ($page == 'penulis') { ?>
                        <div class="content-header">
                            <h3>✏️ Sahabat Penulis Cerita</h3>
                        </div>
                        <p style="font-size: 15px; color: #555; margin-bottom: 25px;">Berikut adalah kakak-kakak hebat yang menulis cerita seru untukmu:</p>

                        <!-- Wadah Grid untuk Kartu Penulis (Otomatis Rapi ke Samping) -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">

                            <!-- 1. Kartu Kak Andi -->
                            <div style="background: white; border: 3px solid #ff9f1c; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #fff3cd; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">🧑‍💻</div>
                                <h4 style="margin: 5px 0; color: #ff9f1c; font-size: 18px;">Andi Wijaya</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">📖 Petualangan Kiko</strong>
                                </p>
                            </div>

                            <!-- 2. Kartu Kak Rudi -->
                            <div style="background: white; border: 3px solid #2ec4b6; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #e3faf2; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">👨‍🏫</div>
                                <h4 style="margin: 5px 0; color: #2ec4b6; font-size: 18px;">Rudi Hermawan</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">🐊 Kancil dan Buaya</strong>
                                </p>
                            </div>

                            <!-- 3. Kartu Kak Dian -->
                            <div style="background: white; border: 3px solid #e74c3c; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #fadbd8; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">👩‍🎨</div>
                                <h4 style="margin: 5px 0; color: #e74c3c; font-size: 18px;">Kak Dian</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">🌲 Hutan Rahasia & 🦔 Juli Landak</strong>
                                </p>
                            </div>

                            <!-- 4. Kartu Paman Budi -->
                            <div style="background: white; border: 3px solid #3498db; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #d6eaf8; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">👨‍🌾</div>
                                <h4 style="margin: 5px 0; color: #3498db; font-size: 18px;">Paman Budi</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">🌊 Kancil yang Cerdik di Sungai</strong>
                                </p>
                            </div>

                            <!-- 5. Kartu Tante Sari -->
                            <div style="background: white; border: 3px solid #9b59b6; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #ebdef0; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">👩‍🍳</div>
                                <h4 style="margin: 5px 0; color: #9b59b6; font-size: 18px;">Tante Sari</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">🐇 Lari Cepat Si Kelinci Putih</strong>
                                </p>
                            </div>

                            <!-- 6. Kartu Dewi Cholidatul -->
                            <div style="background: white; border: 3px solid #1abc9c; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #d1f2eb; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">👩‍🏫</div>
                                <h4 style="margin: 5px 0; color: #1abc9c; font-size: 18px;">Dewi Cholidatul</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">🎈 Kitty dan Balon Udara</strong>
                                </p>
                            </div>

                            <!-- 7. Kartu Afra Sinaga -->
                            <div style="background: white; border: 3px solid #f1c40f; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <div style="font-size: 40px; margin-bottom: 10px; background: #fef9e7; width: 70px; height: 70px; line-height: 70px; border-radius: 50%; display: inline-block;">👸</div>
                                <h4 style="margin: 5px 0; color: #f1c40f; font-size: 18px;">Afra Sinaga</h4>
                                <p style="color: #666; font-size: 14px; margin: 10px 0 0 0; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    Buku Cerita:<br><strong style="color: #333;">👑 Putri Naira dari Kerajaan Banda</strong>
                                </p>
                            </div>

                        </div>


                    <?php } elseif ($page == 'pembaca') { ?>
                        <div class="content-header">
                            <h3>👶 Statistik Pembaca</h3>
                        </div>

                        <!-- Nama User Dinamis -->
                        <p style="font-size: 15px; color: #555; margin-bottom: 20px;">
                            Halo <strong><?= $nama_user; ?></strong>, ini progres petualangan membacamu:
                        </p>

                        <!-- Kotak Utama Progres -->
                        <div style="background: #e3faf2; border: 2px solid #2ec4b6; border-radius: 20px; padding: 25px; margin-bottom: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.02);">
                            <h4 style="margin: 0 0 5px 0; color: #16a085; font-size: 16px;">Total Buku yang Dibaca:</h4>
                            <span style="font-size: 36px; font-weight: bold; color: #2ec4b6; display: block; margin-bottom: 15px;">8 Buku</span>

                            <!-- Progres Bar Interaktif -->
                            <div style="font-size: 13px; color: #666; margin-bottom: 5px; display: flex; justify-content: space-between;">
                                <span>Target Level Selanjutnya (Membaca 10 Buku)</span>
                                <strong>80%</strong>
                            </div>
                            <div style="background: #ffffff; border-radius: 10px; height: 15px; width: 100%; overflow: hidden; border: 1px solid #ddd;">
                                <div style="background: linear-gradient(90deg, #2ec4b6, #a3e4d7); width: 80%; height: 100%; border-radius: 10px;"></div>
                            </div>
                        </div>

                        <!-- Bagian Medali / Badge Penghargaan -->
                        <h4 style="color: #444; margin-bottom: 15px; font-size: 16px;">🏅 Medali Pencapaianmu:</h4>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 25px;">

                            <!-- Badge 1 -->
                            <div style="background: white; border: 2px solid #ff9f1c; border-radius: 15px; padding: 12px; text-align: center; width: 110px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                <div style="font-size: 35px; margin-bottom: 5px;">🥚</div>
                                <span style="font-size: 11px; font-weight: bold; color: #ff9f1c; display: block;">Kutu Buku Pemula</span>
                            </div>

                            <!-- Badge 2 -->
                            <div style="background: white; border: 2px solid #3498db; border-radius: 15px; padding: 12px; text-align: center; width: 110px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                <div style="font-size: 35px; margin-bottom: 5px;">🐣</div>
                                <span style="font-size: 11px; font-weight: bold; color: #3498db; display: block;">Penjelajah Cerita</span>
                            </div>

                            <!-- Badge 3 (Belum Terbuka / Masih Terkunci) -->
                            <div style="background: #f5f5f5; border: 2px dashed #ccc; border-radius: 15px; padding: 12px; text-align: center; width: 110px; opacity: 0.6;">
                                <div style="font-size: 35px; margin-bottom: 5px; filter: grayscale(100%);">👑</div>
                                <span style="font-size: 11px; font-weight: bold; color: #888; display: block;">Raja Dongeng</span>
                            </div>

                        </div>
                    
                        
                    <?php } elseif ($page == 'pengaturan') { ?>
                        <div class="content-header">
                            <h3 id="set-title">⚙️ Pengaturan Aplikasi</h3>
                        </div>

                        <div style="background: white; padding: 20px; border-radius: 15px; border: 1px solid #ddd; margin-top: 15px;">
                            <h4 style="color: #333; margin-top: 0;" id="set-acc-title">👤 Akun Saya</h4>
                            <p style="font-size: 14px; color: #666;" id="set-acc-desc">Ubah nama profil kamu di sini.</p>
                            <a href="edit_profil.php" style="background: #2ec4b6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: bold;">Edit Profil</a>

                            <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">

                            <h4 style="color: #333;" id="set-music-title">🎵 Musik Latar Otomatis</h4>
                            <p style="font-size: 14px; color: #666; margin-bottom: 15px;" id="set-music-desc">Musik akan otomatis berubah menyesuaikan halaman petualanganmu!</p>

                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <label style="position: relative; display: inline-block; width: 60px; height: 30px;">
                                    <input type="checkbox" id="globalMusicToggle" onclick="switchMusikGlobal()" style="opacity: 0; width: 0; height: 0;">
                                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;" id="sliderMusik"></span>
                                </label>
                                <span id="statusMusikGlobal" style="font-size: 15px; font-weight: bold; color: #666;">Musik Mati 🔇</span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px; background: #f9f9f9; padding: 10px 15px; border-radius: 10px; max-width: 300px; margin-bottom: 5px;">
                                <span style="font-size: 16px;">🔈</span>
                                <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="0.5" oninput="ubahVolumeGlobal(this.value)" style="flex: 1; cursor: pointer; accent-color: #2ec4b6;">
                                <span style="font-size: 16px;">🔊</span>
                                <span id="volumePersen" style="font-size: 13px; font-weight: bold; color: #666; min-width: 35px; text-align: right;">50%</span>
                            </div>

                            <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">

                            <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">

                            <h4 style="color: #e74c3c; margin-top: 0;" id="set-out-title">🚪 Keluar</h4>
                            <a href="logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold;" id="set-out-btn">Keluar dari Aplikasi</a>
                        </div>

                        
                    <?php } ?>
                    <audio id="auto-bg-audio" loop></audio>

                    <div class="fun-fact" style="margin-top: 40px;">
                        💡 <strong>Tahukah Kamu?</strong> Membaca buku setiap hari bisa membuat otak kita makin pintar dan imajinasi makin luas!
                    </div>

                    <div class="footer-text">
                        © 2026 Perpustakaan Digital Anak. Semua hak dilindungi. 💝
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // 1. Daftar file musik (LENGKAP)
        const daftarMusik = {
            dashboard: "audio/Dashboard.MP3",
            dongeng: "audio/Dongeng.MP3",
            fiksi: "audio/Fiksi.MP3"
        };

        const halamanSekarang = "<?= $page; ?>";
        const filterSekarang = "<?= $filter; ?>";
        let audioSistem = document.getElementById("auto-bg-audio");

        // 2. Tentukan lagu berdasarkan halaman/kategori buku yang dibuka
        function tentukanLagu() {
            if (halamanSekarang === 'daftar_buku' && filterSekarang === 'Dongeng') return daftarMusik.dongeng;
            if (halamanSekarang === 'daftar_buku' && filterSekarang === 'Fiksi') return daftarMusik.fiksi;
            return daftarMusik.dashboard;
        }

        // 3. Simpan waktu saat pindah halaman
        window.onbeforeunload = function() {
            sessionStorage.setItem("laguWaktu", audioSistem.currentTime);
        };

        // 4. Fungsi Sinkronisasi Tampilan
        function syncTampilan() {
            let toggle = document.getElementById("globalMusicToggle");
            let slider = document.getElementById("sliderMusik");
            let statusTxt = document.getElementById("statusMusikGlobal");
            if (toggle && slider && statusTxt) {
                let status = localStorage.getItem("statusMusik") === "ON";
                toggle.checked = status;
                slider.style.backgroundColor = status ? "#2ec4b6" : "#ccc";
                statusTxt.innerHTML = status ? "Musik Menyala! 🎵" : "Musik Mati 🔇";
            }
        }

        
        // 6. FUNGSI LOAD GABUNGAN (Semua otomatis jalan di sini)
        window.onload = function() {
            // --- BAGIAN MUSIK ---
            let laguTujuan = tentukanLagu();
            if (audioSistem.src.indexOf(laguTujuan) === -1) {
                audioSistem.src = laguTujuan;
                audioSistem.load();
            }
            let waktuTerakhir = sessionStorage.getItem("laguWaktu");
            if (waktuTerakhir) audioSistem.currentTime = parseFloat(waktuTerakhir);
            audioSistem.volume = parseFloat(localStorage.getItem("volumeMusik") || "0.5");
            if (localStorage.getItem("statusMusik") === "ON") audioSistem.play().catch(() => {});
            syncTampilan();

        };

        // 7. Tombol ON / OFF
        function switchMusikGlobal() {
            let checkbox = document.getElementById("globalMusicToggle");
            if (!checkbox) return;
            if (checkbox.checked) {
                localStorage.setItem("statusMusik", "ON");
                audioSistem.play().catch(() => {});
            } else {
                localStorage.setItem("statusMusik", "OFF");
                audioSistem.pause();
            }
            syncTampilan();
        }

        // 8. Kontrol Volume
        function ubahVolumeGlobal(val) {
            audioSistem.volume = parseFloat(val);
            localStorage.setItem("volumeMusik", val);
        }
    </script>
<script>
    // Pastikan nama filenya sama persis: klik.WAV (huruf besar/kecil berpengaruh di kodingan!)
    const klikAudio = new Audio('klik.WAV');

    document.addEventListener('click', function(e) {
        // Mendeteksi klik pada tombol atau link
        if (e.target.tagName === 'BUTTON' || e.target.closest('a')) {
            klikAudio.currentTime = 0; // Biar bisa bunyi beruntun dengan cepat
            klikAudio.play().catch(e => console.log("Menunggu interaksi pengguna..."));
        }
    });
</script>

</body>

</html>