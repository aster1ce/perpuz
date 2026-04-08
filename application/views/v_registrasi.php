<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Siswa - Booksy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            /* Soft white/grey background */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .reg-container {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .reg-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .reg-header h2 {
            font-weight: 600;
            color: #1e293b;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        /* Styling Input Group agar terlihat Seamless */
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #94a3b8;
            padding-left: 1.25rem;
            border-color: #dee2e6;
        }

        .form-control {
            border-left: none;
            padding: 0.75rem 1.25rem 0.75rem 0;
            font-size: 0.95rem;
            color: #1e293b;
            border-color: #dee2e6;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        /* Warna Aksen Blue saat Input Aktif */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn-register {
            background-color: #3b82f6;
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .footer-text {
            color: #64748b;
            font-size: 0.875rem;
        }

        .footer-text a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="reg-container">
        <div class="reg-header">
            <h2>Daftar Akun</h2>
            <p class="text-muted small">Bergabunglah dengan komunitas Booksy</p>
        </div>

        <form action="<?= base_url('auth/registrasi_aksi') ?>" method="POST">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i data-lucide="user-plus" style="width: 18px; height: 18px;"></i>
                    </span>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i data-lucide="at-sign" style="width: 18px; height: 18px;"></i>
                    </span>
                    <input type="text" name="username" class="form-control" placeholder="Username Baru" required>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i data-lucide="lock" style="width: 18px; height: 18px;"></i>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-register">Daftar Sekarang</button>
        </form>

        <p class="footer-text text-center mt-4">
            Sudah punya akun? <a href="<?= base_url('auth/login') ?>">Login di sini</a>
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>