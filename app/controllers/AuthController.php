<?php
/**
 * Class AuthController
 * Mengatur alur login, registrasi, dan logout
 */
class AuthController {
    private $userModel;

    public function __construct($db) {
        require_once __DIR__ . '/../models/UserModel.php';
        $this->userModel = new UserModel($db);
    }

    /**
     * Menangani proses Login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByUsername($username);

            // Standar keamanan: password_verify()
            if ($user && password_verify($password, $user['password'])) {
                // Set session management
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['role']     = $user['role']; // admin / pelanggan
                
                // Redirect berdasarkan Role Management
                if ($user['role'] === 'admin') {
                    header("Location: " . BASEURL . "/admin/dashboard");
                } else {
                    header("Location: " . BASEURL . "/home");
                }
                exit;
            } else {
                $_SESSION['error'] = "Username atau password salah!";
            }
        }
        // Tampilkan view login jika bukan POST request
        require_once __DIR__ . '/../views/customer/login.php';
    }

    /**
     * Menangani proses Registrasi Pelanggan
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->register($nama, $username, $email, $password)) {
                $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
                header("Location: " . BASEURL . "/auth/login");
                exit;
            } else {
                $_SESSION['error'] = "Registrasi gagal. Username atau Email mungkin sudah terdaftar.";
            }
        }
        require_once __DIR__ . '/../views/customer/register.php';
    }

    /**
     * Menangani proses Logout
     */
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . BASEURL . "/auth/login");
        exit;
    }
}