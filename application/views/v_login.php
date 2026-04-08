<form action="<?= base_url('auth/login_aksi'); ?>" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<p style="font-size: 12px; margin-top: 10px;">
    Belum punya akun? <a href="<?= base_url('auth/registrasi') ?>">Daftar di sini</a>
</p>