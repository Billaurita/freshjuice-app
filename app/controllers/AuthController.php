<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    public function login() { require_once __DIR__ . '/../views/auth/login.php'; }
    public function register() { require_once __DIR__ . '/../views/auth/register.php'; }

    public function processLogin() {
        $user = (new UserModel())->getUserByEmail($_POST['email']);
        if ($user && $_POST['password'] === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name']; 
            
            header('Location: index.php?action=' . ($user['role'] === 'admin' ? 'admin_dashboard' : 'home'));
        } else {
            $error = "Email/Password salah!";
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function processRegister() {
        if ((new UserModel())->registerUser($_POST)) {
            header('Location: index.php?action=login&status=success');
        }
    }

    public function logout() {
    session_start(); 
    session_unset(); 
    session_destroy(); 
    header('Location: index.php?action=login'); 
    exit;
}
}