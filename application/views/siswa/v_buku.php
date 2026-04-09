<div class="content" style="padding: 20px; background: #f8f9fa;">
    <h2 style="margin-bottom: 5px;">Katalog Buku Perpustakaan</h2>
    <p style="color: #666; margin-bottom: 25px;">Pilih buku favoritmu dan pinjam sekarang!</p>
    <hr style="border: 0; height: 1px; background: #ddd; margin-bottom: 30px;">

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">

        <?php foreach ($buku as $b): ?>
            <div
                style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: 0.3s; border: 1px solid #eee;">

                <div
                    style="background: #e9ecef; height: 180px; display: flex; align-items: center; justify-content: center; color: #adb5bd;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.203-.977-3.481-1.077-1.28-.101-2.458.063-3.112.752V2.828zM8 3.787c1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.203-.977-3.481-1.077-1.28-.101-2.458.063-3.112.752V3.787z" />
                    </svg>
                </div>

                <div style="padding: 15px;">
                    <h3
                        style="margin: 0 0 5px 0; font-size: 16px; color: #333; height: 40px; overflow: hidden; line-height: 1.3;">
                        <?= $b->judul; ?>
                    </h3>
                    <p style="margin: 0; font-size: 13px; color: #888;">Penulis: <?= $b->penulis; ?></p>

                    <div style="margin-top: 15px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <?php if ($b->stok > 0): ?>
                                <span
                                    style="font-size: 12px; background: #e8f5e9; color: #2e7d32; padding: 3px 8px; border-radius: 20px; font-weight: bold;">
                                    Stok: <?= $b->stok; ?>
                                </span>
                            <?php else: ?>
                                <span
                                    style="font-size: 12px; background: #ffebee; color: #c62828; padding: 3px 8px; border-radius: 20px; font-weight: bold;">
                                    Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if ($b->stok > 0): ?>
                            <button onclick="bukaModalPinjam('<?= $b->id_buku ?>', '<?= addslashes($b->judul) ?>')"
                                style="background: #333; color: white; padding: 8px 15px; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: bold;">
                                Pinjam
                            </button>
                        <?php else: ?>
                            <button disabled
                                style="background: #ccc; color: white; padding: 8px 15px; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px;">
                                Limit
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<div id="modalPinjam"
    style="display:none; position:fixed; background:rgba(0,0,0,0.6); width:100%; height:100%; top:0; left:0; z-index: 9999; backdrop-filter: blur(2px);">
    <div
        style="background:white; width:350px; margin:100px auto; padding:25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0; color: #333;">Form Peminjaman</h3>

        <p id="judulBukuTeks"
            style="font-weight: bold; color: #333; background: #f4f4f4; padding: 12px; border-radius: 6px; border-left: 4px solid #333;">
        </p>

        <form action="<?= base_url('siswa/proses_pinjam') ?>" method="post">
            <input type="hidden" name="id_buku" id="idBukuHidden">

            <div style="margin-bottom: 15px;">
                <label style="font-size: 14px; font-weight: bold;">Pilih Tanggal Pinjam:</label>
                <input type="date" name="tanggal_pinjam" id="inputTgl" required
                    style="width: 100%; padding: 10px; margin-top: 8px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
            </div>

            <div
                style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 6px; font-size: 12px; margin-bottom: 20px; line-height: 1.4;">
                <strong>💡 Info:</strong> Durasi pinjam 3 hari. Terlambat mengembalikan akan dikenakan denda sebesar
                <b>Rp 2.000/hari</b>.
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="document.getElementById('modalPinjam').style.display='none'"
                    style="flex: 1; background:#eee; color:#333; border:none; padding:12px; border-radius:6px; cursor:pointer; font-weight: bold;">Batal</button>
                <button type="submit"
                    style="flex: 1; background:green; color:white; border:none; padding:12px; border-radius:6px; cursor:pointer; font-weight: bold;">Konfirmasi</button>
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