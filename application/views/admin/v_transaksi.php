<div class="content">
    <h2>Kelola Transaksi Peminjaman</h2>
    <hr>

    <div style="margin-bottom: 20px;">
        <form action="<?= base_url('admin/transaksi') ?>" method="GET">
            <label for="status" style="font-weight: bold;">Filter Status: </label>
            <select name="status" id="status" onchange="this.form.submit()"
                style="padding: 5px; border-radius: 4px; border: 1px solid #ccc; cursor: pointer;">
                <option value="">-- Semua Status --</option>
                <option value="disetujui" <?= ($status_aktif == 'disetujui') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                <option value="pending_kembali" <?= ($status_aktif == 'pending_kembali') ? 'selected' : '' ?>>Menunggu
                    Konfirmasi Balik</option>
                <option value="kembali" <?= ($status_aktif == 'kembali') ? 'selected' : '' ?>>Selesai (Lunas)</option>
                <option value="menunggu" <?= ($status_aktif == 'menunggu') ? 'selected' : '' ?>>Pengajuan Pinjam</option>
                <option value="ditolak" <?= ($status_aktif == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
            </select>
            <a href="<?= base_url('admin/transaksi') ?>"
                style="margin-left: 10px; font-size: 12px; color: #666; text-decoration: none;">Reset Filter</a>
        </form>
    </div>

    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    </table>
</div>

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
                    <?php if ($t->status == 'kembali'): ?>
                        <span style="color:green; font-weight:bold;">Rp <?= number_format($t->denda, 0, ',', '.') ?>
                            (Lunas)</span>
                    <?php elseif ($t->denda > 0): ?>
                        <strong style="color:red;">Rp <?= number_format($t->denda, 0, ',', '.') ?></strong>
                    <?php else: ?>
                        <span style="color:gray;">0</span>
                    <?php endif; ?>
                </td>

                <td>
                    <strong>
                        <?php
                        if ($t->status == 'menunggu')
                            echo "<span style='color: orange;'>Pengajuan Pinjam</span>";
                        elseif ($t->status == 'disetujui')
                            echo "<span style='color: blue;'>Sedang Dipinjam</span>";
                        elseif ($t->status == 'pending_kembali')
                            echo "<span style='color: purple;'>Menunggu Konfirmasi Balik</span>";
                        elseif ($t->status == 'kembali')
                            echo "<span style='color: green;'>Selesai</span>";
                        elseif ($t->status == 'ditolak')
                            echo "<span style='color: red;'>Ditolak</span>";
                        ?>
                    </strong>
                </td>
                <td>
                    <?php if ($t->status == 'menunggu'): ?>
                        <a href="<?= base_url('admin/setuju_pinjam/' . $t->id_peminjaman . '/' . $t->id_buku); ?>"
                            style="color: blue; font-weight: bold; text-decoration: none;">[Setujui]</a> |
                        <a href="<?= base_url('admin/tolak_pinjam/' . $t->id_peminjaman); ?>"
                            style="color: red; text-decoration: none;" onclick="return confirm('Tolak?')">[Tolak]</a>

                    <?php elseif ($t->status == 'pending_kembali'): ?>
                        <button type="button" class="btn-konfirmasi" data-id="<?= $t->id_peminjaman ?>"
                            data-buku="<?= $t->id_buku ?>" data-denda="<?= $t->denda ?>"
                            style="background: green; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;">
                            Konfirmasi Kembali
                        </button>

                    <?php else: ?>
                        <span style="color: #999;">Selesai</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<div id="modalDenda"
    style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; width:300px; margin:15% auto; padding:20px; border-radius:5px;">
        <h3 style="margin-top:0;">Terima Pembayaran</h3>
        <form action="<?= base_url('admin/konfirmasi_kembali_aksi') ?>" method="POST">
            <input type="hidden" name="id_peminjaman" id="mdl_id_peminjaman">
            <input type="hidden" name="id_buku" id="mdl_id_buku">

            <label>Jumlah Denda yang Dibayar (Rp):</label>
            <input type="number" name="denda_dibayar" id="mdl_denda" min="0"
                style="width:100%; margin:10px 0; padding:8px; border:1px solid #ccc; border-radius:4px;" required>

            <p style="font-size:11px; color:gray; line-height:1.4;">*Admin menginput nominal uang yang diterima dari
                peminjam agar status denda tercatat <b>Lunas</b>.</p>

            <button type="submit"
                style="background:green; color:white; border:none; padding:10px; width:100%; cursor:pointer; border-radius:4px; font-weight:bold;">Konfirmasi
                Lunas & Selesai</button>
            <button type="button" onclick="document.getElementById('modalDenda').style.display='none'"
                style="margin-top:8px; width:100%; border:none; background:#eee; padding:8px; cursor:pointer; border-radius:4px;">Batal</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.btn-konfirmasi').on('click', function () {
            const id = $(this).data('id');
            const buku = $(this).data('buku');
            const denda = $(this).data('denda');

            $('#mdl_id_peminjaman').val(id);
            $('#mdl_id_buku').val(buku);
            $('#mdl_denda').val(denda);
            $('#modalDenda').show();
        });
    });
</script>