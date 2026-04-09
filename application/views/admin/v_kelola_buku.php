<div class="content">
    <div class="page-header">
        <div class="header-text">
            <h2>Katalog Koleksi Buku</h2>
            <p>Atur stok, judul, dan informasi penulis di Perpustakaan Booksy.</p>
        </div>
        <button class="btn-add" onclick="document.getElementById('modalAdd').style.display='block'">
            <span class="material-icons">library_add</span>
            Tambah Buku
        </button>
    </div>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th>Informasi Buku</th>
                    <th>Penulis</th>
                    <th style="text-align: center;">Persediaan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = $this->uri->segment(3) + 1;
                foreach ($buku as $b): ?>
                    <tr>
                        <td style="text-align: center; color: #888; font-weight: 600;"><?= $no++ ?></td>
                        <td>
                            <div class="book-info-cell">
                                <div class="book-icon">
                                    <span class="material-icons">book</span>
                                </div>
                                <div class="book-det">
                                    <strong><?= $b->judul ?></strong>
                                    <small>SKU: BUKU-<?= str_pad($b->id_buku, 4, '0', STR_PAD_LEFT) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="author-tag"><?= $b->penulis ?></span>
                        </td>
                        <td style="text-align: center;">
                            <?php 
                                $stock_class = 'stock-safe';
                                if($b->stok <= 0) $stock_class = 'stock-empty';
                                elseif($b->stok <= 5) $stock_class = 'stock-low';
                            ?>
                            <div class="stock-badge <?= $stock_class ?>">
                                <?= $b->stok ?> Eks
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="action-group">
                                <button class="btn-icon edit" 
                                    onclick="editBuku('<?= $b->id_buku ?>', '<?= addslashes($b->judul) ?>', '<?= addslashes($b->penulis) ?>', '<?= $b->stok ?>')"
                                    title="Edit Buku">
                                    <span class="material-icons">edit_note</span>
                                </button>
                                <a href="<?= base_url('admin/buku_delete/' . $b->id_buku) ?>" 
                                   class="btn-icon delete"
                                   onclick="return confirm('Hapus buku <?= addslashes($b->judul) ?>?')"
                                   title="Hapus Buku">
                                    <span class="material-icons">delete_sweep</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="pagination-container">
            <?= $pagination ?>
        </div>
    </div>
</div>

<div id="modalAdd" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Input Koleksi Baru</h3>
            <span class="close-modal" onclick="document.getElementById('modalAdd').style.display='none'">&times;</span>
        </div>
        <form action="<?= base_url('admin/buku_add') ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" placeholder="Masukkan judul lengkap..." required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" placeholder="Nama penulis/pengarang..." required>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok" value="0" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit">Simpan Koleksi</button>
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalAdd').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Perbarui Informasi Buku</h3>
            <span class="close-modal" onclick="document.getElementById('modalEdit').style.display='none'">&times;</span>
        </div>
        <form action="<?= base_url('admin/buku_edit') ?>" method="post">
            <div class="modal-body">
                <input type="hidden" name="id_buku" id="edit_id">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" id="edit_judul" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" id="edit_penulis" required>
                </div>
                <div class="form-group">
                    <label>Update Stok</label>
                    <input type="number" name="stok" id="edit_stok" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit update">Update Informasi</button>
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalEdit').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
/* THEME CONSISTENCY WITH USER PAGE */
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header-text h2 { margin: 0; font-size: 24px; font-weight: 800; color: #1a1a1a; }
.header-text p { margin: 5px 0 0; color: #888; font-size: 14px; }

.btn-add { background: #1a1a1a; color: white; border: none; padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; }
.btn-add:hover { background: #333; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

/* TABLE */
.table-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
.modern-table { width: 100%; border-collapse: collapse; }
.modern-table th { background: #fcfcfc; padding: 18px 20px; text-align: left; font-size: 12px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #eee; }
.modern-table td { padding: 18px 20px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }

/* BOOK INFO */
.book-info-cell { display: flex; align-items: center; gap: 15px; }
.book-icon { width: 42px; height: 42px; background: #f0f0f0; color: #555; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.book-det strong { display: block; font-size: 15px; color: #1a1a1a; line-height: 1.3; }
.book-det small { color: #bbb; font-size: 11px; font-family: 'Courier New', monospace; }
.author-tag { color: #666; font-size: 14px; font-weight: 500; }

/* STOCK BADGE */
.stock-badge { display: inline-block; padding: 4px 12px; border-radius: 8px; font-size: 12px; font-weight: 800; }
.stock-safe { background: #e8f5e9; color: #2e7d32; }
.stock-low { background: #fff3e0; color: #e65100; }
.stock-empty { background: #ffebee; color: #c62828; }

/* ACTION GROUP */
.action-group { display: flex; justify-content: center; gap: 8px; }
.btn-icon { width: 36px; height: 36px; border-radius: 10px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; text-decoration: none; }
.btn-icon.edit { background: #e3f2fd; color: #1976d2; }
.btn-icon.delete { background: #ffebee; color: #c62828; }
.btn-icon:hover { transform: scale(1.1); }

/* MODAL MODES */
.modal-overlay { display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
.modal-content { background:#fff; width:420px; margin:8% auto; border-radius:24px; overflow:hidden; animation: slideIn 0.3s ease; }
.modal-header { padding: 20px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
.modal-body { padding: 25px; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; font-size: 13px; font-weight: 700; color: #555; margin-bottom: 8px; }
.form-group input { width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 12px; background: #f9f9f9; box-sizing: border-box; outline: none; transition: 0.3s; font-size: 14px; }
.form-group input:focus { border-color: #1a1a1a; background: #fff; }

.modal-footer { padding: 0 25px 25px; }
.btn-submit { background: #1a1a1a; color: white; border: none; padding: 15px; width: 100%; border-radius: 12px; font-weight: 800; cursor: pointer; margin-bottom: 10px; }
.btn-submit.update { background: #1a1a1a; }
.btn-cancel { width: 100%; background: none; border: none; color: #888; font-weight: 600; cursor: pointer; }

/* PAGINATION */
.pagination-container { padding: 20px; text-align: center; }
.pagination-container a, .pagination-container strong { padding: 8px 14px; margin: 0 4px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 13px; }
.pagination-container a { background: #f5f5f5; color: #666; }
.pagination-container strong { background: #1a1a1a; color: #fff; }

@keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<script>
    function editBuku(id, judul, penulis, stok) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_judul').value = judul;
        document.getElementById('edit_penulis').value = penulis;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('modalEdit').style.display = 'block';
    }

    // Modal click outside protection
    window.onclick = function(event) {
        if (event.target.className === 'modal-overlay') {
            event.target.style.display = 'none';
        }
    }
</script>