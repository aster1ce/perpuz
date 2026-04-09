<div class="content">
    <div class="page-header">
        <div class="header-text">
            <h2>Manajemen Anggota</h2>
            <p>Kelola data siswa dan akses akun Perpustakaan Booksy.</p>
        </div>
        <button class="btn-add" onclick="document.getElementById('modalUser').style.display='block'">
            <span class="material-icons">person_add</span>
            Tambah Siswa
        </button>
    </div>

    <div class="table-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 80px; text-align: center;">No</th>
                    <th>Profil Siswa</th>
                    <th>Username</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = $this->uri->segment(3) + 1;
                foreach ($user as $u): ?>
                    <tr>
                        <td style="text-align: center; color: #888; font-weight: 600;"><?= $no++ ?></td>
                        <td>
                            <div class="user-profile-cell">
                                <div class="avatar">
                                    <?= strtoupper(substr($u->nama_lengkap, 0, 1)) ?>
                                </div>
                                <div class="user-det">
                                    <strong><?= $u->nama_lengkap ?></strong>
                                    <small>ID: #<?= $u->id_user ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <code class="username-tag">@<?= $u->username ?></code>
                        </td>
                        <td style="text-align: center;">
                            <div class="action-group">
                                <button class="btn-icon edit" 
                                    onclick="editUser('<?= $u->id_user ?>', '<?= $u->username ?>', '<?= $u->nama_lengkap ?>')"
                                    title="Edit Data">
                                    <span class="material-icons">edit</span>
                                </button>
                                <a href="<?= base_url('admin/user_delete/' . $u->id_user) ?>" 
                                   class="btn-icon delete"
                                   onclick="return confirm('Hapus siswa <?= $u->nama_lengkap ?>?')"
                                   title="Hapus Data">
                                    <span class="material-icons">delete</span>
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

<div id="modalUser" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Registrasi Siswa Baru</h3>
            <span class="close-modal" onclick="document.getElementById('modalUser').style.display='none'">&times;</span>
        </div>
        <form action="<?= base_url('admin/user_add') ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Masukkan nama siswa..." required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Contoh: ridwan_januar" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter..." required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit">Simpan Data</button>
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalUser').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditUser" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Data Siswa</h3>
            <span class="close-modal" onclick="document.getElementById('modalEditUser').style.display='none'">&times;</span>
        </div>
        <form action="<?= base_url('admin/user_edit') ?>" method="post">
            <div class="modal-body">
                <input type="hidden" name="id_user" id="edit_id_user">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="edit_nama" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="edit_username" required>
                </div>
                <div class="form-group" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #eee;">
                    <label>Ganti Password <small style="color: #ff4d4d;">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" placeholder="Masukkan password baru...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit update">Simpan Perubahan</button>
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalEditUser').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
/* HEADER SECTION */
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header-text h2 { margin: 0; font-size: 24px; font-weight: 800; color: #1a1a1a; }
.header-text p { margin: 5px 0 0; color: #888; font-size: 14px; }

.btn-add { background: #1a1a1a; color: white; border: none; padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; }
.btn-add:hover { background: #333; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

/* TABLE STYLING */
.table-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
.modern-table { width: 100%; border-collapse: collapse; }
.modern-table th { background: #fcfcfc; padding: 18px 20px; text-align: left; font-size: 12px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #eee; }
.modern-table td { padding: 15px 20px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }

/* USER CELL */
.user-profile-cell { display: flex; align-items: center; gap: 12px; }
.avatar { width: 40px; height: 40px; background: #e3f2fd; color: #1976d2; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px; }
.user-det strong { display: block; font-size: 15px; color: #333; }
.user-det small { color: #bbb; font-size: 11px; }
.username-tag { background: #f5f5f5; padding: 4px 10px; border-radius: 6px; font-family: 'Monaco', monospace; font-size: 13px; color: #666; }

/* ACTIONS */
.action-group { display: flex; justify-content: center; gap: 10px; }
.btn-icon { width: 36px; height: 36px; border-radius: 10px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; text-decoration: none; }
.btn-icon.edit { background: #fff4e5; color: #f57f17; }
.btn-icon.delete { background: #ffebee; color: #c62828; }
.btn-icon:hover { transform: scale(1.1); }

/* MODAL MODERN */
.modal-overlay { display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
.modal-content { background:#fff; width:400px; margin:8% auto; border-radius:24px; animation: slideIn 0.3s ease; }
.modal-header { padding: 20px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
.modal-body { padding: 25px; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; font-size: 13px; font-weight: 700; color: #555; margin-bottom: 8px; }
.form-group input { width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 12px; background: #f9f9f9; box-sizing: border-box; outline: none; transition: 0.3s; }
.form-group input:focus { border-color: #1a1a1a; background: #fff; }

.modal-footer { padding: 0 25px 25px; }
.btn-submit { background: #1a1a1a; color: white; border: none; padding: 15px; width: 100%; border-radius: 12px; font-weight: 800; cursor: pointer; margin-bottom: 10px; }
.btn-submit.update { background: #1976d2; }
.btn-cancel { width: 100%; background: none; border: none; color: #888; font-weight: 600; cursor: pointer; }

/* PAGINATION OVERRIDE */
.pagination-container { padding: 20px; text-align: center; }
.pagination-container a, .pagination-container strong { padding: 8px 14px; margin: 0 4px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 13px; }
.pagination-container a { background: #f5f5f5; color: #666; }
.pagination-container strong { background: #1a1a1a; color: #fff; }

@keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<script>
    function editUser(id, username, nama) {
        document.getElementById('edit_id_user').value = id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('modalEditUser').style.display = 'block';
    }

    // Close modal click outside
    window.onclick = function(event) {
        if (event.target.className === 'modal-overlay') {
            event.target.style.display = 'none';
        }
    }
</script>