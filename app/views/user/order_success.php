<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Completed - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; display: flex; flex-direction: column; min-height: 100vh; }
        .card { border-radius: 15px; border: none; }
        .btn-success { background-color: #28a745; }
        .content-wrapper { flex: 1; }
        .footer { background-color: #ffffff; padding: 40px 0; border-top: 1px solid #dee2e6; mt: auto; }
    </style>
</head>
<body>

<div class="content-wrapper container my-5">
    <!-- Status sukses -->
    <div class="text-center mb-5">
        <div class="display-1 text-warning mb-2">✓</div>
        <h2 class="fw-bold">Your order is completed!</h2>
        <p class="text-muted">Thank you. Your Order has been received.</p>
    </div>

    <!-- Card  -->
    <div class="card bg-warning text-dark p-4 rounded-3 mb-4 shadow-sm">
        <div class="row text-center text-md-start align-items-center">
            <div class="col-md-3 mb-3 mb-md-0">
                <span class="d-block small text-muted text-uppercase fw-semibold">Order ID</span>
                <strong class="fs-5">#<?= htmlspecialchars($order['id']) ?></strong>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <span class="d-block small text-muted text-uppercase fw-semibold">Payment Method</span>
                <strong class="fs-5"><?= strtoupper(htmlspecialchars($order['payment_method'])) ?></strong>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <span class="d-block small text-muted text-uppercase fw-semibold">Shipping Service</span>
                <strong class="fs-5"><?= strtoupper(htmlspecialchars($order['shipping_service'])) ?></strong>
            </div>
            <div class="col-md-3 text-md-end">
                <button onclick="window.print()" class="btn btn-dark fw-bold px-4 py-2 rounded-pill">Download Invoice</button>
            </div>
        </div>
    </div>

    <!-- Detail Item yang Dibeli -->
    <div class="card p-4 shadow-sm mb-5">
        <h5 class="fw-bold mb-4">Order Details</h5>
        <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead>
                    <tr class="border-bottom text-muted small">
                        <th>Products</th>
                        <th class="text-end">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr class="border-bottom">
                        <td class="py-3">
                            <span class="fw-semibold d-block"><?= htmlspecialchars($item['product_name']) ?></span>
                            <span class="small text-muted">x<?= $item['quantity'] ?></span>
                        </td>
                        <td class="text-end fw-semibold">
                            Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <tr>
                        <td class="pt-4 text-muted">Shipping</td>
                        <td class="pt-4 text-end fw-semibold">
                            Rp <?= ($order['shipping_service'] === 'diantar_penjual') ? '5.000' : '0' ?>
                        </td>
                    </tr>
                    <tr class="border-top fs-5 fw-bold">
                        <td class="pt-3">Total</td>
                        <td class="pt-3 text-end text-success">
                            Rp <?= number_format($order['total_price'], 0, ',', '.') ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php?action=home" class="btn btn-success fw-bold px-5 py-2 rounded-pill">Back to Home</a>
        </div>
    </div>
</div>


<footer id="kontak" class="footer">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-3">
                <h5>FreshJuice</h5>
                <p class="small text-muted">Solusi hidup sehat setiap hari.</p>
            </div>
            <div class="col-md-3">
                <h6>Opening Hours</h6>
                <p class="small text-muted">Senin-Jumat: 09:00 - 18:00</p>
            </div>
            <div class="col-md-3">
                <h6>Contact Us</h6>
                <p class="small text-muted">Jakarta, Indonesia<br>+62 812 3456 7890</p>
            </div>
            <div class="col-md-3">
                <h6>Subscribe</h6>
                <input type="text" class="form-control" placeholder="Email Anda...">
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>