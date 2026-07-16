<?php
// Pastikan path ini benar sesuai struktur folder kamu
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CartModel.php';

class CheckoutController {
    public function index() {
        $items = (new CartModel())->getCartByUserId($_SESSION['user_id']);
        $total_harga = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
        require_once __DIR__ . '/../views/user/checkout.php';
    }

    public function process() {
        $orderModel = new OrderModel();
        // Simpan data order
        $orderId = $orderModel->createOrder($_SESSION['user_id'], $_POST['total'], $_POST['city'], $_POST['shipping_service'], $_POST['payment_method'], $_POST['address']);
        
        $items = (new CartModel())->getCartByUserId($_SESSION['user_id']);
        foreach ($items as $item) {
            $orderModel->createOrderItem($orderId, $item['name'], $item['quantity'], $item['price']);
        }
        
        //clear cart
        (new CartModel())->clearCart($_SESSION['user_id']);

        //menyimpan ID pesanan ke session agar bisa ditampilkan di halaman sukses
        $_SESSION['last_order_id'] = $orderId;

        //Redirect ke halaman sukses
        header('Location: index.php?action=order_success');
        exit;
    }

    public function orderSuccess() {
        //mengambil data untuk ditampilkan di view order_success
        $orderId = $_SESSION['last_order_id'] ?? null;
        if (!$orderId) { header('Location: index.php?action=home'); exit; }
        
        $db = (new Database())->getConnection();
        $order = $db->query("SELECT * FROM orders WHERE id = $orderId")->fetch();
        $items = $db->query("SELECT * FROM order_items WHERE order_id = $orderId")->fetchAll();
        
        require_once __DIR__ . '/../views/user/order_success.php';
    }

    //track record
    public function trackOrder($id = null) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        $db = (new Database())->getConnection();
        $userId = $_SESSION['user_id'];
        $order = null;
        
        if ($id) {
            $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $userId]);
            $order = $stmt->fetch();
        } else {
            $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([$userId]);
            $order = $stmt->fetch();
        }
        
        if (!$order) {
            echo "<script>alert('Kamu belum memiliki pesanan.'); window.location='index.php?action=home';</script>";
            exit;
        }
        
        $stmtItems = $db->prepare("
            SELECT oi.*, p.image 
            FROM order_items oi 
            LEFT JOIN products p ON oi.product_name = p.name 
            WHERE oi.order_id = ?
        ");
        $stmtItems->execute([$order['id']]);
        $items = $stmtItems->fetchAll();
        
        require_once __DIR__ . '/../views/user/track_order.php';
    }
}