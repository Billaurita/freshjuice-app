<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/CheckoutController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'login': (new AuthController())->login(); break;
    case 'process_login': (new AuthController())->processLogin(); break;
    case 'register': (new AuthController())->register(); break;
    case 'process_register': (new AuthController())->processRegister(); break;
    case 'logout': (new AuthController())->logout(); break;
    case 'home': (new ProductController())->index(); break;
    case 'detail': (new ProductController())->detail($_GET['id']); break;
    case 'add_to_cart': (new CartController())->add(); break;
    case 'cart': (new CartController())->index(); break;
    case 'checkout': (new CartController())->checkout(); break;
    case 'process_checkout': (new CheckoutController())->process(); break;
    case 'order_success': (new CheckoutController())->orderSuccess(); break;
    case 'track_order': $id = isset($_GET['id']) ? $_GET['id'] : null; (new CheckoutController())->trackOrder($id); break;
    case 'delete_cart': (new CartController())->delete(); break;
    case 'admin_dashboard': (new AdminController())->dashboard(); break;
    case 'admin_update_status': (new AdminController())->updateOrderStatus(); break;
    case 'admin_products': (new AdminController())->products(); break;
    case 'admin_product_add': (new AdminController())->addProduct(); break;
    case 'admin_product_store': (new AdminController())->storeProduct(); break;
    case 'admin_product_edit': $id = $_GET['id'] ?? null; (new AdminController())->editProduct($id); break;
    case 'admin_product_update': $id = $_GET['id'] ?? null; (new AdminController())->updateProduct($id); break;
    case 'admin_product_delete': $id = $_GET['id'] ?? null; (new AdminController())->deleteProduct($id); break;
    case 'admin_records': (new AdminController())->records(); break;
    case 'admin_sales': (new AdminController())->sales(); break;
    default: echo "<h1>404 - Halaman Tidak Ditemukan</h1>"; break;
}