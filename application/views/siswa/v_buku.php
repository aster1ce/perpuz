<div class="content">
    <h2>Katalog Buku Perpustakaan</h2>
    <hr>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($buku as $b): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $b->judul; ?></td>
                    <td><?= $b->penulis; ?></td>
                    <td><?= $b->stok; ?></td>
                    <td>
                        <?php if ($b->stok > 0): ?>
                            <a href="<?= base_url('siswa/pinjam_aksi/' . $b->id_buku); ?>"
                                onclick="return confirm('Pinjam buku ini?')"
                                style="background: green; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;">
                                Pinjam
                            </a>
                        <?php else: ?>
                            <span style="color: red;">Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div> 