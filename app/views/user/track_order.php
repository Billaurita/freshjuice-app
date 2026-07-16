<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - FreshJuice</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 12px; }
        
        /* Progress Bar */
        .track-container { position: relative; margin: 40px 0; display: flex; justify-content: space-between; align-items: flex-start; }
        .track-line { position: absolute; top: 20px; left: 5%; width: 90%; height: 4px; background-color: #e9ecef; z-index: 1; }
        .track-progress { position: absolute; top: 20px; left: 5%; height: 4px; background-color: #198754; z-index: 2; transition: width 0.4s ease; }
        
        .track-step { position: relative; z-index: 3; text-align: center; width: 20%; }
        .step-icon { width: 45px; height: 45px; margin: 0 auto 10px; background-color: #fff; border: 3px solid #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #adb5bd; transition: 0.3s; }
        
        /* Status States */
        .track-step.active .step-icon, .track-step.completed .step-icon { border-color: #198754; color: #198754; }
        .track-step.completed .step-icon { background-color: #198754; color: #fff; }
        .track-step p { margin: 0; font-size: 0.85rem; font-weight: 600; color: #495057; }
        .track-step span { font-size: 0.75rem; color: #adb5bd; }

        .product-list-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background-color: #f1f2f6; padding: 5px; }
        .footer { background-color: #fff; border-top: 2px solid #a8d5ba; padding: 50px 0; margin-top: 50px; }
    </style>
</head>
<body>

     <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.php?action=home"><i class="fas fa-lemon text-warning"></i> Fresh<span>Juice</span></a>
            <div class="d-none d-md-flex mx-auto" style="width: 40%;">
                <div class="input-group position-relative">
                    <span class="position-absolute text-muted" style="z-index: 10; margin-top: 7px; margin-left: 15px;"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control search-bar" placeholder="Cari Jus favoritmu..." style="padding-left: 45px;">
                    <button class="btn btn-success" style="border-radius: 0 20px 20px 0; padding: 8px 25px;">Cari</button>
                </div>
            </div>
            
  
            <div class="d-flex align-items-center">
                

                <a href="index.php?action=track_order" class="text-dark fs-4 me-3 icon-history text-decoration-none" title="Lacak Pesanan Saat Ini">
                    <i class="fas fa-clock-rotate-left"></i>
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

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Track Your Order</h2>
            <p class="text-muted small">Home / Track Your Order</p>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-1">Order Status</h5>
            <p class="text-muted small mb-4">Order ID : #<?= htmlspecialchars($order['id'] ?? '') ?></p>

            <?php 
            // menentukan progress bar
            $status_list = ['order_placed', 'accepted', 'in_progress', 'on_the_way', 'delivered'];
            $current_status = $order['status'] ?? 'order_placed';
            $current_index = array_search($current_status, $status_list);
            
            $progress_width = ($current_index / (count($status_list) - 1)) * 100;
            ?>

            <!-- Visualisasi Progress Bar -->
            <div class="track-container">
                <div class="track-line"></div>
                <div class="track-progress" style="width: <?= $progress_width ?>%;"></div>

                <?php 
                $icons = ['fa-clipboard-list', 'fa-check-circle', 'fa-box-open', 'fa-truck', 'fa-house-user'];
                $labels = ['Order Placed', 'Accepted', 'In Progress', 'On the Way', 'Delivered'];

                foreach ($status_list as $index => $status): 
                    $step_class = '';
                    if ($index < $current_index) $step_class = 'completed';
                    if ($index == $current_index) $step_class = 'active';
                ?>
                <div class="track-step <?= $step_class ?>">
                    <div class="step-icon">
                        <?php if($step_class == 'completed'): ?>
                            <i class="fas fa-check"></i>
                        <?php else: ?>
                            <i class="fas <?= $icons[$index] ?>"></i>
                        <?php endif; ?>
                    </div>
                    <p><?= $labels[$index] ?></p>
                    <span><?= isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : '' ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="card shadow-sm p-4">
            <h5 class="fw-bold mb-4">Products</h5>
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <tbody>
                        <?php if(!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                            <tr class="border-bottom">
                                <td style="width: 80px;">
                                    <!-- Foto Produk -->
                                    <img src="public/images/<?= htmlspecialchars($item['image'] ?? 'default.png') ?>" alt="<?= htmlspecialchars($item['product_name'] ?? '') ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background-color: #f1f2f6; padding: 2px;">
                                </td>
                                <td>
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['product_name']) ?></h6>
                                    <span class="text-muted small">Qty: <?= $item['quantity'] ?></span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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