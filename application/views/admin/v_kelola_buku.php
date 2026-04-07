<div class="content">
    <h2>Data Buku</h2>
    <button onclick="document.getElementById('modalAdd').style.display='block'">+ Tambah Buku</button>
    <table border="1" style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr style="background:#eee">
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php $no = $this->uri->segment(3) + 1;
        foreach ($buku as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $b->judul ?></td>
                <td><?= $b->penulis ?></td>
                <td><?= $b->stok ?></td>
                <td>
                    <a href="<?= base_url('admin/buku_delete/' . $b->id_buku) ?>" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:10px;"><?= $pagination ?></div>
</div>

<div id="modalAdd"
    style="display:none; position:fixed; background:rgba(0,0,0,0.5); width:100%; height:100%; top:0; left:0;">
    <div style="background:white; width:300px; margin:100px auto; padding:20px;">
        <h3>Tambah Buku</h3>
        <form action="<?= base_url('admin/buku_add') ?>" method="post">
            <input type="text" name="judul" placeholder="Judul" required><br><br>
            <input type="text" name="penulis" placeholder="Penulis" required><br><br>
            <input type="number" name="stok" placeholder="Stok" required><br><br>
            <button type="submit">Simpan</button>
            <button type="button" onclick="document.getElementById('modalAdd').style.display='none'">Batal</button>
        </form>
    </div>
</div>