<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Booksy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #0f0f0f; /* Konsisten dengan Login */
            background-image: 
                radial-gradient(circle at 20% 30%, #1a1a1a 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, #222 0%, transparent 50%);
        }

        .reg-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .reg-box {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .brand-logo {
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .brand-logo h1 {
            margin: 0;
            font-size: 26px;
            letter-spacing: -1px;
            font-weight: 800;
        }

        .reg-box h2 {
            color: #fff;
            margin-bottom: 8px;
            font-size: 20px;
            font-weight: 700;
        }

        .reg-box p {
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 18px;
            text-align: left;
            position: relative;
        }

        /* Icon styling inside input */
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            display: flex;
            align-items: center;
        }

        input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            outline: none;
            transition: 0.3s;
            font-size: 15px;
        }

        input:focus {
            border-color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        button {
            width: 100%;
            padding: 14px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1);
        }

        .footer-text {
            margin-top: 25px;
            color: #555;
            font-size: 13px;
        }

        .footer-text a {
            color: #fff; /* White link for dark theme */
            text-decoration: none;
            font-weight: 700;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="reg-container">
        <div class="reg-box">
            <div class="brand-logo">
                <i data-lucide="book-open" style="width: 28px; height: 28px;"></i>
                <h1>Booksy</h1>
            </div>

            <h2>Daftar Akun</h2>
            <p>Ayo gabung jadi anggota perpustakaan!</p>

            <form action="<?= base_url('auth/registrasi_aksi') ?>" method="POST">
                <div class="input-group">
                    <div class="input-icon">
                        <i data-lucide="user" style="width: 18px; height: 18px;"></i>
                    </div>
                    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required autocomplete="off">
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <i data-lucide="at-sign" style="width: 18px; height: 18px;"></i>
                    </div>
                    <input type="text" name="username" placeholder="Username Baru" required autocomplete="off">
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <i data-lucide="lock" style="width: 18px; height: 18px;"></i>
                    </div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit">Daftar Sekarang</button>
            </form>

            <div class="footer-text">
                Sudah punya akun? <a href="<?= base_url('auth/login') ?>">Login di sini</a>
            </div>
        </div>
    </div>

    <script>
        // Init Lucide Icons
        lucide.createIcons();
    </script>
</body>

</html>