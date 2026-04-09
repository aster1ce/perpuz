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
                        <td class="text-center"><?= $no++; ?></td>
                        <td>
                            <div class="user-info">
                                <strong><?= $t->nama_lengkap; ?></strong>
                                <small>ID: #<?= $t->id_user; ?></small>
                            </div>
                        </td>
                        <td class="book-title"><?= $t->judul; ?></td>
                        <td>
                            <div class="date-info">
                                <span><i class="material-icons">event</i> <?= date('d M Y', strtotime($t->tanggal_pinjam)); ?></span>
                                <small class="deadline">Deadline: <?= date('d M Y', strtotime($t->tanggal_deadline)); ?></small>
                            </div>
                        </td>
                        <td>
                            <?php if ($t->status == 'kembali'): ?>
                                <span class="denda-tag lunas">Rp <?= number_format($t->denda, 0, ',', '.') ?> (Lunas)</span>
                            <?php elseif ($t->denda > 0): ?>
                                <span class="denda-tag telat">Rp <?= number_format($t->denda, 0, ',', '.') ?></span>
                            <?php else: ?>
                                <span class="denda-tag">Rp 0</span>
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
                            $st = $status_map[$t->status];
                            ?>
                            <span class="badge <?= $st['class'] ?>"><?= $st['label'] ?></span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <?php if ($t->status == 'menunggu'): ?>
                                    <a href="<?= base_url('admin/setuju_pinjam/' . $t->id_peminjaman . '/' . $t->id_buku); ?>" class="btn-action approve" title="Setujui"><span class="material-icons">check_circle</span></a>
                                    <a href="<?= base_url('admin/tolak_pinjam/' . $t->id_peminjaman); ?>" class="btn-action reject" onclick="return confirm('Tolak pengajuan ini?')" title="Tolak"><span class="material-icons">cancel</span></a>
                                <?php elseif ($t->status == 'pending_kembali'): ?>
                                    <button type="button" class="btn-konfirmasi-new" 
                                            data-id="<?= $t->id_peminjaman ?>" 
                                            data-buku="<?= $t->id_buku ?>" 
                                            data-denda="<?= $t->denda ?>">
                                        Konfirmasi Kembali
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">No Action</span>
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
            <h3>Penyelesaian Transaksi</h3>
            <button type="button" class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <form action="<?= base_url('admin/konfirmasi_kembali_aksi') ?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="id_peminjaman" id="mdl_id_peminjaman">
                <input type="hidden" name="id_buku" id="mdl_id_buku">

                <div class="form-group">
                    <label>Total Denda yang Diterima (Rp)</label>
                    <div class="input-with-icon">
                        <span class="currency-label">Rp</span>
                        <input type="number" name="denda_dibayar" id="mdl_denda" min="0" required>
                    </div>
                    <p class="helper-text">*Pastikan nominal sesuai dengan uang yang diterima admin.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-submit">Selesaikan & Lunas</button>
            </div>
        </form>
    </div>
</div>

<style>
/* CSS UNTUK TRANSAKSI PRO */
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; }
.header-text h2 { margin: 0; font-size: 24px; font-weight: 800; color: #1a1a1a; }
.header-text p { margin: 5px 0 0; color: #888; font-size: 14px; }

/* FILTER STYLING */
.input-group-custom { background: #fff; border: 1px solid #ddd; padding: 8px 15px; border-radius: 12px; display: flex; align-items: center; gap: 10px; }
.input-group-custom select { border: none; outline: none; font-weight: 600; cursor: pointer; background: transparent; }
.btn-reset { font-size: 12px; color: #ff4d4d; text-decoration: none; margin-top: 5px; display: block; text-align: right; }

/* TABLE CARD */
.table-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
.modern-table { width: 100%; border-collapse: collapse; }
.modern-table th { background: #fcfcfc; padding: 18px 20px; text-align: left; font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #eee; }
.modern-table td { padding: 20px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }

/* CELL STYLING */
.user-info strong { display: block; font-size: 15px; color: #333; }
.user-info small { color: #aaa; font-size: 11px; }
.book-title { font-weight: 600; color: #1a1a1a; }
.date-info span { display: flex; align-items: center; gap: 5px; font-size: 14px; color: #444; }
.date-info .material-icons { font-size: 16px; color: #888; }
.deadline { color: #ff4d4d; font-size: 11px; font-weight: bold; }

/* BADGE & TAGS */
.badge { padding: 6px 14px; border-radius: 50px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
.st-waiting { background: #fff8e1; color: #f57f17; }
.st-active { background: #e3f2fd; color: #1976d2; }
.st-pending { background: #f3e5f5; color: #7b1fa2; }
.st-success { background: #e8f5e9; color: #2e7d32; }
.st-danger { background: #ffebee; color: #c62828; }

.denda-tag { font-size: 13px; font-weight: 600; color: #444; }
.denda-tag.telat { color: #ff4d4d; }
.denda-tag.lunas { color: #28a745; }

/* BUTTONS */
.action-buttons { display: flex; gap: 10px; justify-content: center; }
.btn-action { text-decoration: none; transition: 0.2s; }
.approve { color: #28a745; }
.reject { color: #ff4d4d; }
.btn-konfirmasi-new { background: #1a1a1a; color: white; border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer; font-size: 12px; font-weight: 700; transition: 0.3s; }
.btn-konfirmasi-new:hover { background: #333; transform: translateY(-2px); }

/* MODAL STYLING */
.modal-overlay { display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.6); backdrop-filter: blur(5px); }
.modal-content { background:#fff; width:380px; margin:10% auto; border-radius:24px; overflow:hidden; animation: slideIn 0.3s ease-out; }
.modal-header { padding: 20px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
.modal-body { padding: 25px; }
.input-with-icon { display: flex; align-items: center; background: #f5f5f5; border-radius: 12px; padding: 5px 15px; margin-top: 10px; }
.currency-label { font-weight: bold; color: #888; }
.input-with-icon input { background: transparent; border: none; padding: 12px; width: 100%; outline: none; font-size: 18px; font-weight: bold; }
.btn-submit { background: #28a745; color: white; border: none; padding: 15px; width: 100%; border-radius: 12px; font-weight: 800; cursor: pointer; }
.btn-cancel { width: 100%; background: none; border: none; padding: 10px; color: #888; cursor: pointer; margin-top: 10px; }

@keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<script>
$(document).ready(function () {
    $('.btn-konfirmasi-new').on('click', function () {
        const id = $(this).data('id');
        const buku = $(this).data('buku');
        const denda = $(this).data('denda');

        $('#mdl_id_peminjaman').val(id);
        $('#mdl_id_buku').val(buku);
        $('#mdl_denda').val(denda);
        $('#modalDenda').fadeIn(200);
    });
});

function closeModal() {
    $('#modalDenda').fadeOut(200);
}
</script>