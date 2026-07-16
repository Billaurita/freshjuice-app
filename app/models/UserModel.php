<?php
require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($data) {
        $sql = "INSERT INTO users (name, email, password, phone, address, role) VALUES (?, ?, ?, ?, ?, 'user')";
        return $this->conn->prepare($sql)->execute([
            $data['name'], $data['email'], $data['password'], $data['phone'], $data['address']
        ]);
    }
}