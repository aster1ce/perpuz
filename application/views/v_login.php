<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Booksy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Material+Icons" rel="stylesheet">
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
            background: #0f0f0f;
            /* Dark background */
            background-image:
                radial-gradient(circle at 20% 30%, #1a1a1a 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, #222 0%, transparent 50%);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-box {
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
            margin-bottom: 30px;
        }

        .brand-logo h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: -1px;
        }

        .login-box h2 {
            color: #fff;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .login-box p {
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        .input-group span {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-size: 20px;
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
            color: #888;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <div class="brand-logo">
                <span class="material-icons" style="font-size: 32px;">auto_stories</span>
                <h1>Booksy</h1>
            </div>

            <h2>Welcome Back!</h2>
            <p>Silahkan masuk ke akunmu.</p>

            <form action="<?= base_url('auth/login_aksi'); ?>" method="post">
                <div class="input-group">
                    <span class="material-icons">person</span>
                    <input type="text" name="username" placeholder="Username" required autocomplete="off">
                </div>

                <div class="input-group">
                    <span class="material-icons">lock</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit">Login</button>
            </form>

            <div class="footer-text">
                Belum punya akun? <a href="<?= base_url('auth/registrasi') ?>"
                    style="color: #2563eb; font-weight: 700; text-decoration: none;">Daftar Sekarang</a>
            </div>
        </div>
    </div>

</body>

</html>