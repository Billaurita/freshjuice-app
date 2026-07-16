<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .navbar-brand { color: #f39c12 !important; font-weight: 800; font-size: 1.5rem; }
        .navbar-brand span { color: #28a745; }
        .footer { background-color: #fff; border-top: 2px solid #a8d5ba; padding: 50px 0; margin-top: 50px; }
        .card { border-radius: 15px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php?action=home"><i class="fas fa-lemon text-warning"></i> Fresh<span>Juice</span></a>
            
            <div class="d-flex align-items-center">
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
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="fw-bold mb-4">Shopping Cart</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 p-3">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($items)): foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <img src="public/images/<?= htmlspecialchars($item['image']) ?>" width="60" class="rounded me-2">
                                    <?= htmlspecialchars($item['name']) ?>
                                </td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="index.php?action=delete_cart&id=<?= $item['id'] ?>" class="text-danger" onclick="return confirm('Hapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-center">Keranjang masih kosong.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card p-4 shadow-sm border-0">
                    <h5 class="fw-bold">Order Summary</h5>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span> 
                        <strong class="text-success">Rp <?= number_format($total ?? 0, 0, ',', '.') ?></strong>
                    </div>
                    <a href="index.php?action=checkout" class="btn btn-success w-100 fw-bold py-2 text-decoration-none">Proceed to Checkout</a>
                    <a href="index.php?action=home" class="btn btn-outline-secondary w-100 mt-2">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer id="kontak" class="footer">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-3"><h5>FreshJuice</h5><p class="small text-muted">Solusi hidup sehat setiap hari.</p></div>
                <div class="col-md-3"><h6>Opening Hours</h6><p class="small text-muted">Senin-Jumat: 09:00 - 18:00</p></div>
                <div class="col-md-3"><h6>Contact Us</h6><p class="small text-muted">Jakarta, Indonesia<br>+62 812 3456 7890</p></div>
                <div class="col-md-3"><h6>Subscribe</h6><input type="text" class="form-control" placeholder="Email Anda..."></div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>