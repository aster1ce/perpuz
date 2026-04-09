<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<div class="main-content-wrapper p-4">
    <div class="no-print">
        <h2 class="fw-bold text-dark-grey mb-1">Laporan Detail Transaksi</h2>
        <p class="text-muted small mb-4">Filter dan cetak riwayat peminjaman buku secara mendetail.</p>

        <form action="<?= base_url('admin/laporan') ?>" method="GET" class="card p-4 border-0 shadow-sm rounded-4 mb-4">
            <div class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control rounded-3" value="<?= $tgl_mulai ?>"
                        required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" class="form-control rounded-3" value="<?= $tgl_selesai ?>"
                        required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="filter" class="form-select rounded-3">
                        <option value="">Semua Status</option>
                        <option value="disetujui" <?= ($filter == 'disetujui') ? 'selected' : '' ?>>Dipinjam
                        </option>
                        <option value="kembali" <?= ($filter == 'kembali') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit"
                        class="btn btn-dark-grey px-4 rounded-3 fw-bold d-flex align-items-center gap-2 flex-grow-1 justify-content-center">
                        <span class="material-icons-round fs-5">filter_alt</span> Filter
                    </button>
                    <button type="button" onclick="window.print()"
                        class="btn btn-success px-4 rounded-3 fw-bold d-flex align-items-center gap-2 flex-grow-1 justify-content-center">
                        <span class="material-icons-round fs-5">print</span> Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($tgl_mulai): ?>
        <div id="print-area" class="bg-white p-2">
            <div class="only-print text-center mb-4">
                <h2 class="fw-800 mb-0">PERPUSTAKAAN SMK IGASAR PINDAD</h2>
                <p class="mb-2 text-muted" style="font-size: 14px;">Jl. Cisaranten Kulon No.17, Bandung | Telp: (022)
                    7800747</p>
                <div style="border-top: 3px double #000; margin-bottom: 20px;"></div>
                <h4 class="fw-bold text-uppercase">Laporan Detail Peminjaman Buku</h4>
                <p class="small">
                    Periode: <b><?= date('d M Y', strtotime($tgl_mulai)) ?></b> s/d
                    <b><?= date('d M Y', strtotime($tgl_selesai)) ?></b>
                    <?php if ($filter): ?> | Status: <b><?= $filter ?></b><?php endif; ?>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle custom-table">
                    <thead class="bg-light-grey">
                        <tr class="text-center small fw-bold text-uppercase">
                            <th width="50">No</th>
                            <th width="120">Tanggal</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th width="150">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php if (!empty($detail_transaksi)): ?>
                            <?php $no = 1;
                            foreach ($detail_transaksi as $d): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= date('d/m/y', strtotime($d->tanggal_pinjam)) ?></td>
                                    <td class="fw-semibold px-3"><?= $d->nama_lengkap ?></td>
                                    <td class="px-3"><?= $d->judul ?></td>
                                    <td class="text-end px-3">Rp <?= number_format($d->denda, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Tidak ada data transaksi ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="fw-bold bg-light">
                        <tr>
                            <td colspan="4" class="text-end px-3 py-3">TOTAL PENDAPATAN DENDA</td>
                            <td class="text-end text-success px-3 py-3">Rp <?= number_format($total_denda, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="only-print mt-5">
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4 text-center">
                        <p class="mb-0 small">Bandung, <?= date('d F Y') ?></p>
                        <p class="fw-bold small mb-5">Admin Perpustakaan,</p>
                        <br><br>
                        <p class="fw-bold text-decoration-underline mb-0">Ridwan Januar K.</p>
                        <p class="extra-small text-muted">Petugas Administrasi</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    :root {
        --dark-grey: #334155;
        --light-grey: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f1f5f9;
    }

    .text-dark-grey {
        color: var(--dark-grey);
    }

    .fw-800 {
        font-weight: 800;
    }

    .extra-small {
        font-size: 10px;
    }

    .main-content-wrapper {
        margin-left: 260px;
    }

    .btn-dark-grey {
        background: var(--dark-grey);
        color: white;
    }

    .bg-light-grey {
        background-color: var(--light-grey);
    }

    .custom-table th {
        padding: 12px 8px;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-table td {
        padding: 10px 8px;
    }

    .only-print {
        display: none;
    }

    @media print {
        @page {
            size: portrait;
            margin: 1.5cm;
        }

        body * {
            visibility: hidden;
            background-color: transparent !important;
        }

        #print-area,
        #print-area * {
            visibility: visible;
        }

        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            color: black !important;
        }

        .only-print {
            display: block !important;
        }

        .no-print,
        .sidebar,
        .navbar,
        .footer {
            display: none !important;
        }

        table {
            border-collapse: collapse !important;
            width: 100% !important;
            border: 1px solid #000 !important;
        }

        th {
            background-color: #f2f2f2 !important;
            color: black !important;
            border: 1px solid #000 !important;
            -webkit-print-color-adjust: exact;
        }

        td {
            border: 1px solid #000 !important;
        }
    }

    @media (max-width: 992px) {
        .main-content-wrapper {
            margin-left: 0;
        }
    }
</style>