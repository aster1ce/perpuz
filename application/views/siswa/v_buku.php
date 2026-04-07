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
                            <button onclick="bukaModalPinjam('<?= $b->id_buku ?>', '<?= addslashes($b->judul) ?>')"
                                style="background: green; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;">
                                Pinjam
                            </button>
                        <?php else: ?>
                            <span style="color: red;">Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="modalPinjam"
    style="display:none; position:fixed; background:rgba(0,0,0,0.5); width:100%; height:100%; top:0; left:0; z-index: 9999;">
    <div
        style="background:white; width:350px; margin:100px auto; padding:20px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <h3 style="margin-top: 0;">Form Peminjaman</h3>
        <p id="judulBukuTeks"
            style="font-weight: bold; color: #333; background: #eee; padding: 10px; border-radius: 4px;"></p>

        <form action="<?= base_url('siswa/proses_pinjam') ?>" method="post">
            <input type="hidden" name="id_buku" id="idBukuHidden">

            <div style="margin-bottom: 15px;">
                <label>Pilih Tanggal Pinjam:</label><br>
                <input type="date" name="tanggal_pinjam" id="inputTgl" required
                    style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div
                style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 4px; font-size: 12px; margin-bottom: 15px;">
                <strong>Info:</strong> Durasi pinjam 3 hari. Terlambat mengembalikan kena denda <b>Rp 2.000/hari</b>.
            </div>

            <div style="text-align: right;">
                <button type="button" onclick="document.getElementById('modalPinjam').style.display='none'"
                    style="background:#aaa; color:white; border:none; padding:8px 15px; border-radius:3px; cursor:pointer;">Batal</button>
                <button type="submit"
                    style="background:green; color:white; border:none; padding:8px 15px; border-radius:3px; cursor:pointer;">Konfirmasi
                    Pinjam</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalPinjam(id, judul) {
        // Masukin data ke form modal
        document.getElementById('idBukuHidden').value = id;
        document.getElementById('judulBukuTeks').innerText = judul;

        // Set default tanggal hari ini
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('inputTgl').value = today;
        document.getElementById('inputTgl').setAttribute('min', today); // Gak boleh pilih tanggal lampau

        // Tampilkan modal
        document.getElementById('modalPinjam').style.display = 'block';
    }

    // Biar bisa tutup modal kalau klik area hitam di luar modal
    window.onclick = function (event) {
        var modal = document.getElementById('modalPinjam');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>