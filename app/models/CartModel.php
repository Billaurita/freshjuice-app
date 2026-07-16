<?php
require_once __DIR__ . '/../config/database.php';

class CartModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function addToCart($user_id, $product_id, $quantity) {
        $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $product_id, $quantity]);
    }

    public function getCartByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT cart.*, products.name, products.price, products.image 
                                      FROM cart JOIN products ON cart.product_id = products.id 
                                      WHERE cart.user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearCart($user_id) {
        $query = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($query); 
        $stmt->execute([$user_id]);
    }
}