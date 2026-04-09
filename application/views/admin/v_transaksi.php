<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="main-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row align-items-center mb-4">
            <div class="col-md-7">
                <h2 class="fw-bold text-dark-grey mb-1">Kelola Transaksi</h2>
                <p class="text-muted small mb-0">Monitor sirkulasi & konfirmasi pengembalian buku <span class="fw-bold">Booksy</span></p>
            </div>
            <div class="col-md-5 mt-3 mt-md-0">
                <form action="<?= base_url('admin/transaksi') ?>" method="GET" class="d-flex gap-2 justify-content-md-end">
                    <div class="filter-box">
                        <span class="material-icons-round">filter_list</span>
                        <select name="status" class="form-select border-0 shadow-none bg-transparent" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="disetujui" <?= ($status_aktif == 'disetujui') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                            <option value="pending_kembali" <?= ($status_aktif == 'pending_kembali') ? 'selected' : '' ?>>Perlu Konfirmasi</option>
                            <option value="kembali" <?= ($status_aktif == 'kembali') ? 'selected' : '' ?>>Selesai (Lunas)</option>
                            <option value="menunggu" <?= ($status_aktif == 'menunggu') ? 'selected' : '' ?>>Pengajuan Baru</option>
                            <option value="ditolak" <?= ($status_aktif == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    <?php if ($status_aktif): ?>
                        <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-light-grey d-flex align-items-center justify-content-center" title="Reset Filter">
                            <span class="material-icons-round">restart_alt</span>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-grey text-uppercase">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-bold small" width="50">#</th>
                            <th class="py-3 text-muted fw-bold small">Peminjam</th>
                            <th class="py-3 text-muted fw-bold small">Informasi Buku</th>
                            <th class="py-3 text-muted fw-bold small">Waktu & Deadline</th>
                            <th class="py-3 text-muted fw-bold small">Denda</th>
                            <th class="py-3 text-muted fw-bold small text-center">Status</th>
                            <th class="py-3 text-muted fw-bold small text-center px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($transaksi)): ?>
                            <?php 
                            // Logika penomoran otomatis sesuai pagination
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1; 
                            foreach ($transaksi as $t): ?>
                            <tr>
                                <td class="px-4 text-muted small"><?= $no++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle">
                                            <?= strtoupper(substr($t->nama_lengkap, 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark-grey small"><?= $t->nama_lengkap; ?></div>
                                            <div class="text-muted extra-small">ID #<?= $t->id_user; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark-grey small"><?= $t->judul; ?></div>
                                </td>
                                <td>
                                    <div class="date-stack">
                                        <div class="d-flex align-items-center gap-1 small fw-medium">
                                            <span class="material-icons-round fs-6 text-muted">login</span>
                                            <?= date('d M Y', strtotime($t->tanggal_pinjam)); ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-1 extra-small mt-1 <?= (strtotime($t->tanggal_deadline) < time() && $t->status != 'kembali') ? 'text-danger fw-bold' : 'text-muted' ?>">
                                            <span class="material-icons-round fs-6">event_busy</span>
                                            Deadline: <?= date('d M Y', strtotime($t->tanggal_deadline)); ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($t->status == 'kembali'): ?>
                                        <div class="text-success fw-bold small">Rp <?= number_format($t->denda, 0, ',', '.') ?><span class="ms-1 badge-lunas">LUNAS</span></div>
                                    <?php else: ?>
                                        <div class="fw-bold small <?= ($t->denda > 0) ? 'text-danger' : 'text-muted opacity-50' ?>">
                                            Rp <?= number_format($t->denda, 0, ',', '.') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $status_map = [
                                        'menunggu' => ['label' => 'Pengajuan', 'class' => 'st-waiting'],
                                        'disetujui' => ['label' => 'Dipinjam', 'class' => 'st-active'],
                                        'pending_kembali' => ['label' => 'Menunggu Konfirmasi', 'class' => 'st-pending'],
                                        'kembali' => ['label' => 'Selesai', 'class' => 'st-success'],
                                        'ditolak' => ['label' => 'Ditolak', 'class' => 'st-danger'],
                                    ];
                                    $st = $status_map[$t->status] ?? ['label' => 'Unknown', 'class' => 'bg-secondary'];
                                    ?>
                                    <span class="badge-status <?= $st['class'] ?>"><?= $st['label'] ?></span>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <?php if ($t->status == 'menunggu'): ?>
                                            <a href="<?= base_url('admin/setuju_pinjam/'.$t->id_peminjaman.'/'.$t->id_buku); ?>" class="btn-action approve" title="Setujui">
                                                <span class="material-icons-round">check_circle</span>
                                            </a>
                                            <a href="<?= base_url('admin/tolak_pinjam/'.$t->id_peminjaman); ?>" class="btn-action reject" onclick="return confirm('Tolak pengajuan ini?')" title="Tolak">
                                                <span class="material-icons-round">cancel</span>
                                            </a>
                                        <?php elseif ($t->status == 'pending_kembali'): ?>
                                            <button class="btn btn-dark-grey btn-sm px-3 rounded-pill fw-bold btn-konfirmasi-new" 
                                                    data-id="<?= $t->id_peminjaman ?>"
                                                    data-buku="<?= $t->id_buku ?>" 
                                                    data-denda="<?= $t->denda ?>">
                                                Konfirmasi Balik
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted fw-bold extra-small">DONE</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="opacity-25 mb-3">
                                    <p class="text-muted small fw-medium">Belum ada data transaksi yang ditemukan.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container d-flex justify-content-center py-4 bg-white border-top">
                <?= $pagination ?? '' ?>
            </div>
        </div>
    </div>
</div>

<div id="modalDenda" class="modal-custom-overlay">
    <div class="modal-custom-card">
        <div class="modal-custom-header">
            <h5 class="fw-800 mb-0 text-dark-grey">Penyelesaian Transaksi</h5>
            <button class="btn-close-modal" onclick="closeModal()">&times;</button>
        </div>
        <form action="<?= base_url('admin/konfirmasi_kembali_aksi') ?>" method="POST">
            <div class="modal-custom-body">
                <input type="hidden" name="id_peminjaman" id="mdl_id_peminjaman">
                <input type="hidden" name="id_buku" id="mdl_id_buku">

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Total Denda</label>
                    <div class="input-group input-group-custom">
                        <span class="input-group-text bg-light border-0">Rp</span>
                        <input type="number" id="total_tagihan" name="total_tagihan" class="form-control bg-light border-0 fw-bold" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Uang Diterima</label>
                    <div class="input-group input-group-custom border-dark-grey">
                        <span class="input-group-text bg-white border-0">Rp</span>
                        <input type="number" id="bayar" name="denda_dibayar" class="form-control border-0 shadow-none fw-bold" placeholder="0" oninput="hitungKembalian()" required>
                    </div>
                </div>

                <div class="kembalian-card mt-4" id="box-kembalian">
                    <span class="small d-block text-muted fw-semibold mb-1 uppercase">Kembalian</span>
                    <h3 class="mb-0 fw-800" id="kembalian">Rp 0</h3>
                </div>
            </div>
            <div class="modal-custom-footer">
                <button type="submit" class="btn btn-dark-grey w-100 py-3 rounded-4 fw-bold mb-2 shadow-sm">Selesaikan Transaksi</button>
                <button type="button" class="btn btn-link btn-sm w-100 text-decoration-none text-muted fw-bold" onclick="closeModal()">Batalkan</button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --dark-grey: #334155;
        --dark-hover: #1e293b;
        --light-grey: #f8fafc;
        --border-color: #e2e8f0;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
    .main-content-wrapper { margin-left: 260px; min-height: 100vh; transition: 0.3s; }
    .text-dark-grey { color: var(--dark-grey); }
    .bg-light-grey { background-color: var(--light-grey); }
    .fw-800 { font-weight: 800; }
    .extra-small { font-size: 11px; }

    /* Filter Box */
    .filter-box { background: white; border-radius: 12px; border: 1px solid var(--border-color); display: flex; align-items: center; padding: 2px 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .filter-box select { font-size: 14px; font-weight: 600; cursor: pointer; }
    .btn-light-grey { background: white; border: 1px solid var(--border-color); color: var(--dark-grey); border-radius: 12px; width: 45px; }

    /* Table & Avatar */
    .avatar-circle { width: 35px; height: 35px; background: var(--dark-grey); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; }
    .table thead th { border-top: none; white-space: nowrap; }
    .badge-lunas { font-size: 9px; background: #d1fae5; color: #065f46; padding: 2px 6px; border-radius: 4px; margin-left: 5px; }

    /* Badges Status */
    .badge-status { padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; display: inline-block; white-space: nowrap; }
    .st-waiting { background: #fffbeb; color: #9a3412; border: 1px solid #fed7aa; }
    .st-active { background: #f1f5f9; color: var(--dark-grey); border: 1px solid #cbd5e1; }
    .st-pending { background: #fdf4ff; color: #701a75; border: 1px solid #f5d0fe; }
    .st-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .st-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    /* PAGINATION STYLE */
    .pagination-container a, 
    .pagination-container strong {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        margin: 0 3px;
        padding: 0 12px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        transition: 0.2s;
    }
    .pagination-container a { background: white; color: var(--dark-grey); border: 1px solid var(--border-color); }
    .pagination-container a:hover { background: var(--light-grey); transform: translateY(-2px); border-color: var(--dark-grey); }
    .pagination-container strong { background: var(--dark-grey); color: white; border: 1px solid var(--dark-grey); }

    /* Modal & Buttons */
    .btn-dark-grey { background: var(--dark-grey); color: white; border: none; transition: 0.3s; }
    .btn-dark-grey:hover { background: var(--dark-hover); transform: translateY(-2px); }
    .btn-action { text-decoration: none; display: flex; align-items: center; transition: 0.2s; }
    .btn-action.approve { color: #10b981; }
    .btn-action.reject { color: #ef4444; }
    .btn-action:hover { transform: scale(1.1); }

    .modal-custom-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(5px); z-index: 9999; }
    .modal-custom-card { width: 400px; background: white; margin: 80px auto; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: modalIn 0.3s ease-out; }
    @keyframes modalIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-custom-header { padding: 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; }
    .modal-custom-body { padding: 24px; }
    .modal-custom-footer { padding: 0 24px 24px; }
    .btn-close-modal { background: none; border: none; font-size: 28px; color: #94a3b8; line-height: 1; }
    .input-group-custom { border: 2px solid #f1f5f9; border-radius: 12px; overflow: hidden; }
    .kembalian-card { background: #f8fafc; border-radius: 16px; padding: 15px; text-align: center; border: 1px dashed #cbd5e1; }

    @media (max-width: 992px) { .main-content-wrapper { margin-left: 0; } }
</style>

<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-konfirmasi-new', function () {
            const id = $(this).data('id');
            const buku = $(this).data('buku');
            const denda = $(this).data('denda');

            $('#mdl_id_peminjaman').val(id);
            $('#mdl_id_buku').val(buku);
            $('#total_tagihan').val(denda);

            $('#bayar').val('');
            $('#kembalian').text('Rp 0').css('color', '#334155');
            $('#box-kembalian').css({'background': '#f8fafc', 'border-color': '#cbd5e1'});

            $('#modalDenda').fadeIn(200);
        });
    });

    function closeModal() { $('#modalDenda').fadeOut(200); }

    function hitungKembalian() {
        let tagihan = parseFloat($('#total_tagihan').val()) || 0;
        let bayar = parseFloat($('#bayar').val()) || 0;
        let kembalian = bayar - tagihan;
        let display = $('#kembalian');
        let box = $('#box-kembalian');

        if (kembalian < 0) {
            display.text("Kurang: Rp " + Math.abs(kembalian).toLocaleString('id-ID'));
            display.css('color', '#ef4444');
            box.css({'background': '#fef2f2', 'border-color': '#fecaca'});
        } else {
            display.text("Rp " + kembalian.toLocaleString('id-ID'));
            display.css('color', '#10b981');
            box.css({'background': '#f0fdf4', 'border-color': '#bbf7d0'});
        }
    }
</script>