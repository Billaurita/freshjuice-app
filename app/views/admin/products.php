<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin FreshJuice</title>
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
            display: flex; 
            flex-direction: column; 
            border-right: 1px solid #eee; 
            transition: left 0.3s ease;
        }
        .brand { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 40px; text-align: center; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 20px; color: #6b7280; text-decoration: none; border-radius: 12px; font-weight: 500; margin-bottom: 10px; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-menu a i { margin-right: 15px; width: 20px; text-align: center; }
        
        .main-content { flex: 1; padding: 30px 40px; overflow-y: auto; width: 100%; }
        
        /* Product Layout */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .btn-add { background-color: #0d6efd; color: #fff; border-radius: 8px; padding: 10px 20px; font-weight: 500; text-decoration: none; white-space: nowrap; }
        .btn-add:hover { background-color: #0b5ed7; color: #fff; }
        
        .table-card { background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.02); }
        .table tbody td { vertical-align: middle; padding: 15px; border-bottom: 1px solid #f3f4f6; }
        .prod-img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; background: #f8f9fa; min-width: 50px; }

        
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
            <button class="btn btn-sm btn-light d-md-none" id="closeSidebar"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php?action=admin_dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?action=admin_products" class="active"><i class="fas fa-box"></i>Products</a></li>
            <li><a href="index.php?action=admin_records"><i class="fas fa-clipboard-list"></i> Pencatatan</a></li>
            <li><a href="index.php?action=admin_sales"><i class="fas fa-chart-line"></i> Total Penjualan</a></li>
            <li><a href="index.php?action=logout" class="text-danger mt-5"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- main content -->
    <div class="main-content">
        <div class="page-header">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-md-none me-3 shadow-sm" id="openSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h3 class="fw-bold m-0">Products</h3>
            </div>
            <a href="index.php?action=admin_product_add" class="btn-add"><i class="fas fa-plus me-2"></i> NEW PRODUCT</a>
        </div>

        <div class="table-card table-responsive">
            <table class="table table-borderless table-hover text-nowrap">
                <thead class="text-muted small">
                    <tr>
                        <th>PRODUCT DETAILS</th>
                        <th>PRICE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($products)): ?>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="public/images/<?= htmlspecialchars($p['image']) ?>" alt="" class="prod-img me-3">
                                    <div>
                                        <h6 class="mb-1 fw-bold"><?= htmlspecialchars($p['name']) ?></h6>
                                        <small class="text-muted"><?= substr(htmlspecialchars($p['description']), 0, 50) ?>...</small>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                            <td>
                                <a href="index.php?action=admin_product_edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-light border">Edit</a>
                                <button class="btn btn-sm btn-light border text-danger"><i class="fas fa-ellipsis-h"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center text-muted">Belum ada produk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
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