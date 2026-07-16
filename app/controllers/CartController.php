<?php
require_once __DIR__ . '/../models/CartModel.php';

class CartController {
    public function add() {
        if (!isset($_SESSION['user_id'])) { header('Location: index.php?action=login'); exit; }
        (new CartModel())->addToCart($_SESSION['user_id'], $_POST['product_id'], $_POST['quantity']);
        header('Location: index.php?action=cart');
    }

    public function index() {
        $items = (new CartModel())->getCartByUserId($_SESSION['user_id']);
        $total = 0;
        foreach ($items as $item) { $total += ($item['price'] * $item['quantity']); }
        require_once __DIR__ . '/../views/user/cart.php';
    }

    public function delete() {
    $cart_id = $_GET['id']; // Mengambil ID dari URL
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$cart_id]);
    header('Location: index.php?action=cart');
    }

    public function checkout() {
        $items = (new CartModel())->getCartByUserId($_SESSION['user_id']);
        
        $total_harga = 0;
        foreach ($items as $item) {
            $total_harga += ($item['price'] * $item['quantity']);
        }
        require_once __DIR__ . '/../views/user/checkout.php';
    }
}