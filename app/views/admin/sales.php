<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Penjualan - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --primary-color: #28a745; --bg-color: #f8f9fa; }
        body { background-color: var(--bg-color); font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
        .dashboard-wrapper { display: flex; width: 100%; height: 100vh; overflow: hidden; position: relative; }
        
        /* Sidebar */
        .sidebar { 
            width: 250px; 
            background-color: #fff; 
            padding: 30px 20px; 
            border-right: 1px solid #eee; 
            display: flex; 
            flex-direction: column;
            transition: left 0.3s ease;
        }
        .brand { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 40px; text-align: center; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 20px; color: #6b7280; text-decoration: none; border-radius: 12px; font-weight: 500; margin-bottom: 10px; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-menu a i { margin-right: 15px; width: 20px; text-align: center; }
        
        .main-content { flex: 1; padding: 30px 40px; overflow-y: auto; background-color: #f3f4f6; width: 100%; }
        
        
        .stat-card-green { 
            background: linear-gradient(135deg, #198754, #28a745); 
            color: #fff; 
            border-radius: 15px; 
            padding: 25px; 
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3); 
            height: 100%;
        }
        .stat-card-green h6 { font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; margin-bottom: 10px; }
        .stat-card-green h3 { font-weight: 700; margin-bottom: 5px; font-size: 1.8rem;}
        .stat-card-green p { font-size: 0.75rem; opacity: 0.8; margin: 0; }

        
        .chart-card { background: #fff; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); height: 100%; }
        .chart-title { font-size: 1rem; font-weight: 600; text-transform: uppercase; color: #333; margin-bottom: 20px; letter-spacing: 0.5px;}

        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
        }

        /* responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: -250px;
                z-index: 999;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            .sidebar.active {
                left: 0;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .main-content {
                padding: 20px 15px;
            }
            .brand { margin-bottom: 20px; }
            .chart-card { margin-top: 15px; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand d-flex justify-content-between align-items-center">
            <span><i class="fas fa-lemon text-warning me-2"></i>FreshJuice</span>
            <button type="button" class="btn btn-sm btn-light d-md-none" id="closeSidebar"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php?action=admin_dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?action=admin_products"><i class="fas fa-box"></i>Products</a></li>
            <li><a href="index.php?action=admin_records"><i class="fas fa-clipboard-list"></i> Pencatatan</a></li>
            <li><a href="index.php?action=admin_sales" class="active"><i class="fas fa-chart-line"></i> Total Penjualan</a></li>
            <li><a href="index.php?action=logout" class="text-danger mt-5"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- main content -->
    <div class="main-content">
        <div class="d-flex align-items-center mb-4">
            
            <button type="button" class="btn btn-light d-md-none me-3 shadow-sm" id="openSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h3 class="fw-bold mb-0">Total Penjualan</h3>
        </div>

       
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card-green">
                    <h6>Total Pendapatan</h6>
                    <h3>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3>
                    <p>Total pendapatan kotor saat ini</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-green">
                    <h6>Total Pesanan</h6>
                    <h3><?= $totalOrders ?> Transaksi</h3>
                    <p>Jumlah order dari semua pelanggan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-green">
                    <h6>Rata-Rata Transaksi</h6>
                    <h3>Rp <?= number_format($avgTransaction, 0, ',', '.') ?></h3>
                    <p>Estimasi pembelian per pelanggan</p>
                </div>
            </div>
        </div>

        
        <div class="row g-4 mb-5">
            <!-- Bar Chart (Tren Penjualan) -->
            <div class="col-md-8">
                <div class="chart-card">
                    <div class="chart-title">Penjualan Insight (Rp)</div>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Donut Chart (Produk Terlaris) -->
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title">Status Produk Terlaris</div>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- get PHP data ke Javascript -->
<script>
    // Data dari Controller
    const barLabels = <?= json_encode(!empty($barLabels) ? $barLabels : ['Belum ada data']) ?>;
    const barData = <?= json_encode(!empty($barData) ? $barData : [0]) ?>;
    
    const donutLabels = <?= json_encode(!empty($donutLabels) ? $donutLabels : ['Belum ada data']) ?>;
    const donutData = <?= json_encode(!empty($donutData) ? $donutData : [1]) ?>;

    // Bar Chart (Penjualan Insight)
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: barData,
                backgroundColor: '#28a745', 
                borderRadius: 4,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    //  Donut Chart (Produk Terlaris)
    const ctxDonut = document.getElementById('donutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: donutLabels,
            datasets: [{
                data: donutData,
                backgroundColor: ['#198754', '#28a745', '#66d481', '#b3e6c0'], 
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    openBtn.addEventListener('click', () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
</script>
</body>
</html>