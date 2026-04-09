<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="content">
    <div class="page-header">
        <div class="header-text">
            <h2>Kelola Transaksi Peminjaman</h2>
            <p>Monitor dan konfirmasi aktivitas sirkulasi buku Perpustakaan Booksy.</p>
        </div>
        
        <div class="filter-wrapper">
            <form action="<?= base_url('admin/transaksi') ?>" method="GET" class="filter-form">
                <div class="input-group-custom">
                    <span class="material-icons">filter_list</span>
                    <select name="status" id="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="disetujui" <?= ($status_aktif == 'disetujui') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                        <option value="pending_kembali" <?= ($status_aktif == 'pending_kembali') ? 'selected' : '' ?>>Menunggu Konfirmasi Balik</option>
                        <option value="kembali" <?= ($status_aktif == 'kembali') ? 'selected' : '' ?>>Selesai (Lunas)</option>
                        <option value="menunggu" <?= ($status_aktif == 'menunggu') ? 'selected' : '' ?>>Pengajuan Pinjam</option>
                        <option value="ditolak" <?= ($status_aktif == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
                <?php if($status_aktif): ?>
                    <a href="<?= base_url('admin/transaksi') ?>" class="btn-reset">Reset Filter</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Informasi Siswa</th>
                    <th>Judul Buku</th>
                    <th>Waktu Pinjam</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($transaksi as $t): ?>
                    <tr>
                        <td style="text-align: center; color: #888;"><?= $no++; ?></td>
                        <td>
                            <div class="user-info">
                                <strong style="display: block; color: #333;"><?= $t->nama_lengkap; ?></strong>
                                <small style="color: #aaa; font-size: 11px;">ID: #<?= $t->id_user; ?></small>
                            </div>
                        </td>
                        <td style="font-weight: 600; color: #1a1a1a;"><?= $t->judul; ?></td>
                        <td>
                            <div class="date-info" style="font-size: 13px;">
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <i class="material-icons" style="font-size: 16px; color: #888;">event</i> 
                                    <?= date('d M Y', strtotime($t->tanggal_pinjam)); ?>
                                </span>
                                <small style="color: #ff4d4d; font-weight: bold; display: block; margin-top: 4px;">
                                    Deadline: <?= date('d M Y', strtotime($t->tanggal_deadline)); ?>
                                </small>
                            </div>
                        </td>
                        <td>
                            <?php if ($t->status == 'kembali'): ?>
                                <span style="color: #2e7d32; font-weight: bold; font-size: 13px;">
                                    Rp <?= number_format($t->denda, 0, ',', '.') ?> (Lunas)
                                </span>
                            <?php elseif ($t->denda > 0): ?>
                                <span style="color: #d32f2f; font-weight: bold; font-size: 13px;">
                                    Rp <?= number_format($t->denda, 0, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                <span style="color: #9e9e9e; font-size: 13px;">Rp 0</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $status_map = [
                                'menunggu' => ['label' => 'Pengajuan', 'class' => 'st-waiting'],
                                'disetujui' => ['label' => 'Dipinjam', 'class' => 'st-active'],
                                'pending_kembali' => ['label' => 'Perlu Konfirmasi', 'class' => 'st-pending'],
                                'kembali' => ['label' => 'Selesai', 'class' => 'st-success'],
                                'ditolak' => ['label' => 'Ditolak', 'class' => 'st-danger'],
                            ];
                            $st = $status_map[$t->status] ?? ['label' => 'Unknown', 'class' => ''];
                            ?>
                            <span class="badge <?= $st['class'] ?>"><?= $st['label'] ?></span>
                        </td>
                        <td style="text-align: center;">
                            <div class="action-buttons" style="display: flex; gap: 8px; justify-content: center;">
                                <?php if ($t->status == 'menunggu'): ?>
                                    <a href="<?= base_url('admin/setuju_pinjam/' . $t->id_peminjaman . '/' . $t->id_buku); ?>" 
                                       style="color: #2e7d32;" title="Setujui"><span class="material-icons">check_circle</span></a>
                                    <a href="<?= base_url('admin/tolak_pinjam/' . $t->id_peminjaman); ?>" 
                                       style="color: #d32f2f;" onclick="return confirm('Tolak pengajuan ini?')" title="Tolak"><span class="material-icons">cancel</span></a>
                                <?php elseif ($t->status == 'pending_kembali'): ?>
                                    <button type="button" class="btn-konfirmasi-new" 
                                            data-id="<?= $t->id_peminjaman ?>" 
                                            data-buku="<?= $t->id_buku ?>" 
                                            data-denda="<?= $t->denda ?>">
                                        Konfirmasi Kembali
                                    </button>
                                <?php else: ?>
                                    <span style="color: #bbb; font-size: 12px; font-weight: 600;">SELESAI</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modalDenda" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 18px;">Penyelesaian Transaksi</h3>
            <span class="close-modal" onclick="closeModal()">&times;</span>
        </div>
        <form action="<?= base_url('admin/konfirmasi_kembali_aksi') ?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="id_peminjaman" id="mdl_id_peminjaman">
                <input type="hidden" name="id_buku" id="mdl_id_buku">

                <div class="form-group">
                    <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Total Denda yang Diterima (Rp)</label>
                    <div class="input-with-icon">
                        <span class="currency-label">Rp</span>
                        <input type="number" name="denda_dibayar" id="mdl_denda" min="0" required>
                    </div>
                    <p style="font-size: 11px; color: #888; margin-top: 10px; line-height: 1.4;">
                        *Masukkan nominal denda yang dibayar siswa agar status otomatis berubah menjadi <b>Lunas</b>.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit">Selesaikan & Lunas</button>
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
/* HEADER & FILTER */
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; }
.header-text h2 { margin: 0; font-size: 24px; font-weight: 800; color: #1a1a1a; }
.header-text p { margin: 5px 0 0; color: #888; font-size: 14px; }

.input-group-custom { background: #fff; border: 1px solid #ddd; padding: 8px 15px; border-radius: 12px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
.input-group-custom select { border: none; outline: none; font-weight: 600; color: #444; cursor: pointer; background: transparent; }
.btn-reset { font-size: 11px; color: #ff4d4d; text-decoration: none; display: block; text-align: right; margin-top: 5px; font-weight: bold; }

/* TABLE CARD */
.table-card { background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
.modern-table { width: 100%; border-collapse: collapse; }
.modern-table th { background: #fcfcfc; padding: 15px 20px; text-align: left; font-size: 12px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #eee; }
.modern-table td { padding: 18px 20px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }

/* BADGES */
.badge { padding: 6px 12px; border-radius: 50px; font-size: 10px; font-weight: 800; text-transform: uppercase; display: inline-block; }
.st-waiting { background: #fff8e1; color: #f57f17; }
.st-active { background: #e3f2fd; color: #1976d2; }
.st-pending { background: #f3e5f5; color: #7b1fa2; }
.st-success { background: #e8f5e9; color: #2e7d32; }
.st-danger { background: #ffebee; color: #c62828; }

/* BUTTONS */
.btn-konfirmasi-new { background: #1a1a1a; color: white; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-size: 11px; font-weight: 700; transition: 0.2s; }
.btn-konfirmasi-new:hover { background: #333; transform: translateY(-1px); }

/* MODAL OVERLAY */
.modal-overlay { display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.6); backdrop-filter: blur(4px); }
.modal-content { background:#fff; width:360px; margin:10% auto; border-radius:24px; overflow:hidden; animation: slideIn 0.3s ease-out; }
.modal-header { padding: 20px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
.close-modal { font-size: 28px; color: #aaa; cursor: pointer; line-height: 1; }
.modal-body { padding: 25px; }
.input-with-icon { display: flex; align-items: center; background: #f5f5f5; border-radius: 12px; padding: 5px 15px; }
.currency-label { font-weight: bold; color: #888; font-size: 16px; }
.input-with-icon input { background: transparent; border: none; padding: 12px; width: 100%; outline: none; font-size: 18px; font-weight: 800; color: #333; }
.modal-footer { padding: 0 25px 25px; }
.btn-submit { background: #2e7d32; color: white; border: none; padding: 14px; width: 100%; border-radius: 12px; font-weight: 800; cursor: pointer; margin-bottom: 10px; }
.btn-cancel { background: transparent; border: none; width: 100%; color: #888; font-weight: 600; cursor: pointer; }

@keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<script>
$(document).ready(function () {
    // Gunakan event delegation supaya aman jika ada perubahan DOM
    $(document).on('click', '.btn-konfirmasi-new', function () {
        const id = $(this).data('id');
        const buku = $(this).data('buku');
        const denda = $(this).data('denda');

        $('#mdl_id_peminjaman').val(id);
        $('#mdl_id_buku').val(buku);
        $('#mdl_denda').val(denda);
        
        // Munculkan modal dengan efek fade
        $('#modalDenda').css('display', 'block').hide().fadeIn(200);
    });

    // Tutup modal jika klik area luar
    $(window).on('click', function(event) {
        if ($(event.target).is('#modalDenda')) {
            closeModal();
        }
    });
});

function closeModal() {
    $('#modalDenda').fadeOut(200, function() {
        $(this).css('display', 'none');
    });
}
</script>