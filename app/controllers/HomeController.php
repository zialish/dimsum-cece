<?php
/**
 * Class HomeController
 * Menampilkan halaman utama dan katalog produk untuk pelanggan
 */
class HomeController {
    private $produkModel;

    public function __construct($db) {
        require_once __DIR__ . '/../models/ProdukModel.php';
        $this->produkModel = new ProdukModel($db);
    }

    /**
     * Menampilkan katalog produk Fruitables
     */
    public function index() {
        // Ambil semua produk yang ada di database untuk ditampilkan ke pelanggan
          $cari = isset($_GET['cari']) ? $_GET['cari'] : '';

    $produk = $this->produkModel->getAll();

    if (!empty($cari)) {

        $produk = array_filter($produk, function ($item) use ($cari) {

            return stripos(
                $item['nama_produk'],
                $cari
            ) !== false;

        });

    }

    require_once __DIR__ .
    '/../views/customer/home.php';

}
    /**
     * Menambahkan produk ke dalam keranjang belanja (Session)
     */
    public function tambahKeranjang() {
        $id = $_GET['id'];

$produk =
$this->produkModel->getById($id);

if($produk['tersedia'] == 0){

    $_SESSION['error'] =
    "Produk sedang tidak tersedia";

    header(
        "Location: " .
        BASEURL .
        "/home"
    );

    exit;
}
        // Ambil ID produk dari parameter URL (misal: /home/tambahKeranjang?id=5)
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            // Ambil data produk berdasarkan ID dari database untuk memastikan produk ada
            // (Untuk sementara kita asumsikan produk ada, atau idealnya buat method findById di ProdukModel)
            
            // Jika keranjang belum ada di session, buat array baru
            if (!isset($_SESSION['keranjang'])) {
                $_SESSION['keranjang'] = [];
            }

            // Jika produk sudah ada di keranjang, tambahkan jumlahnya (quantity)
            if (isset($_SESSION['keranjang'][$id])) {
                $_SESSION['keranjang'][$id]++;
            } else {
                // Jika belum ada, masukkan produk baru dengan jumlah 1
                $_SESSION['keranjang'][$id] = 1;
            }

            $_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang!";
        }

        // Kembalikan ke halaman katalog utama
        header("Location: " . BASEURL . "/home");
        exit;
    }

    /**
     * Menampilkan Halaman Detail Keranjang Belanja
     */
    public function keranjang() {
        $items = [];
        $total_harga = 0;

        // Jika ada produk di dalam session keranjang
        if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
            // Kita butuh ProdukModel untuk mengambil detail nama, harga, dan foto produk
            // Kita buat query custom di controller ini atau idealnya memanggil model
            foreach ($_SESSION['keranjang'] as $produk_id => $jumlah) {
                // Ambil detail produk langsung dari database berdasarkan ID
                $query = "SELECT p.*, k.nama_kategori FROM produk p 
                          LEFT JOIN kategori k ON p.kategori_id = k.id 
                          WHERE p.id = :id LIMIT 1";
                $stmt = $this->produkModel->getAll(); // Menggunakan instance koneksi yang ada
                
                // Demi kemudahan arsitektur native, kita lakukan query detail via PDO instan di model/controller
                $db = (new Database())->getConnection();
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $produk_id, PDO::PARAM_INT);
                $stmt->execute();
                $produk = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($produk) {
                    $subtotal = $produk['harga'] * $jumlah;
                    $total_harga += $subtotal;
                    
                    // Bungkus data untuk dikirim ke View
                    $items[] = [
                        'id'          => $produk['id'],
                        'nama_produk' => $produk['nama_produk'],
                        'harga'       => $produk['harga'],
                        'foto'        => $produk['foto'],
                        'ukuran'      => $produk['ukuran'],
                        'stok'        => $produk['stok'],
                        'jumlah'      => $jumlah,
                        'subtotal'    => $subtotal
                    ];
                }
            }
        }

        // Kirim data ke View keranjang pelanggan
        require_once __DIR__ . '/../views/customer/keranjang.php';
    }

    /**
     * Menghapus item dari keranjang belanja
     */
    public function hapusKeranjang() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id && isset($_SESSION['keranjang'][$id])) {
            unset($_SESSION['keranjang'][$id]);
            $_SESSION['success'] = "Produk berhasil dihapus dari keranjang.";
        }

        header("Location: " . BASEURL . "/home/keranjang");
        exit;
    }

    /**
     * Mengubah jumlah item di keranjang (tambah / kurang)
     * GET ?id=X&aksi=tambah|kurang
     */
    public function ubahJumlahKeranjang() {
        $id   = isset($_GET['id'])   ? (int)$_GET['id']   : 0;
        $aksi = isset($_GET['aksi']) ? $_GET['aksi']       : '';

        if ($id && isset($_SESSION['keranjang'][$id])) {
            if ($aksi === 'tambah') {
                // Cek stok dari database sebelum menambah
                $produk = $this->produkModel->getById($id);
                if ($produk && $_SESSION['keranjang'][$id] < (int)$produk['stok']) {
                    $_SESSION['keranjang'][$id]++;
                } else {
                    $_SESSION['error'] = "Stok tidak mencukupi.";
                }
            } elseif ($aksi === 'kurang') {
                $_SESSION['keranjang'][$id]--;
                // Jika jumlah sudah 0 atau kurang, hapus item
                if ($_SESSION['keranjang'][$id] <= 0) {
                    unset($_SESSION['keranjang'][$id]);
                }
            }
        }

        header("Location: " . BASEURL . "/home/keranjang");
        exit;
    }

    /**
     * Menampilkan Halaman Formulir Checkout
     */
    public function checkout() {
        // Proteksi: Pastikan pelanggan sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }

        if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        $items = [];
        $total_harga = 0;
        $db = (new Database())->getConnection();

        // Ambil data produk untuk menampilkan ringkasan belanja di halaman checkout
        foreach ($_SESSION['keranjang'] as $produk_id => $jumlah) {
            $query = "SELECT * FROM produk WHERE id = :id LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $produk_id, PDO::PARAM_INT);
            $stmt->execute();
            $produk = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produk) {
                $subtotal = $produk['harga'] * $jumlah;
                $total_harga += $subtotal;
                $items[] = [
                    'nama_produk' => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal
                ];
            }
        }

        require_once __DIR__ . '/../views/customer/checkout.php';
    }

    /**
     * Memproses Penyimpanan Pesanan ke Database + Validasi Double Booking
     */
    public function prosesCheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $tanggal_pengambilan = $_POST['tanggal_pengambilan'];
            $jam_pengambilan = $_POST['jam_pengambilan'];
            $catatan = $_POST['catatan'] ?? '';
            $fasilitas_tambahan = $_POST['fasilitas_tambahan'] ?? '';
            $total_harga = $_POST['total_harga'];

            $db = (new Database())->getConnection();

            try {
                // =======================================================
                // VALIDASI DOUBLE BOOKING (TAHAP 4)
                // =======================================================
                // Hitung jumlah pesanan pada tanggal dan jam pengambilan yang sama
                // Toleransi waktu: Kita cek jam yang sama persis (format H:i)
                $queryCekSlot = "SELECT COUNT(*) AS total_slot FROM pesanan 
                                 WHERE tanggal_pengambilan = :tgl 
                                 AND DATE_FORMAT(jam_pengambilan, '%H:%i') = DATE_FORMAT(:jam, '%H:%i')
                                 AND status_pesanan != 'Batal'";
                
                $stmtCek = $db->prepare($queryCekSlot);
                $stmtCek->bindParam(':tgl', $tanggal_pengambilan);
                $stmtCek->bindParam(':jam', $jam_pengambilan);
                $stmtCek->execute();
                $resultCek = $stmtCek->fetch(PDO::FETCH_ASSOC);

                // Batasan: Misal maksimal 3 pesanan per slot jam yang sama
                $maksimal_slot = 3; 

                if ($resultCek['total_slot'] >= $maksimal_slot) {
                    $_SESSION['error'] = "Maaf, slot waktu pengambilan pada pukul " . substr($jam_pengambilan, 0, 5) . " sudah penuh (Maksimal " . $maksimal_slot . " pesanan). Silakan pilih jam atau tanggal pengambilan lainnya.";
                    header("Location: " . BASEURL . "/home/checkout");
                    exit;
                }
                // =======================================================

                // Mulai Database Transaction jika lolos validasi slot
                $db->beginTransaction();

                // 1. Simpan ke tabel pesanan
                $queryPesanan = "INSERT INTO pesanan (user_id, tanggal_pengambilan, jam_pengambilan, catatan, fasilitas_tambahan, total_harga, status_pesanan) 
                                 VALUES (:user_id, :tanggal_pengambilan, :jam_pengambilan, :catatan, :fasilitas_tambahan, :total_harga, 'Menunggu Pembayaran')";
                
                $stmtPesanan = $db->prepare($queryPesanan);
                $stmtPesanan->bindParam(':user_id', $user_id);
                $stmtPesanan->bindParam(':tanggal_pengambilan', $tanggal_pengambilan);
                $stmtPesanan->bindParam(':jam_pengambilan', $jam_pengambilan);
                $stmtPesanan->bindParam(':catatan', $catatan);
                $stmtPesanan->bindParam(':fasilitas_tambahan', $fasilitas_tambahan);
                $stmtPesanan->bindParam(':total_harga', $total_harga);
                $stmtPesanan->execute();

                $pesanan_id = $db->lastInsertId();

                // 2. Simpan setiap item ke tabel detail_pesanan
                foreach ($_SESSION['keranjang'] as $produk_id => $jumlah) {
                    $queryProduk = "SELECT harga FROM produk WHERE id = :id LIMIT 1";
                    $stmtProduk = $db->prepare($queryProduk);
                    $stmtProduk->bindParam(':id', $produk_id);
                    $stmtProduk->execute();
                    $prod = $stmtProduk->fetch(PDO::FETCH_ASSOC);

                    $harga_satuan = $prod['harga'];

                    $queryDetail = "INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga_satuan) 
                                    VALUES (:pesanan_id, :produk_id, :jumlah, :harga_satuan)";
                    $stmtDetail = $db->prepare($queryDetail);
                    $stmtDetail->bindParam(':pesanan_id', $pesanan_id);
                    $stmtDetail->bindParam(':produk_id', $produk_id);
                    $stmtDetail->bindParam(':jumlah', $jumlah);
                    $stmtDetail->bindParam(':harga_satuan', $harga_satuan);
                    $stmtDetail->execute();
                }

                $db->commit();
                unset($_SESSION['keranjang']);

                $_SESSION['success_pesan'] = "Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.";
                header("Location: " . BASEURL . "/home/riwayat");
                exit;

            } catch (Exception $e) {
                $db->rollBack();
                $_SESSION['error'] = "Terjadi kesalahan saat memproses pesanan: " . $e->getMessage();
                header("Location: " . BASEURL . "/home/checkout");
                exit;
            }
        }
    }

    /**
     * Menampilkan Halaman Riwayat Pesanan Pelanggan (Fruitables Style)
     */
    public function riwayat() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $db = (new Database())->getConnection();

        // Ambil semua data pesanan milik pelanggan ini, urutkan dari yang terbaru
        $query = "SELECT * FROM pesanan WHERE user_id = :user_id ORDER BY id DESC";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $daftar_pesanan = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kirim data ke file view riwayat
        require_once __DIR__ . '/../views/customer/riwayat.php';
    }

    /**
     * Proses Upload Bukti Pembayaran dari Pelanggan
     */
    public function uploadPembayaran() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pesanan_id = $_POST['pesanan_id'];
            
            // Logika upload file bukti transfer
            if (isset($_FILES['bukti_pembayaran']['name']) && $_FILES['bukti_pembayaran']['name'] != '') {
                $ext = pathinfo($_FILES['bukti_pembayaran']['name'], PATHINFO_EXTENSION);
                $file_name = 'bukti_' . $pesanan_id . '_' . time() . '.' . $ext;
                $target = __DIR__ . '/../../public/uploads/' . $file_name;
                
                if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target)) {
                    $db = (new Database())->getConnection();
                    
                    // 1. Simpan data ke tabel pembayaran
                    $queryBayar = "INSERT INTO pembayaran (pesanan_id, bukti_pembayaran, status_pembayaran) 
                                   VALUES (:pesanan_id, :bukti_pembayaran, 'DP')";
                    $stmtBayar = $db->prepare($queryBayar);
                    $stmtBayar->bindParam(':pesanan_id', $pesanan_id);
                    $stmtBayar->bindParam(':bukti_pembayaran', $file_name);
                    $stmtBayar->execute();

                    // 2. Update status di tabel pesanan menjadi 'Diproses' karena sudah bayar/upload bukti
                    $queryUpdatePesanan = "UPDATE pesanan SET status_pesanan = 'Diproses' WHERE id = :pesanan_id";
                    $stmtUpdate = $db->prepare($queryUpdatePesanan);
                    $stmtUpdate->bindParam(':pesanan_id', $pesanan_id);
                    $stmtUpdate->execute();

                    $_SESSION['success'] = "Bukti pembayaran berhasil diunggah! Pesanan Anda kini sedang diproses Admin.";
                } else {
                    $_SESSION['error'] = "Gagal mengunggah file gambar.";
                }
            }
        }
        header("Location: " . BASEURL . "/home/riwayat");
        exit;
    }

    /**
     * Menampilkan Halaman Profil UMKM untuk Pelanggan (data statis)
     */
    public function profil() {
        require_once __DIR__ . '/../views/customer/profil.php';
    }
}