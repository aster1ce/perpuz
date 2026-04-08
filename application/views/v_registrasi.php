<!DOCTYPE html>
<html>

<head>
    <title>Registrasi Siswa - Booksy</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
            margin: 0;
        }

        .reg-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #555;
        }

        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .link a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="reg-box">
        <h2>Daftar Akun Siswa</h2>
        <form action="<?= base_url('auth/registrasi_aksi') ?>" method="POST">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
            <input type="text" name="username" placeholder="Username Baru" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar Sekarang</button>
        </form>
        <div class="link">
            Sudah punya akun? <a href="<?= base_url('auth/login') ?>">Login di sini</a>
        </div>
    </div>

</body>

</html>