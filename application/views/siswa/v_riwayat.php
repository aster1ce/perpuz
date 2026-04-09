<div class="content" style="padding: 25px; background: #f8f9fa; min-height: 100vh;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #333; font-weight: 800;">Riwayat Peminjaman</h2>
            <p style="margin: 5px 0 0; color: #888; font-size: 14px;">Pantau status buku dan denda lo di sini.</p>
        </div>

        <form action="<?= base_url('siswa/riwayat') ?>" method="get" style="display: flex; gap: 10px; align-items: center;">
            <select name="filter" onchange="this.form.submit()"
                style="padding: 10px 15px; border-radius: 10px; border: 1px solid #ddd; outline: none; background: white; cursor: pointer; font-size: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                <option value="">Semua Status</option>
                <option value="menunggu" <?= ($this->input->get('filter') == 'menunggu') ? 'selected' : '' ?>>Menunggu Persetujuan</option>
                <option value="disetujui" <?= ($this->input->get('filter') == 'disetujui') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                <option value="pending_kembali" <?= ($this->input->get('filter') == 'pending_kembali') ? 'selected' : '' ?>>Proses Kembali</option>
                <option value="kembali" <?= ($this->input->get('filter') == 'kembali') ? 'selected' : '' ?>>Selesai</option>
                <option value="ditolak" <?= ($this->input->get('filter') == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
            </select>
            <a href="<?= base_url('siswa/riwayat') ?>" style="text-decoration: none; color: #dc3545; font-size: 14px; font-weight: bold; margin-left: 5px;">Reset</a>
        </form>
    </div>

    <div style="background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #eee;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #1a1a1a; color: white;">
                    <th style="padding: 18px 15px;">No</th>
                    <th style="padding: 18px 15px;">Judul Buku</th>
                    <th style="padding: 18px 15px;">Tgl Pinjam</th>
                    <th style="padding: 18px 15px;">Batas Kembali</th>
                    <th style="padding: 18px 15px;">Status</th>
                    <th style="padding: 18px 15px;">Denda</th>
                    <th style="padding: 18px 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="7" style="padding: 50px; text-align: center; color: #bbb;">
                            <span class="material-icons" style="font-size: 48px; display: block; margin-bottom: 10px;">inventory_2</span>
                            Belum ada riwayat transaksi yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($riwayat as $r): ?>
                    <tr style="border-bottom: 1px solid #f2f2f2; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='white'">
                        <td style="padding: 15px; color: #888; font-size: 14px;"><?= $no++; ?></td>
                        <td style="padding: 15px;">
                            <span style="font-weight: 700; color: #333; display: block;"><?= $r->judul; ?></span>
                            <small style="color: #aaa; font-size: 11px;">ID: #<?= $r->id_peminjaman ?></small>
                        </td>
                        <td style="padding: 15px; font-size: 13px; color: #555;"><?= date('d M Y', strtotime($r->tanggal_pinjam)); ?></td>
                        <td style="padding: 15px; font-size: 13px; color: #555;">
                            <?= ($r->tanggal_deadline) ? date('d M Y', strtotime($r->tanggal_deadline)) : '<span style="color:#ccc">---</span>'; ?>
                        </td>
                        <td style="padding: 15px;">
                            <?php
                            $style = "padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: inline-block;";
                            if ($r->status == 'menunggu')
                                echo "<span style='$style background: #fff8e1; color: #f59e0b;'>Menunggu</span>";
                            elseif ($r->status == 'disetujui')
                                echo "<span style='$style background: #e0f2fe; color: #0284c7;'>Dipinjam</span>";
                            elseif ($r->status == 'pending_kembali')
                                echo "<span style='$style background: #f3f4f6; color: #4b5563;'>Proses Balik</span>";
                            elseif ($r->status == 'kembali')
                                echo "<span style='$style background: #dcfce7; color: #16a34a;'>Selesai</span>";
                            else
                                echo "<span style='$style background: #fee2e2; color: #dc2626;'>$r->status</span>";
                            ?>
                        </td>
                        <td style="padding: 15px; font-weight: 700; color: <?= ($r->denda > 0) ? '#dc2626' : '#16a34a' ?>; font-size: 14px;">
                            Rp <?= number_format($r->denda, 0, ',', '.'); ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <?php if ($r->status == 'menunggu'): ?>
                                <a href="<?= base_url('siswa/batal_pinjam/' . $r->id_peminjaman); ?>" 
                                   onclick="return confirm('Batalkan pengajuan ini?')"
                                   style="text-decoration: none; background: #fee2e2; color: #dc2626; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: bold;">Batal</a>
                            <?php elseif ($r->status == 'disetujui'): ?>
                                <a href="<?= base_url('siswa/ajukan_kembali/' . $r->id_peminjaman); ?>"
                                   style="text-decoration: none; background: #2563eb; color: white; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: bold; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);">Balikin Buku</a>
                            <?php else: ?>
                                <span style="color: #ddd;">---</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if ($pagination): ?>
        <div style="padding: 20px; background: #fafafa; border-top: 1px solid #eee; display: flex; justify-content: center;">
            <?= $pagination ?>
        </div>
        <?php endif; ?>
    </div>
</div>