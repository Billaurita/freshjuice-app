<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff; }
        .navbar-brand { color: #f39c12 !important; font-weight: 800; font-size: 1.5rem; }
        .navbar-brand span { color: #28a745; }
        .breadcrumb-custom { font-size: 0.9rem; color: #6c757d; }
        .breadcrumb-custom a { color: #6c757d; text-decoration: none; }
        .breadcrumb-custom a:hover { color: #28a745; }
        
        .main-img-box { background-color: #f8f9fa; border-radius: 15px; padding: 30px; text-align: center; }
        .main-img { max-height: 400px; object-fit: contain; }
        .product-title { font-weight: 800; color: #333; font-size: 2rem; }
        .price { color: #28a745; font-weight: 700; font-size: 1.8rem; }
        
        .qty-box { display: inline-flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        .qty-btn { background: #f8f9fa; border: none; padding: 8px 15px; font-weight: bold; color: #333; cursor: pointer; }
        .qty-input { width: 50px; text-align: center; border: none; font-weight: bold; outline: none; }
        .btn-cart { background-color: #28a745; color: white; border-radius: 8px; font-weight: 600; padding: 12px 20px; border: none; transition: 0.3s; }
        .btn-cart:hover { background-color: #218838; }
        
        .footer { background-color: #fff; border-top: 2px solid #a8d5ba; padding: 50px 0; margin-top: 50px; }

        /* Media Queries untuk Layar Kecil (Mobile) */
        @media (max-width: 768px) {
            .product-title { font-size: 1.75rem; }
            .price { font-size: 1.5rem; }
            .main-img-box { padding: 15px; }
            .main-img { max-height: 250px; }
            .btn-cart { width: 100%; /* Tombol jadi full width di HP */ }
        }
    </style>
</head>
<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.php?action=home">
                <i class="fas fa-lemon text-warning"></i> Fresh<span>Juice</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <a href="index.php?action=cart" class="text-decoration-none me-4 position-relative text-dark">
                        <i class="fas fa-shopping-cart fa-lg"></i>
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

    <!-- content -->
    <div class="container mb-5">
        <div class="breadcrumb-custom mb-4">
            <a href="index.php?action=home">Beranda</a> &gt; <a href="index.php?action=home#produk">Semua Produk</a> &gt; <span class="text-dark fw-medium"><?= htmlspecialchars($product['name']) ?></span>
        </div>

        <form action="index.php?action=add_to_cart" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="row">
                <!-- gambar  -->
                <div class="col-md-6 d-flex mb-4 mb-md-0">
                    <div class="main-img-box flex-grow-1 w-100">
                        <img src="public/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="main-img img-fluid" onerror="this.src='https://via.placeholder.com/400?text=Foto+Jus'">
                    </div>
                </div>

                <!-- Bagian Detail Produk -->
                <div class="col-md-6 ps-md-5">
                    <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
                    <div class="mb-3 text-muted"><i class="fas fa-star text-warning"></i> 4.7 (125 Ulasan)</div>
                    <div class="price mb-4">Rp <?= number_format($product['price'], 0, ',', '.') ?></div>
                    <p class="text-muted mb-4"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Jumlah</h6>
                        <div class="qty-box">
                            <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
                            <input type="text" name="quantity" id="qtyInput" class="qty-input" value="1" readonly>
                            <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                        </div>
                    </div>
                    
                    <!-- Tambah ke keranjang -->
                    <button type="submit" class="btn-cart"><i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang</button>
                </div>
            </div>
        </form>
    </div>

    <!-- FOOTER -->
    <footer id="kontak" class="footer">
        <div class="container">
            <div class="row text-center text-md-start g-4">
                <div class="col-md-3"><h5>FreshJuice</h5><p class="small text-muted mb-0">Solusi hidup sehat setiap hari.</p></div>
                <div class="col-md-3"><h6>Opening Hours</h6><p class="small text-muted mb-0">Senin-Jumat: 09:00 - 18:00</p></div>
                <div class="col-md-3"><h6>Contact Us</h6><p class="small text-muted mb-0">Jakarta, Indonesia<br>+62 812 3456 7890</p></div>
                <div class="col-md-3"><h6>Subscribe</h6><input type="text" class="form-control" placeholder="Email Anda..."></div>
            </div>
        </div>
    </footer>

    <script>
        function updateQty(change) {
            let input = document.getElementById('qtyInput');
            let val = parseInt(input.value) + change;
            if (val >= 1) input.value = val;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>