<?php
class OrderModel {
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }
    public function createOrder($user_id, $total, $city, $service, $payment, $address) {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_price, shipping_city, shipping_service, payment_method, address, status) VALUES (?,?,?,?,?,?,'pending')");
        $stmt->execute([$user_id, $total, $city, $service, $payment, $address]);
        return $this->db->lastInsertId();
    }
    public function createOrderItem($order_id, $name, $qty, $price) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?,?,?,?)");
        $stmt->execute([$order_id, $name, $qty, $price]);
    }
}