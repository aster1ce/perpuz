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
                    <button
                        onclick="editBuku('<?= $b->id_buku ?>', '<?= addslashes($b->judul) ?>', '<?= addslashes($b->penulis) ?>', '<?= $b->stok ?>')">Edit</button>
                    |
                    <a href="<?= base_url('admin/buku_delete/' . $b->id_buku) ?>"
                        onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:10px;"><?= $pagination ?></div>
</div>

<div id="modalAdd"
    style="display:none; position:fixed; background:rgba(0,0,0,0.5); width:100%; height:100%; top:0; left:0; z-index:999;">
    <div style="background:white; width:300px; margin:100px auto; padding:20px;">
        <h3>Tambah Buku</h3>
        <form action="<?= base_url('admin/buku_add') ?>" method="post">
            <input type="text" name="judul" placeholder="Judul" required><br><br>
            <input type="text" name="penulis" placeholder="Penulis" required><br><br>
            <input type="number" name="stok" value="0" min="0" required><br><br>
            <button type="submit">Simpan</button>
            <button type="button" onclick="document.getElementById('modalAdd').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<div id="modalEdit"
    style="display:none; position:fixed; background:rgba(0,0,0,0.5); width:100%; height:100%; top:0; left:0; z-index:999;">
    <div style="background:white; width:300px; margin:100px auto; padding:20px;">
        <h3>Edit Buku</h3>
        <form action="<?= base_url('admin/buku_edit') ?>" method="post">
            <input type="hidden" name="id_buku" id="edit_id">

            <input type="text" name="judul" id="edit_judul" placeholder="Judul" required><br><br>
            <input type="text" name="penulis" id="edit_penulis" placeholder="Penulis" required><br><br>
            <input type="number" name="stok" id="edit_stok" value="0" min="0" required><br><br>

            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('modalEdit').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<script>
    function editBuku(id, judul, penulis, stok) {
        // Masukkan data ke input modal
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_judul').value = judul;
        document.getElementById('edit_penulis').value = penulis;
        document.getElementById('edit_stok').value = stok;

        // Munculkan modal edit
        document.getElementById('modalEdit').style.display = 'block';
    }
</script>