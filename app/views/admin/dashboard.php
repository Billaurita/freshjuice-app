<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-color: #28a745; --bg-color: #f8f9fa; }
        
        body { 
            background-color: var(--bg-color); 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            padding: 0; 
        }
        
        .dashboard-wrapper { 
            background-color: var(--bg-color); 
            width: 100%; 
            height: 100vh; 
            display: flex; 
            overflow: hidden; 
            position: relative;
        }
        
        /* Sidebar */
        .sidebar { 
            width: 250px; 
            background-color: #fff; 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            border-right: 1px solid #eee;
            transition: left 0.3s ease; /* Transisi halus untuk HP */
        }
        .brand { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 40px; text-align: center; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 20px; color: #6b7280; text-decoration: none; border-radius: 12px; font-weight: 500; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-menu a i { margin-right: 15px; width: 20px; text-align: center; }
        
        /* Main Content */
        .main-content { flex: 1; padding: 30px 40px; overflow-y: auto; width: 100%; }
        .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .profile-area { display: flex; align-items: center; gap: 15px; background: #fff; padding: 5px 15px 5px 5px; border-radius: 30px; }
        .profile-pic { width: 40px; height: 40px; border-radius: 50%; background: var(--primary-color); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        
        /* Stat Cards */
        .stat-card { background: #fff; border-radius: 15px; padding: 25px; display: flex; align-items: center; gap: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        .stat-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
        
        /* Table Card */
        .table-card { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin-top: 30px; }
        .table thead th { color: #6b7280; font-weight: 500; border-bottom: 2px solid #f3f4f6; }
        .table tbody td { vertical-align: middle; padding: 15px 10px; border-bottom: 1px solid #f3f4f6; }
        
        .status-select { border-radius: 20px; padding: 5px 15px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: 1px solid #ddd; outline: none; }
        .status-select:focus { box-shadow: none; border-color: var(--primary-color); }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
        }

        /* responsive layout */
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
            .top-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
                margin-bottom: 25px;
            }
            .profile-area {
                align-self: flex-end; 
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
            <span><i class="fas fa-lemon text-warning me-2"></i>FreshJuice Admin</span>
            <button class="btn btn-sm btn-light d-md-none" id="closeSidebar"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php?action=admin_dashboard" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?action=admin_products"><i class="fas fa-box"></i>Products</a></li>
            <li><a href="index.php?action=admin_records"><i class="fas fa-clipboard-list"></i>Pencatatan</a></li>
            <li><a href="index.php?action=admin_sales"><i class="fas fa-chart-line"></i> Total Penjualan</a></li>
            <li><a href="index.php?action=logout" class="text-danger mt-5"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- main content -->
    <div class="main-content">
        <!-- header -->
        <div class="top-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-md-none me-3 shadow-sm" id="openSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="fw-bold mb-0">Hello, <?= htmlspecialchars(explode(' ', $_SESSION['name'] ?? 'Admin')[0]) ?> 👋</h4>
            </div>
            
            <div class="profile-area shadow-sm">
                <div class="profile-pic"><?= strtoupper(substr($_SESSION['name'] ?? 'A', 0, 1)) ?></div>
                <span class="fw-semibold text-dark pe-2"><?= htmlspecialchars($_SESSION['name'] ?? 'Administrator') ?></span>
            </div>
        </div>

        <!-- card perhitungan -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #fff3e0; color: #f59e0b;"><i class="fas fa-box-open"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0"><?= $totalProducts ?? 0 ?></h3>
                        <p class="text-muted mb-0 small">Total Products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #fee2e2; color: #ef4444;"><i class="fas fa-receipt"></i></div>
                    <div>
                        <h3 class="fw-bold mb-0"><?= $totalOrders ?? 0 ?></h3>
                        <p class="text-muted mb-0 small">Total Orders (All Customers)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pencatatan & Update Status -->
        <div class="table-card">
            <h5 class="fw-bold mb-4">All Orders</h5>
            <div class="table-responsive">
                <table class="table table-borderless text-nowrap">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Total Price</th>
                            <th>Status Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($orders)): ?>
                            <?php foreach($orders as $o): ?>
                            <tr>
                                <td class="fw-bold text-dark">#<?= $o['id'] ?></td>
                                <td><?= htmlspecialchars($o['customer_name'] ?? 'Guest') ?></td>
                                <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                                <td class="fw-semibold">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
                                <td>
                                    <!-- Update status -->
                                    <form action="index.php?action=admin_update_status" method="POST" class="m-0">
                                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                        <select name="status" class="form-select status-select shadow-sm" onchange="this.form.submit()">
                                            <option value="order_placed" <?= $o['status'] == 'order_placed' ? 'selected' : '' ?>>Order Placed</option>
                                            <option value="accepted" <?= $o['status'] == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                            <option value="in_progress" <?= $o['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                            <option value="on_the_way" <?= $o['status'] == 'on_the_way' ? 'selected' : '' ?>>On the Way</option>
                                            <option value="delivered" <?= $o['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted">Belum ada pesanan masuk.</td></tr>
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