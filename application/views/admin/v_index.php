<div class="content">
    <div class="admin-bento">
        <div class="div3 bento-card dark-card">
            <div class="card-head">
                <span class="material-icons">analytics</span>
                <h3>Library Stats</h3>
            </div>
            <div class="mini-stats-grid">
                <div class="mini-stat">
                    <h1><?= number_format($total_user) ?></h1>
                    <p>Anggota Aktif</p>
                </div>
                <div class="mini-stat">
                    <h1><?= number_format($total_buku) ?></h1>
                    <p>Koleksi Buku</p>
                </div>
            </div>
        </div>

        <div class="div4 bento-card">
            <h3 style="margin-bottom: 20px;">Traffic Aktivitas</h3>
            <div class="chart-wrapper">
                <canvas id="chartAktivitas"></canvas>
            </div>
        </div>

        <div class="div5 bento-card">
            <h3>Kategori Favorit</h3>
            <ul class="rank-list">
                <?php if (!empty($kategori_fav)): ?>
                    <?php $no = 1;
                    foreach ($kategori_fav as $k): ?>
                        <li><span class="rank-num"><?= $no++ ?></span> <?= $k->kategori ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted small">Belum ada data.</p>
                <?php endif; ?>
            </ul>
        </div>

        <div class="div6 bento-card">
            <h3>Status Transaksi</h3>
            <div class="chart-wrapper">
                <canvas id="chartStatusDonut"></canvas>
            </div>
        </div>

        <div class="div7 bento-card">
            <h3>Log Aktivitas</h3>
            <div class="log-container" style="overflow-y: auto; max-height: 100%;">
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <div class="log-item">
                            <span class="dot <?= ($log->status == 'kembali') ? 'kembali' : 'pinjam' ?>"></span>
                            <p>
                                <b><?= explode(' ', $log->nama_lengkap)[0] ?></b>
                                <?= ($log->status == 'kembali') ? 'mengembalikan' : 'meminjam' ?>
                                <i><?= $log->judul ?></i>
                                <br><small><?= date('H:i', strtotime($log->tanggal_pinjam ?? 'now')) ?> WIB</small>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted small">Tidak ada aktivitas terbaru.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="div8 bento-card info-admin">
            <h2 id="realtime-clock">00:00:00</h2>
            <p><?= date('l, d M Y') ?></p>
            <div class="admin-profile">
                <small>Logged in as:</small>
                <p><b><?= $this->session->userdata('role') ?></b></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. CHART TANGGA (Tetap dummy untuk visual)
    const ctxAktivitas = document.getElementById('chartAktivitas').getContext('2d');
    new Chart(ctxAktivitas, {
        type: 'line',
        data: {
            labels: <?= $chart_hari ?>,
            datasets: [{
                label: 'Total Pinjaman',
                data: <?= $chart_jumlah ?>,
                borderColor: '#1a1a1a',
                backgroundColor: 'rgba(26, 26, 26, 0.1)', // Kasih warna transparan di bawah garis
                borderWidth: 3,
                fill: true,
                stepped: true, // Efek tangga tetep ada
                pointRadius: 5, // <--- UBAH JADI 5 biar bisa di-hover mouse
                pointHoverRadius: 8,
                pointBackgroundColor: '#1a1a1a'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true, // Pastiin tooltip nyala
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (context) {
                            return context.parsed.y + ' Buku'; // Muncul tulisan "X Buku"
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }, // Angka bulat aja
                    grid: { borderDash: [5, 5] }
                },
                x: { grid: { display: false } }
            }
        }
    });
    // 2. DONUT CHART (Ambil data dari Controller $chart_status)
    const ctxStatus = document.getElementById('chartStatusDonut').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Pinjam', 'Kembali'],
            datasets: [{
                // VARIABEL DINAMIS DARI CONTROLLER:
                data: <?= $chart_status ?>,
                backgroundColor: ['#ffc107', '#007bff', '#28a745'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 10, font: { size: 11 } }
                }
            }
        }
    });

    // CLOCK SCRIPT
    function updateClock() {
        const now = new Date();
        document.getElementById('realtime-clock').innerText = now.toLocaleTimeString('id-ID');
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<style>
    /* CSS GRID ADJUSTMENT */
    .admin-bento {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(5, 1fr);
        gap: 12px;
        height: calc(100vh - 100px);
    }

    .bento-card {
        background: white;
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid #f0f0f0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .dark-card {
        background: #1a1a1a;
        color: white;
        border: none;
    }

    /* PENEMPATAN SESUAI REQUEST */
    .div3 {
        grid-area: 1 / 1 / 3 / 3;
    }

    .div4 {
        grid-area: 1 / 3 / 6 / 4;
    }

    .div5 {
        grid-area: 1 / 4 / 4 / 5;
    }

    .div6 {
        grid-area: 4 / 4 / 6 / 6;
    }

    .div7 {
        grid-area: 3 / 1 / 6 / 3;
    }

    .div8 {
        grid-area: 1 / 5 / 4 / 6;
    }

    /* CHART WRAPPER */
    .chart-wrapper {
        flex: 1;
        position: relative;
        min-height: 0;
    }

    /* MINI STATS */
    .mini-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }

    .mini-stat h1 {
        font-size: 38px;
        margin: 0;
    }

    .mini-stat p {
        font-size: 12px;
        opacity: 0.6;
    }

    /* LOGS & RANK */
    .rank-list {
        list-style: none;
        padding: 0;
        margin-top: 15px;
    }

    .rank-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .rank-num {
        background: #f0f0f0;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 12px;
        color: #333;
    }

    .log-item {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
    }

    .dot.pinjam {
        background: #007bff;
    }

    .dot.kembali {
        background: #28a745;
    }

    .info-admin {
        text-align: center;
        justify-content: center;
    }

    #realtime-clock {
        font-size: 28px;
        margin: 0;
        font-weight: 800;
    }

    .admin-profile {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. CHART TANGGA (Aktivitas Peminjaman)
    const ctxAktivitas = document.getElementById('chartAktivitas').getContext('2d');
    new Chart(ctxAktivitas, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Pinjaman',
                data: [10, 15, 8, 22, 18, 25, 40], // Data dummy
                borderColor: '#1a1a1a',
                borderWidth: 3,
                fill: true,
                backgroundColor: 'rgba(0,0,0,0.03)',
                stepped: true, // INI YANG BIKIN EFEK TANGGA
                pointRadius: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. DONUT CHART (Status)
    const ctxStatus = document.getElementById('chartStatusDonut').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Pinjam', 'Kembali'],
            datasets: [{
                data: [5, 12, 18],
                backgroundColor: ['#ffc107', '#007bff', '#28a745'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
        }
    });

    // CLOCK SCRIPT
    function updateClock() {
        const now = new Date();
        document.getElementById('realtime-clock').innerText = now.toLocaleTimeString('id-ID');
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>