<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class AdminController {
    public function dashboard() {
        $db = (new Database())->getConnection();

        //untuk perhitungan
        $totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $totalOrders = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();

        //untuk pencatatan
        $orders = $db->query("
            SELECT o.*, u.name as customer_name 
            FROM orders o 
            LEFT JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ")->fetchAll();

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("UPDATE orders SET status = ? WHERE id = ?");
            $stmt->execute([$_POST['status'], $_POST['order_id']]);
            
            header('Location: index.php?action=admin_dashboard');
            exit;
        }
    }

    //CRUD untuk Produk

    public function products() {
        $db = (new Database())->getConnection();
        $products = $db->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
        require_once __DIR__ . '/../views/admin/products.php';
    }

    public function addProduct() {
        require_once __DIR__ . '/../views/admin/product_add.php';
    }

    public function storeProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $image = 'default.png';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/images/'; 
                $fileName = time() . '_' . basename($_FILES['image']['name']); 
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $image = $fileName;
                }
            }

            $db = (new Database())->getConnection();
            $stmt = $db->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $price, $description, $image]);

            header('Location: index.php?action=admin_products');
            exit;
        }
    }

    //Form edit produk
    public function editProduct($id) {
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        
        if (!$product) {
            header('Location: index.php?action=admin_products');
            exit;
        }
        require_once __DIR__ . '/../views/admin/product_edit.php';
    }

    public function deleteProduct($id) {
        if ($id) {
            // Memanggil ProductModel
            require_once __DIR__ . '/../models/ProductModel.php';
            $productModel = new ProductModel();
            
            // Menjalankan fungsi hapus di model
            $isDeleted = $productModel->deleteProductById($id);
            
            if ($isDeleted) {
                echo "<script>
                        alert('Produk berhasil dihapus!');
                        window.location.href = 'index.php?action=admin_products';
                    </script>";
                exit;
            }
        }
        
        // Jika ID tidak ditemukan atau gagal hapus
        echo "<script>
                alert('Gagal menghapus produk.');
                window.location.href = 'index.php?action=admin_products';
            </script>";
        exit;
    }

    //proses data update
    public function updateProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            
            $db = (new Database())->getConnection();
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/images/';
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $stmt = $db->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
                    $stmt->execute([$name, $price, $description, $fileName, $id]);
                }
            } else {
                $stmt = $db->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
                $stmt->execute([$name, $price, $description, $id]);
            }
            
            header('Location: index.php?action=admin_products');
            exit;
        }
    }

    //pencatatan (produk terjual)
    public function records() {
        $db = (new Database())->getConnection();

        // menghitung total produk yang terjual secara keseluruhan
        $totalSold = $db->query("SELECT SUM(quantity) FROM order_items")->fetchColumn();

        // menghitung jumlah produk yang terjual per item
        $productStats = $db->query("
            SELECT product_name, SUM(quantity) as total_qty, SUM(quantity * price) as total_revenue
            FROM order_items
            GROUP BY product_name
            ORDER BY total_qty DESC
        ")->fetchAll();

        require_once __DIR__ . '/../views/admin/records.php';
    }

    // TOTAL PENJUALAN --- //
    public function sales() {
        $db = (new Database())->getConnection();

        $totalRevenue = $db->query("SELECT SUM(total_price) FROM orders")->fetchColumn() ?? 0;
        $totalOrders = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn() ?? 0;
        $avgTransaction = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        //  Data Donut Chart 
        $topProducts = $db->query("
            SELECT product_name, SUM(quantity) as total_qty 
            FROM order_items 
            GROUP BY product_name 
            ORDER BY total_qty DESC 
            LIMIT 4
        ")->fetchAll();

        $donutLabels = [];
        $donutData = [];
        foreach($topProducts as $tp) {
            $donutLabels[] = $tp['product_name'];
            $donutData[] = $tp['total_qty'];
        }

        // Bar Chart
        $salesTrend = $db->query("
            SELECT DATE(created_at) as order_date, SUM(total_price) as daily_revenue 
            FROM orders 
            GROUP BY DATE(created_at) 
            ORDER BY order_date ASC 
            LIMIT 6
        ")->fetchAll();

        $barLabels = [];
        $barData = [];
        foreach($salesTrend as $st) {
            $barLabels[] = date('d M', strtotime($st['order_date']));
            $barData[] = $st['daily_revenue'];
        }

        require_once __DIR__ . '/../views/admin/sales.php';
    }
}