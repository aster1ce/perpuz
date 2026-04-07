<div class="content-wrapper">
    <h2>Dashboard Siswa</h2>
    <hr>
    <div style="background: #e7f3ff; padding: 20px; border-radius: 8px; border: 1px solid #b6d4fe;">
        <h3>Selamat Datang, <strong><?php echo $this->session->userdata('nama'); ?></strong>!</h3>
        <p>Anda login sebagai <strong>Siswa</strong> di Sistem Perpustakaan Digital (Booksy).</p>
        <p>Hari ini: <?php echo date('d-m-Y'); ?></p>
    </div>

    <div style="margin-top: 20px;">
        <h4>Menu Cepat:</h4>
        <ul>
            <li>Cari buku yang ingin kamu pinjam di menu <strong>Pinjam Buku</strong>.</li>
            <li>Lihat buku yang sedang kamu bawa di menu <strong>Riwayat Saya</strong>.</li>
        </ul>
    </div>
</div>

</div>