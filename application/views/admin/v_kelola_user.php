<div class="content">
    <h2>Data Anggota (Siswa)</h2>
    <button onclick="document.getElementById('modalUser').style.display='block'">+ Tambah Siswa</button>
    <table border="1" style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr style="background:#eee">
            <th>No</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Aksi</th>
        </tr>
        <?php $no = $this->uri->segment(3) + 1;
        foreach ($user as $u): ?>
            <tr>
                <td>
                    <?= $no++ ?>
                </td>
                <td>
                    <?= $u->username ?>
                </td>
                <td>
                    <?= $u->nama_lengkap ?>
                </td>
                <td>
                    <button
                        onclick="editUser('<?= $u->id_user ?>', '<?= $u->username ?>', '<?= $u->nama_lengkap ?>')">Edit</button>
                    <a href="<?= base_url('admin/user_delete/' . $u->id_user) ?>"
                        onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div style="margin-top:10px;">
        <?= $pagination ?>
    </div>
</div>

<div id="modalUser"
    style="display:none; position:fixed; background:rgba(0,0,0,0.5); width:100%; height:100%; top:0; left:0;">
    <div style="background:white; width:300px; margin:100px auto; padding:20px;">
        <form action="<?= base_url('admin/user_add') ?>" method="post">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required><br><br>
            <button type="submit">Tambah</button>
            <button type="button" onclick="document.getElementById('modalUser').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<div id="modalEditUser"
    style="display:none; position:fixed; background:rgba(0,0,0,0.5); width:100%; height:100%; top:0; left:0;">
    <div style="background:white; width:300px; margin:100px auto; padding:20px;">
        <h3>Edit Siswa</h3>
        <form action="<?= base_url('admin/user_edit') ?>" method="post">
            <input type="hidden" name="id_user" id="edit_id_user">
            <input type="text" name="username" id="edit_username" required><br><br>
            <input type="text" name="nama_lengkap" id="edit_nama" required><br><br>
            <small>Kosongkan password jika tidak ingin diubah</small><br>
            <input type="password" name="password" placeholder="Password Baru"><br><br>
            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('modalEditUser').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<script>
    function editUser(id, username, nama) {
        document.getElementById('edit_id_user').value = id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('modalEditUser').style.display = 'block';
    }
</script>