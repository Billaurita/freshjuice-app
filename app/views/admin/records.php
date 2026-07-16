<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Penjualan - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        
        
        .stat-card { background: linear-gradient(135deg, #198754, #28a745); color: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3); }
        .table-card { background: #fff; border-radius: 15px; padding: 25px; margin-top: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }

        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
        }

        /* Responsive */
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
            <li><a href="index.php?action=admin_records" class="active"><i class="fas fa-clipboard-list"></i> Pencatatan</a></li>
            <li><a href="index.php?action=admin_sales"><i class="fas fa-chart-line"></i> Total Penjualan</a></li>
            <li><a href="index.php?action=logout" class="text-danger mt-5"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- main content -->
    <div class="main-content">
        <div class="d-flex align-items-center mb-4">
            <button type="button" class="btn btn-light d-md-none me-3 shadow-sm" id="openSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h3 class="fw-bold mb-0">Pencatatan Produk Terjual</h3>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <h5>Total Produk Terjual</h5>
                    <h2 class="fw-bold mt-3"><?= $totalSold ?? 0 ?> Item</h2>
                    <p class="small opacity-75">Seluruh produk yang telah dipesan</p>
                </div>
            </div>
        </div>

        <div class="table-card">
            <h5 class="fw-bold mb-4">Detail Produk Terlaris</h5>
            <div class="table-responsive">
                <table class="table align-middle text-nowrap">
                    <thead class="text-muted small">
                        <tr>
                            <th>Product Name</th>
                            <th>Total Terjual (Qty)</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($productStats)): ?>
                            <?php foreach($productStats as $ps): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($ps['product_name']) ?></td>
                                <td><?= $ps['total_qty'] ?></td>
                                <td class="text-success fw-bold">Rp <?= number_format($ps['total_revenue'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center">Data belum tersedia.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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