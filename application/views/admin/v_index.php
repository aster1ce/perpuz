<h1>Dashboard Admin - Kelola Buku</h1>
<p>Selamat Datang, <?= $this->session->userdata('nama'); ?>! <a href="<?= base_url('auth/logout'); ?>">Logout</a></p>

<hr>
<h3>Tambah Buku</h3>
<form action="<?= base_url('admin/tambah_aksi'); ?>" method="post">
    <input type="text" name="judul" placeholder="Judul Buku" required>
    <input type="text" name="penulis" placeholder="Penulis" required>
    <input type="number" name="stok" placeholder="Stok" required>
    <button type="submit">Simpan</button>
</form>

<hr>
<table border="1">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1;
    foreach ($buku as $b): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $b->judul; ?></td>
            <td><?= $b->penulis; ?></td>
            <td><?= $b->stok; ?></td>
            <td>
                <a href="<?= base_url('admin/hapus/' . $b->id_buku); ?>">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>