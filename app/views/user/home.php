<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - FreshJuice</title>
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .navbar-brand { color: #f39c12 !important; font-weight: 800; font-size: 1.5rem; }
        .navbar-brand span { color: #28a745; }
        .search-bar { border-radius: 20px 0 0 20px; background-color: #f1f2f6; border: none; }
        
        .sub-nav { background-color: #28a745; }
        .sub-nav a { color: white; text-decoration: none; padding: 10px 20px; font-weight: 500; font-size: 0.95rem; display: inline-block; }
        .sub-nav a:hover, .sub-nav a.active { border-bottom: 3px solid white; }
        
        .hero-section { background-color: #fcf4e3; border-radius: 20px; padding: 50px; margin-top: 20px; }
        .hero-title { color: #1e7e34; font-weight: 800; font-size: 3rem; line-height: 1.2; }
        .hero-title span { color: #f39c12; }
        .btn-belanja { background-color: #28a745; color: white; border-radius: 25px; padding: 10px 30px; font-weight: 600; border: none; }
        
        .product-card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); transition: 0.3s; overflow: hidden; }
        .product-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .product-img-wrap { background-color: #f9f9f9; padding: 20px; text-align: center; border-radius: 15px 15px 0 0; }
        .product-img { max-height: 180px; object-fit: contain; }
        .btn-add-cart { background-color: #28a745; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: none; }
        
        .why-choose-card { border: 1px solid #eee; border-radius: 15px; padding: 25px; background: white; text-align: center; transition: 0.3s; }
        .why-choose-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        
        .footer { background-color: #fff; border-top: 2px solid #a8d5ba; padding: 50px 0; margin-top: 50px; }
        .icon-history:hover { color: #28a745 !important; transform: scale(1.1); transition: 0.2s; }

        
        @media (max-width: 768px) {
            .hero-section { padding: 30px 20px; text-align: center; } /* Memusatkan teks di HP */
            .hero-title { font-size: 2.2rem; }
            .search-bar-container { width: 100% !important; margin-top: 15px; margin-bottom: 15px; } /* Search bar penuhi layar */
            .navbar-collapse { padding-top: 15px; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.php?action=home">
                <i class="fas fa-lemon text-warning"></i> Fresh<span>Juice</span>
            </a>
            
            <!--responsive -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- navbar -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="mx-auto search-bar-container" style="width: 50%;">
                    <div class="input-group position-relative">
                        <span class="position-absolute text-muted" style="z-index: 10; margin-top: 7px; margin-left: 15px;"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control search-bar" placeholder="Cari Jus favoritmu..." style="padding-left: 45px;">
                        <button class="btn btn-success" style="border-radius: 0 20px 20px 0; padding: 8px 25px;">Cari</button>
                    </div>
                </div>
                
                <!-- History & Dropdown icon -->
                <div class="d-flex align-items-center justify-content-center mt-3 mt-lg-0">
                    <a href="index.php?action=track_order" class="text-dark fs-4 me-3 icon-history text-decoration-none" title="Lacak Pesanan Saat Ini">
                        <i class="fas fa-clock-rotate-left"></i>
                    </a>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight: bold;"><?= strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)) ?></div>
                            <span class="fw-medium"><?= htmlspecialchars(explode(' ', $_SESSION['name'] ?? 'Pengguna')[0]) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- sub navbar -->
    <div class="sub-nav d-none d-md-block">
        <div class="container d-flex justify-content-center">
            <a href="index.php?action=home" class="active">Beranda</a>
            <a href="#produk">Semua Produk</a>
            <a href="#promo">Promo</a>
            <a href="#tentang">Tentang Kami</a>
            <a href="#kontak">Kontak</a>
        </div>
    </div>

    <div class="container mb-5">
        <!-- Hero Section -->
        <div class="hero-section row align-items-center">
            <div class="col-md-6 z-1 text-center text-md-start">
                <h1 class="hero-title mb-4">Nikmati Kesegaran<br><span>Setiap Hari</span></h1>
                <p class="text-muted mb-4 fs-5">FreshJuice menghadirkan berbagai pilihan jus buah segar 100% natural.</p>
                <a href="#produk" class="btn btn-belanja text-decoration-none d-inline-block"><i class="fas fa-shopping-bag me-2"></i> Belanja Sekarang</a>
            </div>
            <div class="col-md-6 text-center mt-5 mt-md-0">
                <img src="public/images/hero-image.png" alt="Kumpulan Jus Segar" class="img-fluid" style="max-height: 320px; object-fit: contain;">
            </div>
        </div>

        <!-- Daftar Produk -->
        <div id="produk" class="mt-5 d-flex justify-content-between align-items-end mb-4 flex-wrap">
            <h5 class="fw-bold mb-0">Produk Terlaris</h5>
            <a href="index.php?action=home#produk" class="text-success text-decoration-none fw-medium mt-2 mt-md-0">Lihat Semua</a>
        </div>
        
        <div class="row g-4">
            <?php foreach ($products as $row): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="index.php?action=detail&id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
                    <div class="card product-card h-100">
                        <div class="product-img-wrap"><img src="public/images/<?= htmlspecialchars($row['image']) ?>" class="product-img img-fluid"></div>
                        <div class="card-body p-3 p-md-4">
                            <h6 class="fw-bold fs-6"><?= htmlspecialchars($row['name']) ?></h6>
                            <p class="text-success fw-bold mb-0">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Why Choose Us -->
        <div id="tentang" class="mt-5 pt-4">
            <h2 class="text-center fw-bold mb-4">WHY CHOOSE US?</h2>
            <div class="row g-4">
                <div class="col-md-4"><div class="why-choose-card h-100"><i class="fas fa-utensils fa-2x text-success mb-3"></i><h5>Serve Healthy Food</h5></div></div>
                <div class="col-md-4"><div class="why-choose-card h-100"><i class="fas fa-award fa-2x text-success mb-3"></i><h5>Best Quality</h5></div></div>
                <div class="col-md-4"><div class="why-choose-card h-100"><i class="fas fa-truck fa-2x text-success mb-3"></i><h5>Fast Delivery</h5></div></div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer id="kontak" class="footer">
        <div class="container">
            <div class="row text-center text-md-start g-4">
                <div class="col-md-3"><h5>FreshJuice</h5><p class="small text-muted">Solusi hidup sehat setiap hari.</p></div>
                <div class="col-md-3"><h6>Opening Hours</h6><p class="small text-muted mb-0">Senin-Jumat: 09:00 - 18:00</p></div>
                <div class="col-md-3"><h6>Contact Us</h6><p class="small text-muted mb-0">Jakarta, Indonesia<br>+62 812 3456 7890</p></div>
                <div class="col-md-3"><h6>Subscribe</h6><input type="text" class="form-control" placeholder="Email Anda..."></div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>