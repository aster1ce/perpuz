<div class="content">
    <h2 class="no-print">Laporan Transaksi Perpustakaan</h2>
    <hr class="no-print">

    <form action="<?= base_url('admin/laporan') ?>" method="GET" style="margin-bottom: 20px;" class="no-print">
        <input type="date" name="tgl_mulai" value="<?= $tgl_mulai ?>" required>
        s/d
        <input type="date" name="tgl_selesai" value="<?= $tgl_selesai ?>" required>
        <button type="submit">Filter</button>
        <button type="button" onclick="window.print()" style="background: green; color: white;">Cetak Ringkasan</button>
    </form>

    <?php if ($tgl_mulai): ?>
        <div id="print-area" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
            <div class="only-print" style="text-align: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">PERPUSTAKAAN SMK IGASAR PINDAD</h2>
                <p>Jl. Cisaranten Kulon No.17, Bandung</p>
                <hr style="border: 1px solid black;">
                <h3>RINGKASAN LAPORAN PEMINJAMAN</h3>
            </div>

            <table style="width: 100%; font-size: 18px; line-height: 2;">
                <tr>
                    <td width="200">Periode</td>
                    <td>: <b><?= date('d M Y', strtotime($tgl_mulai)) ?> - <?= date('d M Y', strtotime($tgl_selesai)) ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Total Transaksi</td>
                    <td>: <b><?= $total_pinjam ?> Peminjaman</b></td>
                </tr>
                <tr>
                    <td>Total Pendapatan Denda</td>
                    <td>: <b style="color: green;">Rp <?= number_format($total_denda, 0, ',', '.') ?></b></td>
                </tr>
            </table>

            <div style="margin-top: 50px; text-align: right;" class="only-print">
                <p>Bandung, <?= date('d F Y') ?></p>
                <br><br><br>
                <p><b>(Admin Perpustakaan)</b></p>
            </div>
        </div>

        <div class="no-print" style="margin-top: 30px;">
            <h4>Preview Data Detail (Tidak Ikut Dicetak)</h4>
            <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
    /* CSS UNTUK TAMPILAN DI LAYAR */
    .only-print {
        display: none;
    }

    @media print {

        /* Sembunyikan SEMUA elemen secara default */
        body * {
            visibility: hidden;
        }

        /* Tampilkan cuma area laporan saja */
        #print-area,
        #print-area * {
            visibility: visible;
        }

        /* Posisikan area laporan ke pojok kiri atas kertas */
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            /* Hilangkan border kotak saat diprint biar bersih */
        }

        /* Munculkan elemen khusus print */
        .only-print {
            display: block !important;
        }

        /* Sembunyikan sidebar, navbar, tombol, dll secara paksa */
        .no-print,
        .sidebar,
        .navbar,
        .footer,
        header,
        nav {
            display: none !important;
        }
    }
</style>