<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin FreshJuice</title>
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
        
        /* Form Cards */
        .form-card { background: #fff; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); height: 100%; }
        .form-card h6 { font-weight: 600; margin-bottom: 20px; color: #333; }
        .form-control { border-radius: 8px; background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 12px 15px; }
        .form-control:focus { box-shadow: none; border-color: var(--primary-color); background-color: #fff; }
        
        .upload-area { border: 2px dashed #e5e7eb; border-radius: 12px; padding: 40px; text-align: center; background: #f9fafb; cursor: pointer; }
        
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }

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
            .header-actions { flex-direction: column; align-items: flex-start; }
            .header-actions > div { width: 100%; display: flex; justify-content: space-between; }
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
            <li><a href="index.php?action=admin_products" class="active"><i class="fas fa-box"></i>Products</a></li>
            <li><a href="index.php?action=admin_records"><i class="fas fa-clipboard-list"></i> Pencatatan</a></li>
            <li><a href="index.php?action=admin_sales"><i class="fas fa-chart-line"></i> Total Penjualan</a></li>
            <li><a href="index.php?action=logout" class="text-danger mt-5"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Upload file gambar -->
        <form action="index.php?action=admin_product_store" method="POST" enctype="multipart/form-data">
            
            <div class="header-actions">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-light d-md-none me-3 shadow-sm" id="openSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="fw-bold m-0"><i class="fas fa-box me-2"></i>Add New Product</h4>
                </div>
                <div>
                    <a href="index.php?action=admin_products" class="btn btn-light border fw-semibold me-2">Cancel</a>
                    <button type="submit" class="btn btn-success fw-semibold"><i class="fas fa-check me-2"></i>Add Product</button>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Informasi Harga -->
                <div class="col-lg-8">
                    <div class="form-card mb-0">
                        <h6>General Information</h6>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Name Product</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Avocado Choco" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Description Product</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan komposisi dan deskripsi jus..." required></textarea>
                        </div>
                        
                        <h6 class="mt-4">Pricing</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Base Price (Rp)</label>
                                <input type="number" name="price" class="form-control" placeholder="25000" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Gambar -->
                <div class="col-lg-4">
                    <div class="form-card h-100 mb-0">
                        <h6>Upload Image</h6>
                        <div class="upload-area mt-4">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Click or drag image to upload</h6>
                            <input type="file" name="image" class="form-control mt-3" accept="image/png, image/jpeg" required>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
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