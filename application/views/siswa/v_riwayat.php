<div class="content" style="padding: 25px; background: #f8f9fa; min-height: 100vh;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Riwayat Peminjaman Saya</h2>

        <form action="<?= base_url('siswa/riwayat') ?>" method="get"
            style="display: flex; gap: 10px; align-items: center;">
            <select name="filter" onchange="this.form.submit()"
                style="padding: 8px 15px; border-radius: 8px; border: 1px solid #ddd; outline: none; background: white; cursor: pointer;">
                <option value="">Semua Status</option>
                <option value="menunggu" <?= ($this->input->get('filter') == 'menunggu') ? 'selected' : '' ?>>Peminjaman
                    Diajukan
                </option>
                <option value="disetujui" <?= ($this->input->get('filter') == 'disetujui') ? 'selected' : '' ?>>Sedang
                    Dipinjam</option>
                <option value="pending_kembali" <?= ($this->input->get('filter') == 'pending_kembali') ? 'selected' : '' ?>>Pengembalian Diajukan</option>
                <option value="ditolak" <?= ($this->input->get('filter') == 'ditolak') ? 'selected' : '' ?>>Ditolak
                </option>
                <option value="kembali" <?= ($this->input->get('filter') == 'kembali') ? 'selected' : '' ?>>Selesai
                </option>
            </select>
            <a href="<?= base_url('siswa/riwayat') ?>"
                style="text-decoration: none; color: #666; font-size: 14px;">Reset</a>
        </form>
    </div>

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #333; color: white;">
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Judul Buku</th>
                    <th style="padding: 15px;">Tgl Pinjam</th>
                    <th style="padding: 15px;">Batas Kembali</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: #999;">Belum ada riwayat transaksi.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php $no = 1;
                foreach ($riwayat as $r): ?>
                    <tr style="border-bottom: 1px solid #eee; transition: 0.2s;"
                        onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">
                        <td style="padding: 15px;"><?= $no++; ?></td>
                        <td style="padding: 15px; font-weight: bold; color: #333;"><?= $r->judul; ?></td>
                        <td style="padding: 15px; font-size: 14px; color: #666;">
                            <?= date('d M Y', strtotime($r->tanggal_pinjam)); ?>
                        </td>
                        <td style="padding: 15px; font-size: 14px; color: #666;">
                            <?= ($r->tanggal_deadline) ? date('d M Y', strtotime($r->tanggal_deadline)) : '<span style="color:#ccc">-</span>'; ?>
                        </td>
                        <td style="padding: 15px;">
                            <?php
                            if ($r->status == 'menunggu')
                                echo '<span style="background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">Peminjaman Diajukan</span>';
                            elseif ($r->status == 'disetujui')
                                echo '<span style="background: #d1ecf1; color: #0c5460; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">Sedang Dipinjam</span>';
                            elseif ($r->status == 'pending_kembali')
                                echo '<span style="background: #e2e3e5; color: #383d41; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">Pengembalian Diajukan</span>';
                            elseif ($r->status == 'kembali')
                                echo '<span style="background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">Selesai</span>';
                            else
                                echo '<span style="background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">' . strtoupper($r->status) . '</span>';
                            ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <?php if ($r->status == 'menunggu'): ?>
                                <a href="<?= base_url('siswa/batal_pinjam/' . $r->id_peminjaman); ?>"
                                    onclick="return confirm('Batalkan pengajuan ini?')"
                                    style="text-decoration: none; background: #dc3545; color: white; padding: 6px 12px; border-radius: 6px; font-size: 13px;">Batal</a>
                            <?php elseif ($r->status == 'disetujui'): ?>
                                <a href="<?= base_url('siswa/ajukan_kembali/' . $r->id_peminjaman); ?>"
                                    style="text-decoration: none; background: #007bff; color: white; padding: 6px 12px; border-radius: 6px; font-size: 13px;">Kembalikan
                                    Buku</a>
                            <?php else: ?>
                                <span style="color: #ccc;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>