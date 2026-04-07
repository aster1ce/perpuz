<div class="content">
    <h2>Kelola Transaksi Peminjaman</h2>
    <hr>
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background: #eee;">
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Deadline</th>
                <th>Denda</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($transaksi as $t): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $t->nama_lengkap; ?></td>
                    <td><?= $t->judul; ?></td>
                    <td><?= date('d/m/Y', strtotime($t->tanggal_pinjam)); ?></td>
                    <td><?= date('d/m/Y', strtotime($t->tanggal_deadline)); ?></td>
                    <td>
                        <?php if ($t->denda > 0): ?>
                            <span style="color: red; font-weight: bold;">Rp <?= number_format($t->denda, 0, ',', '.'); ?></span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong>
                            <?php
                            if ($t->status == 'menunggu') {
                                echo "<span style='color: orange;'>Pengajuan Pinjam</span>";
                            } elseif ($t->status == 'disetujui') {
                                echo "<span style='color: blue;'>Sedang Dipinjam</span>";
                            } elseif ($t->status == 'pending_kembali') {
                                echo "<span style='color: purple;'>Menunggu Konfirmasi Balik</span>";
                            } elseif ($t->status == 'kembali') {
                                echo "<span style='color: green;'>Selesai</span>";
                            } elseif ($t->status == 'ditolak') {
                                echo "<span style='color: red;'>Ditolak</span>";
                            }
                            ?>
                        </strong>
                    </td>
                    <td>
                        <?php if ($t->status == 'menunggu'): ?>
                            <a href="<?= base_url('admin/setuju_pinjam/' . $t->id_peminjaman . '/' . $t->id_buku); ?>"
                                style="color: blue; font-weight: bold; text-decoration: none;">[Setujui]</a> |
                            <a href="<?= base_url('admin/tolak_pinjam/' . $t->id_peminjaman); ?>"
                                style="color: red; text-decoration: none;"
                                onclick="return confirm('Tolak pinjaman ini?')">[Tolak]</a>

                        <?php elseif ($t->status == 'pending_kembali'): ?>
                            <a href="<?= base_url('admin/konfirmasi_kembali/' . $t->id_peminjaman . '/' . $t->id_buku); ?>"
                                style="background: green; color: white; padding: 3px 8px; border-radius: 3px; text-decoration: none;"
                                onclick="return confirm('Buku sudah diterima & denda sudah dicek?')">Konfirmasi Kembali</a>

                        <?php else: ?>
                            <span style="color: #999;">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>