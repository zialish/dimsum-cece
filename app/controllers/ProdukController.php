<?php
/**
 * Class ProdukController
 * Mengatur manajemen produk dan kategori (Khusus Admin)
 */
class ProdukController {
    private $produkModel;
    private $kategoriModel;

    public function __construct($db) {
        // Proteksi: Pastikan hanya Admin yang bisa akses modul ini
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }

        require_once __DIR__ . '/../models/ProdukModel.php';
        require_once __DIR__ . '/../models/KategoriModel.php';
        
        $this->produkModel = new ProdukModel($db);
        $this->kategoriModel = new KategoriModel($db);
    }

    /**
     * Menampilkan daftar produk (halaman utama /produk)
     */
    public function index() {
        $produk   = $this->produkModel->getAll();
        $kategori = $this->kategoriModel->getAll();

        require_once __DIR__ . '/../views/admin/daftar_produk.php';
    }

    /**
     * GET  → tampilkan form tambah produk (/produk/tambah)
     * POST → proses simpan produk baru, redirect ke daftar
     */
    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kategori_id    = $_POST['kategori_id'];
            $nama_produk    = $_POST['nama_produk'];
            $deskripsi      = $_POST['deskripsi'];
            $harga          = $_POST['harga'];
            $stok           = $_POST['stok'];
            $ukuran         = $_POST['ukuran'];
            $is_best_seller = isset($_POST['is_best_seller']) ? 1 : 0;

            // Logika upload foto
            $foto_name = 'default.jpg';
            if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] !== '') {
                $ext       = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto_name = time() . '_' . uniqid() . '.' . $ext;
                $target    = __DIR__ . '/../../public/uploads/' . $foto_name;
                move_uploaded_file($_FILES['foto']['tmp_name'], $target);
            }

            if ($this->produkModel->create($kategori_id, $nama_produk, $deskripsi, $harga, $stok, $ukuran, $foto_name, $is_best_seller)) {
                $_SESSION['success'] = "Produk berhasil ditambahkan!";
                header("Location: " . BASEURL . "/produk");
                exit;
            } else {
                $_SESSION['error'] = "Gagal menambahkan produk.";
                // Jatuh ke bawah → tampilkan ulang form dengan nilai POST
            }
        }

        // GET atau POST gagal → tampilkan form tambah
        $kategori = $this->kategoriModel->getAll();
        require_once __DIR__ . '/../views/admin/tambah_produk.php';
    }
    /**
     * Proses hapus produk berdasarkan ID
     */
    public function hapus() {
        // Mengambil ID dari URL parameter kedua (misal: /produk/hapus/5)
        // Kita akan tangani ekstraksi ID ini di router index.php sebentar lagi
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            if ($this->produkModel->delete($id)) {
                $_SESSION['success'] = "Produk berhasil dihapus!";
            } else {
                $_SESSION['error'] = "Gagal menghapus produk.";
            }
        }
        header("Location: " . BASEURL . "/produk");
        exit;
    }
    public function edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$id) {
            header("Location: " . BASEURL . "/produk");
            exit;
        }

        $produk   = $this->produkModel->getById($id);
        $kategori = $this->kategoriModel->getAll();

        if (!$produk) {
            $_SESSION['error'] = "Produk tidak ditemukan.";
            header("Location: " . BASEURL . "/produk");
            exit;
        }

        require_once __DIR__ . '/../views/admin/edit_produk.php';
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASEURL . "/produk");
            exit;
        }

        $id            = (int)$_POST['id'];
        $nama_produk   = $_POST['nama_produk'];
        $kategori_id   = $_POST['kategori_id'];
        $harga         = $_POST['harga'];
        $stok          = $_POST['stok'];
        $ukuran        = $_POST['ukuran'];
        $deskripsi     = $_POST['deskripsi'];
        $is_best_seller = isset($_POST['is_best_seller']) ? 1 : 0;

        // Ambil data produk lama untuk pertahankan foto jika tidak diganti
        $produk_lama = $this->produkModel->getById($id);
        $foto_name   = $produk_lama['foto'] ?? 'default.jpg';

        // Upload foto baru jika ada
        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] !== '') {
            $ext       = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto_name = time() . '_' . uniqid() . '.' . $ext;
            $target    = __DIR__ . '/../../public/uploads/' . $foto_name;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target);
        }

        if ($this->produkModel->update($id, $nama_produk, $kategori_id, $harga, $stok, $ukuran, $deskripsi, $foto_name, $is_best_seller)) {
            $_SESSION['success'] = "Produk berhasil diperbarui!";
        } else {
            $_SESSION['error'] = "Gagal memperbarui produk.";
        }

        header("Location: " . BASEURL . "/produk");
        exit;
    }

public function toggleStatus(){

    $id = $_GET['id'];

    $this->produkModel->toggleStatus($id);

    header(
        "Location: " .
        BASEURL .
        "/produk"
    );

    exit;
}

}




