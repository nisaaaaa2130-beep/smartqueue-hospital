<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - Perpustakaan Digital Anak</title>
    <style>
        /* Menggunakan background yang sama dengan dashboard */
        body { 
            background-color: #2b2b2b; /* Warna gelap dasar */
            background-image: url('https://www.transparenttextures.com/patterns/stardust.png'); /* Pattern bintang */
            font-family: 'Comic Sans MS', cursive, sans-serif; 
            display: flex; justify-content: center; align-items: center; 
            height: 100vh; margin: 0; 
        }
        .login-card { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 40px; 
            border-radius: 30px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.3); 
            width: 350px; 
            text-align: center;
            border: 5px solid #8d6e63; /* Frame cokelat */
        }
        h2 { color: #2e7d32; margin-bottom: 5px; }
        p { color: #5d4037; margin-bottom: 20px; }
        input { 
            width: 100%; padding: 15px; margin: 10px 0; 
            border: 2px solid #8d6e63; border-radius: 15px; 
            box-sizing: border-box; font-size: 16px;
        }
        button { 
            background: #2e7d32; color: white; border: none; 
            padding: 15px; width: 100%; border-radius: 15px; 
            cursor: pointer; font-weight: bold; font-size: 18px;
            transition: transform 0.2s;
        }
        button:hover { background: #1b5e20; transform: scale(1.02); }
        .icon { font-size: 50px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="icon">📚</div>
        <h2>Selamat Datang!</h2>
        <p>Ayo baca buku hari ini 🐱</p>
        <form action="proses_login.php" method="POST">
            <input type="text" name="username" placeholder="Nama Pengguna" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk Yuk!</button>
        </form>
    </div>
    <script>
    const loginAudio = new Audio('loginsound.WAV');

    document.addEventListener('click', function(e) {
        if (e.target.tagName === 'BUTTON') {
            loginAudio.currentTime = 0;
            loginAudio.play();
        }
    });
</script>
</body>
</html>