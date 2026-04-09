<?php 
// Ambil segment untuk logic active menu
$segment1 = $this->uri->segment(1); 
$segment2 = $this->uri->segment(2); 
$role = $this->session->userdata('role');
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="sidebar">
    <div class="brand">
        <span class="material-icons">auto_stories</span>
        <h3>Booksy</h3>
    </div>
    
    <hr class="line">

    <ul class="nav-list">
        <?php if ($role == 'admin'): ?>
            <li class="<?= (empty($segment2) || $segment2 == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('admin') ?>">
                    <span class="material-icons">dashboard</span> Dashboard
                </a>
            </li>
            <li class="<?= ($segment2 == 'kelola_buku') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/kelola_buku') ?>">
                    <span class="material-icons">menu_book</span> Kelola Buku
                </a>
            </li>
            <li class="<?= ($segment2 == 'kelola_user') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/kelola_user') ?>">
                    <span class="material-icons">group</span> Anggota
                </a>
            </li>
            <li class="<?= ($segment2 == 'transaksi') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/transaksi') ?>">
                    <span class="material-icons">swap_horiz</span> Transaksi
                </a>
            </li>
            <li class="<?= ($segment2 == 'laporan') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/laporan') ?>">
                    <span class="material-icons">analytics</span> Laporan
                </a>
            </li>

        <?php else: ?>
            <li class="<?= ($segment1 == 'siswa' && (empty($segment2) || $segment2 == 'index' || $segment2 == 'dashboard')) ? 'active' : '' ?>">
                <a href="<?= base_url('siswa') ?>">
                    <span class="material-icons">dashboard</span> Dashboard
                </a>
            </li>
            <li class="<?= ($segment2 == 'buku' || $segment2 == 'katalog') ? 'active' : '' ?>">
                <a href="<?= base_url('siswa/buku') ?>">
                    <span class="material-icons">explore</span> Katalog
                </a>
            </li>
            <li class="<?= ($segment2 == 'riwayat') ? 'active' : '' ?>">
                <a href="<?= base_url('siswa/riwayat') ?>">
                    <span class="material-icons">history</span> Riwayat
                </a>
            </li>
        <?php endif; ?>

        <li class="logout-item">
            <a href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin mau log out, Bestie?')">
                <span class="material-icons">logout</span> Logout
            </a>
        </li>
    </ul>
</div>

<style>
    :root {
        --sidebar-width: 260px;
        --primary-dark: #1a1a1a;
        --text-gray: #888;
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #f8f9fa;
    }

    /* SIDEBAR FIXED POSITION */
    .sidebar {
        width: var(--sidebar-width);
        background: var(--primary-dark);
        height: 100vh;
        padding: 30px 20px;
        color: white;
        box-sizing: border-box;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0 10px 10px;
    }

    .brand h3 {
        margin: 0;
        letter-spacing: 1px;
        font-size: 24px;
        font-weight: 700;
    }

    .line {
        border: 0;
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 20px 0;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex: 1;
    }

    .nav-list li {
        margin-bottom: 10px;
    }

    .nav-list li a {
        display: flex;
        align-items: center;
        gap: 15px;
        text-decoration: none;
        color: var(--text-gray);
        padding: 14px 18px;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 15px;
        font-weight: 500;
    }

    /* HOVER & ACTIVE STATE */
    .nav-list li a:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .nav-list li.active a {
        background: #ffffff;
        color: var(--primary-dark);
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .nav-list li.active a span {
        color: var(--primary-dark);
    }

    /* LOGOUT STYLING */
    .logout-item {
        margin-top: auto;
    }

    .logout-item a:hover {
        background: rgba(255, 77, 77, 0.1) !important;
        color: #ff4d4d !important;
    }

    /* Biar ikonnya konsisten */
    .material-icons {
        font-size: 22px;
    }

    /* WRAPPER UNTUK KONTEN (WAJIB ADA DI FILE UTAMA) */
    .content {
        margin-left: var(--sidebar-width);
        padding: 30px;
        min-height: 100vh;
        box-sizing: border-box;
    }
</style>