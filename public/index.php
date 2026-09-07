<?php
/**
 * index.php - Front Controller / Router Utama (Terupdate)
 */

// 1. Load file konfigurasi global
require_once __DIR__ . '/../app/config/Config.php';
require_once __DIR__ . '/../app/config/Database.php';

// 2. Inisialisasi Koneksi Database
$database = new Database();
$db = $database->getConnection();

// 3. Ambil URL dari Parameter
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'auth/login';
$url = explode('/', $url);

// 4. Tentukan Controller berdasarkan URL segment 0
$controllerName = 'AuthController'; // Default controller

if (!empty($url[0])) {
    if (strtolower($url[0]) === 'auth') {
        $controllerName = 'AuthController';
    } 
    elseif (strtolower($url[0]) === 'produk') {
        $controllerName = 'ProdukController';
    }
    elseif (strtolower($url[0]) === 'admin') {
        // Jika ada yang mengakses rute /admin, langsung lempar ke /produk
        header("Location: " . BASEURL . "/produk");
        exit;
    }
    elseif (strtolower($url[0]) === 'home') {
        $controllerName = 'HomeController';
    }
    elseif (strtolower($url[0]) === 'pesanan') {
        $controllerName = 'PesananController';
    }
}

// 5. Tentukan Method (Action) berdasarkan URL segment 1
// JIKA mengakses 'produk', default method-nya adalah 'index'
// 5. Tentukan Method (Action) berdasarkan URL segment 1
if (strtolower($url[0]) === 'produk' || strtolower($url[0]) === 'home' || strtolower($url[0]) === 'pesanan') {
    $methodName = isset($url[1]) && !empty($url[1]) ? $url[1] : 'index';
} else {
    $methodName = isset($url[1]) && !empty($url[1]) ? $url[1] : 'login';
}

// 6. Load file Controller yang sesuai
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Instansiasi Controller
    $controller = new $controllerName($db);
    
    // Cek apakah fungsi ada di dalam controller
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        http_response_code(404);
        echo "404 - Halaman Tidak Ditemukan. (Method " . $methodName . " tidak ada di " . $controllerName . ")";
    }
} else {
    http_response_code(404);
    echo "404 - Controller Tidak Ditemukan. (File " . $controllerName . ".php tidak ada)";
}