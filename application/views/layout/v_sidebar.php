<div
    style="width: 200px; float: left; background: #f4f4f4; height: 100vh; padding: 15px; border-right: 1px solid #ccc;">
    <h3>Booksy</h3>
    <hr>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
        <ul>
            <li><a href="<?= base_url('admin') ?>">Dashboard Admin</a></li>
            <li><a href="<?= base_url('admin/kelola_buku') ?>">Kelola Buku</a></li>
            <li><a href="<?= base_url('admin/kelola_user') ?>">Kelola Anggota</a></li>
            <li><a href="<?= base_url('admin/transaksi') ?>">Kelola Transaksi</a></li>
        </ul>
    <?php else: ?>
        <ul>
            <li><a href="<?= base_url('siswa') ?>">Dashboard Siswa</a></li>
            <li><a href="<?= base_url('siswa/buku') ?>">Pinjam Buku</a></li>
            <li><a href="<?= base_url('siswa/riwayat') ?>">Riwayat Saya</a></li>
        </ul>
    <?php endif; ?>

    <hr>
    <a href="<?= base_url('auth/logout') ?>" style="color: red;">Logout</a>
</div>
<div style="margin-left: 230px; padding: 20px;">