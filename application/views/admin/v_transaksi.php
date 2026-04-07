<div class="content">
    <h2>Kelola Transaksi Peminjaman</h2>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <tr style="background: #eee;">
            <th>Nama Siswa</th>
            <th>Judul Buku</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($transaksi as $t): ?>
            <tr>
                <td><?= $t->nama_lengkap; ?></td>
                <td><?= $t->judul; ?></td>
                <td><strong><?= strtoupper($t->status); ?></strong></td>
                <td>
                    <?php if ($t->status == 'menunggu'): ?>
                        <a href="<?= base_url('admin/setuju_pinjam/' . $t->id_peminjaman . '/' . $t->id_buku); ?>"
                            style="color: green;">Approve</a> |
                        <a href="<?= base_url('admin/tolak_pinjam/' . $t->id_peminjaman); ?>" style="color: red;">Reject</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</div>