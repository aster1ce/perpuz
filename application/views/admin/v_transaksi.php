<div class="content">
    <h2>Kelola Transaksi Peminjaman</h2>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <tr style="background: #eee;">
            <th>Nama Siswa</th>
            <th>Judul Buku</th>
            <th>Status Peminjaman</th> <th>Aksi</th>
        </tr>
        <?php foreach ($transaksi as $t): ?>
            <tr>
                <td><?= $t->nama_lengkap; ?></td>
                <td><?= $t->judul; ?></td>
                <td>
                    <strong>
                    <?php 
                        if($t->status == 'menunggu') {
                            echo "<span style='color: orange;'>Pengajuan Peminjaman</span>";
                        } elseif($t->status == 'disetujui') {
                            echo "<span style='color: blue;'>Sedang Dipinjam</span>";
                        } elseif($t->status == 'pending_kembali') {
                            echo "<span style='color: purple;'>Pengajuan Pengembalian</span>";
                        } elseif($t->status == 'kembali') {
                            echo "<span style='color: green;'>Sudah Dikembalikan</span>";
                        } elseif($t->status == 'ditolak') {
                            echo "<span style='color: red;'>DITOLAK</span>";
                        } else {
                            echo strtoupper($t->status);
                        }
                    ?>
                    </strong>
                </td>
                <td>
                    <?php if ($t->status == 'menunggu'): ?>
                        <a href="<?= base_url('admin/setuju_pinjam/' . $t->id_peminjaman . '/' . $t->id_buku); ?>" 
                           style="color: blue; font-weight: bold;">Setujui Pinjam</a>
                    <?php elseif ($t->status == 'pending_kembali'): ?>
                        <a href="<?= base_url('admin/konfirmasi_kembali/' . $t->id_peminjaman . '/' . $t->id_buku); ?>"
                           style="color: green; font-weight: bold;">Konfirmasi Kembali</a>
                    <?php else: ?>
                        <span style="color: #999;">Tidak ada aksi</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</div>