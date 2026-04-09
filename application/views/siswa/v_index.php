<div class="content">
    <div class="parent-bento">
        <div class="div9 bento-item profile-card">
            <div class="bento-content">
                <span class="material-icons icon-main">account_circle</span>
                <h2>Halo, <br><?= $this->session->userdata('nama_lengkap') ?>!</h2>
                <p>Siap buat nambah ilmu hari ini? Cek koleksi buku terbaru kita ya.</p>
                <a href="<?= base_url('siswa/katalog') ?>" class="btn-explore">Cari Buku <span
                        class="material-icons">arrow_forward</span></a>
            </div>
        </div>

        <div class="div10 bento-item stats-card">
            <div class="bento-content">
                <div class="stats-info">
                    <span class="material-icons">menu_book</span>
                    <div>
                        <h3>Buku Dipinjam</h3>
                        <h1><?= $total_pinjam ?> <small>Buku</small></h1>
                    </div>
                </div>
                <div class="stats-info">
                    <span class="material-icons" style="color: #4caf50;">check_circle</span>
                    <div>
                        <h3>Selesai</h3>
                        <h1><?= $total_selesai ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="div11 bento-item denda-card">
            <div class="bento-content">
                <div class="denda-header">
                    <span class="material-icons">payments</span>
                    <h3>Tagihan Denda</h3>
                </div>
                <h2 class="price">Rp <?= number_format($total_denda, 0, ',', '.') ?></h2>
                <hr style="border: 0; border-top: 1px solid rgba(0,0,0,0.1); margin: 15px 0;">
                <p class="tips"><span class="material-icons">info</span> <b>Tips:</b> Balikin buku sebelum deadline biar
                    denda nggak makin numpuk, Bestie!</p>
            </div>
        </div>

        <div class="div3 bento-item history-card">
            <div class="bento-content">
                <h3>Aktivitas Terakhir</h3>
                <ul class="quick-list">
                    <li>
                        <span class="dot"></span>
                        <div>
                            <p class="book-title">Pemrograman PHP</p>
                            <small>Sedang Dipinjam</small>
                        </div>
                    </li>
                    <li>
                        <span class="dot done"></span>
                        <div>
                            <p class="book-title">Basis Data XII</p>
                            <small>Sudah Kembali</small>
                        </div>
                    </li>
                </ul>
                <a href="<?= base_url('siswa/riwayat') ?>" class="link-more">Lihat Semua Riwayat</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* GRID SYSTEM BENTO */
    .parent-bento {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(5, 1fr);
        gap: 15px;
        height: calc(100vh - 80px);
        /* Menyesuaikan tinggi layar */
    }

    .bento-item {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .bento-item:hover {
        transform: translateY(-5px);
    }

    /* POSISI SESUAI REQUEST LO */
    .div9 {
        grid-area: 1 / 1 / 6 / 2;
        background: #1a1a1a;
        color: white;
        border: none;
    }

    /* Kiri Full */
    .div10 {
        grid-area: 1 / 2 / 3 / 4;
    }

    /* Tengah Atas */
    .div11 {
        grid-area: 3 / 2 / 6 / 4;
        background: #fffbeb;
        border: 1px solid #fef3c7;
    }

    /* Tengah Bawah */
    .div3 {
        grid-area: 1 / 4 / 6 / 6;
    }

    /* Kanan Full */

    /* STYLING KONTEN */
    .bento-content {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .icon-main {
        font-size: 50px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.3);
    }

    .profile-card h2 {
        font-size: 28px;
        margin: 0 0 10px 0;
        font-weight: 800;
    }

    .profile-card p {
        font-size: 14px;
        opacity: 0.7;
        line-height: 1.6;
    }

    .btn-explore {
        margin-top: auto;
        background: white;
        color: black;
        padding: 12px;
        text-align: center;
        border-radius: 12px;
        text-decoration: none;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .stats-card .bento-content {
        justify-content: space-around;
    }

    .stats-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stats-info h3 {
        margin: 0;
        font-size: 14px;
        color: #888;
    }

    .stats-info h1 {
        margin: 0;
        font-size: 32px;
    }

    .stats-info h1 small {
        font-size: 14px;
        color: #aaa;
    }

    .denda-header {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #856404;
    }

    .price {
        font-size: 36px;
        margin: 15px 0;
        color: #333;
    }

    .tips {
        font-size: 13px;
        color: #856404;
        display: flex;
        gap: 5px;
    }

    .history-card h3 {
        margin-bottom: 20px;
        font-size: 18px;
    }

    .quick-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .quick-list li {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
    }

    .dot {
        width: 10px;
        height: 10px;
        background: orange;
        border-radius: 50%;
        margin-top: 5px;
    }

    .dot.done {
        background: #4caf50;
    }

    .book-title {
        margin: 0;
        font-weight: bold;
        font-size: 14px;
    }

    .quick-list small {
        color: #999;
    }

    .link-more {
        margin-top: auto;
        text-align: center;
        color: #333;
        font-weight: bold;
        font-size: 13px;
        text-decoration: none;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    /* Responsif buat layar kecil */
    @media (max-width: 900px) {
        .parent-bento {
            display: flex;
            flex-direction: column;
            height: auto;
        }
    }
</style>