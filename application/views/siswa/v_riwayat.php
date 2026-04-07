<div class="content">
    <h2>Riwayat Peminjaman Saya</h2>
    <hr>

    <form action="<?= base_url('siswa/riwayat') ?>" method="get" style="margin-bottom: 20px;">
        <label>Filter Status: </label>
        <select name="filter" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="menunggu" <?= ($this->input->get('filter') == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
            <option value="disetujui" <?= ($this->input->get('filter') == 'disetujui') ? 'selected' : '' ?>>Sedang Dipinjam
                (Disetujui)</option>
            <option value="pending_kembali" <?= ($this->input->get('filter') == 'pending_kembali') ? 'selected' : '' ?>>
                Menunggu Approve Kembali</option>
            <option value="ditolak" <?= ($this->input->get('filter') == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
            <option value="kembali" <?= ($this->input->get('filter') == 'kembali') ? 'selected' : '' ?>>Sudah Dikembalikan
            </option>
        </select>
        <a href="<?= base_url('siswa/riwayat') ?>">Reset</a>
    </form>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($riwayat as $r): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $r->judul; ?></td>
                    <td><?= $r->tanggal_pinjam; ?></td>
                    <td><?= ($r->tanggal_kembali) ? $r->tanggal_kembali : '-'; ?></td>
                    <td>
                        <?php
                        if ($r->status == 'menunggu')
                            echo "Peminjaman Diajukan";
                        elseif ($r->status == 'disetujui')
                            echo "Sedang Dipinjam";
                        elseif ($r->status == 'pending_kembali')
                            echo "Pengembalian Diajukan"; 
                        elseif ($r->status == 'kembali')
                            echo "Sudah Dikembalikan";
                        else
                            echo strtoupper($r->status);
                        ?>
                    </td>
                    <td>
                        <?php if ($r->status == 'menunggu'): ?>
                            <a href="<?= base_url('siswa/batal_pinjam/' . $r->id_peminjaman); ?>" style="color: red;">Batalkan</a>
                        <?php elseif ($r->status == 'disetujui'): ?>
                            <a href="<?= base_url('siswa/ajukan_kembali/' . $r->id_peminjaman); ?>"
                                style="color: blue;">Kembalikan Buku</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>