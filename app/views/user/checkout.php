<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .navbar-brand { color: #f39c12 !important; font-weight: 800; font-size: 1.5rem; }
        .navbar-brand span { color: #28a745; }
        .card { border-radius: 15px; border: none; }
        .btn-success { background-color: #28a745; }
        .footer { background-color: #fff; border-top: 2px solid #a8d5ba; padding: 50px 0; margin-top: 50px; }
    </style>
</head>
<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm mb-5">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.php?action=home"><i class="fas fa-lemon text-warning"></i> Fresh<span>Juice</span></a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <a href="index.php?action=cart" class="text-decoration-none me-4 position-relative text-dark">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <?php if(($_SESSION['cart_count'] ?? 0) > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;"><?= $_SESSION['cart_count'] ?></span>
                        <?php endif; ?>
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

    <!-- content  -->
    <div class="container my-5">
        <h2 class="fw-bold mb-4">Checkout</h2>
        <form action="index.php?action=process_checkout" method="POST">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h5 class="mb-3">Informasi Pengiriman & Pembayaran</h5>
                        
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="address" class="form-control mb-3" rows="2" placeholder="Masukkan alamat lengkap..." required></textarea>
                        
                        <label class="form-label">Kota Tujuan</label>
                        <input type="text" name="city" class="form-control mb-3" value="Jakarta" readonly>
                        
                        <label class="form-label">Metode Pengiriman</label>
                        <select name="shipping_service" id="shipping" class="form-select mb-3" onchange="updateTotal()">
                            <option value="cod">Bayar di Tempat (COD) - Rp 0</option>
                            <option value="diantar_penjual">Diantar oleh Penjual - Rp 5.000</option>
                        </select>

                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select">
                            <option value="qris">QRIS</option>
                            <option value="cash">Tunai (Cash)</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h5 class="mb-3">Pesanan Anda</h5>
                        <hr>
                        <?php if (!empty($items)): foreach ($items as $item): ?>
                            <div class="d-flex align-items-center mb-3">
                                <img src="public/images/<?= htmlspecialchars($item['image']) ?>" width="50" class="rounded me-3" onerror="this.src='https://via.placeholder.com/50?text=Jus'">
                                <div class="d-flex justify-content-between flex-grow-1">
                                    <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</span>
                                    <span>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Total Harga:</p>
                            <p class="fw-bold fs-5 mb-0 text-success" id="total-display">Rp <?= number_format($total_harga, 0, ',', '.') ?></p>
                        </div>
                        <input type="hidden" name="total" id="total-input" value="<?= $total_harga ?>">
                        
                        
                        <?php if (empty($items) || $total_harga <= 0): ?>
                            <button type="button" class="btn btn-secondary w-100 mt-4 py-2 fw-bold" disabled>Keranjang Masih Kosong</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success w-100 mt-4 py-2 fw-bold">Lanjutkan Pembayaran</button>
                        <?php endif; ?>
                        

                    </div>
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
        function updateTotal() {
            const subtotal = <?= $total_harga ?>;
            const shipping = document.getElementById('shipping').value;
            const ongkir = (shipping === 'diantar_penjual') ? 5000 : 0;
            const total = subtotal + ongkir;
            document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total-input').value = total;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>