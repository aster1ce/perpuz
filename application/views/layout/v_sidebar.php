<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root {
        --primary-blue: #3b82f6;
        --sidebar-white: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --bg-active: rgba(59, 130, 246, 0.08);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        margin: 0;
    }

    /* Sidebar Styling */
    .sidebar {
        width: 260px;
        /* Sedikit lebih lebar agar nafas teks lega */
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        background: var(--sidebar-white);
        padding: 2rem 1.25rem;
        border-right: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar h3 {
        font-weight: 700;
        color: var(--primary-blue);
        letter-spacing: -1px;
        padding-left: 0.75rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Nav Links */
    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }

    .sidebar ul li {
        margin-bottom: 0.5rem;
    }

    .sidebar ul li a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.85rem 1rem;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.925rem;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    /* Hover & Active State */
    .sidebar ul li a:hover {
        background: var(--bg-active);
        color: var(--primary-blue);
    }

    /* Gunakan class 'active' dari sisi PHP jika halaman sedang dibuka */
    .sidebar ul li a.active {
        background: var(--primary-blue);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    /* Logout Section */
    .logout-box {
        margin-top: auto;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn-logout {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.85rem 1rem;
        color: #ef4444;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.925rem;
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 0.08);
    }

    /* Main Content Area */
    .main-content {
        margin-left: 260px;
        padding: 2.5rem;
    }
</style>

<div class="sidebar">
    <h3>
        <i data-lucide="book-open-check"></i> Booksy
    </h3>

    <?php if ($this->session->userdata('role') == 'admin'): ?>
        <ul>
            <li>
                <a href="<?= base_url('admin') ?>"
                    class="<?= ($this->uri->segment(1) == 'admin' && !$this->uri->segment(2)) ? 'active' : '' ?>">
                    <i data-lucide="layout-dashboard" size="18"></i> Dashboard Admin
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/kelola_buku') ?>"
                    class="<?= ($this->uri->segment(2) == 'kelola_buku') ? 'active' : '' ?>">
                    <i data-lucide="book-plus" size="18"></i> Kelola Buku
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/kelola_user') ?>"
                    class="<?= ($this->uri->segment(2) == 'kelola_user') ? 'active' : '' ?>">
                    <i data-lucide="users" size="18"></i> Kelola Anggota
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/transaksi') ?>"
                    class="<?= ($this->uri->segment(2) == 'transaksi') ? 'active' : '' ?>">
                    <i data-lucide="arrow-left-right" size="18"></i> Kelola Transaksi
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/laporan') ?>"
                    class="<?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
                    <i data-lucide="file-text" size="18"></i> Laporan
                </a>
            </li>
        </ul>
    <?php else: ?>
        <ul>
            <li>
                <a href="<?= base_url('siswa') ?>"
                    class="<?= ($this->uri->segment(1) == 'siswa' && !$this->uri->segment(2)) ? 'active' : '' ?>">
                    <i data-lucide="layout-dashboard" size="18"></i> Dashboard Siswa
                </a>
            </li>
            <li>
                <a href="<?= base_url('siswa/buku') ?>" class="<?= ($this->uri->segment(2) == 'buku') ? 'active' : '' ?>">
                    <i data-lucide="search" size="18"></i> Pinjam Buku
                </a>
            </li>
            <li>
                <a href="<?= base_url('siswa/riwayat') ?>"
                    class="<?= ($this->uri->segment(2) == 'riwayat') ? 'active' : '' ?>">
                    <i data-lucide="history" size="18"></i> Riwayat Saya
                </a>
            </li>
        </ul>
    <?php endif; ?>

    <div class="logout-box">
        <a href="<?= base_url('auth/logout') ?>" class="btn-logout">
            <i data-lucide="log-out" size="18"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">
    <script>
        lucide.createIcons();
    </script>