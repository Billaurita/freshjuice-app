<?php

require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    
    public function index() {
        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();
        
        require_once __DIR__ . '/../views/user/home.php';
    }

    public function detail($id) {
        $productModel = new ProductModel();
        $product = $productModel->getProductById($id);
        
        if ($product) {
            require_once __DIR__ . '/../views/user/detail.php';
        } else {
            echo "<h1>Produk tidak ditemukan!</h1><a href='index.php?action=home'>Kembali ke Beranda</a>";
        }
    }

    public function deleteProduct() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $productModel = new ProductModel();
            $productModel->deleteProduct($id);
            // Setelah hapus, arahkan kembali ke daftar produk admin
            header("Location: index.php?action=admin_products");
            exit;
        }
    }
}
?>