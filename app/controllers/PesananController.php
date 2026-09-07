<?php
/**
 * Class PesananController
 * Mengatur manajemen reservasi dan verifikasi pembayaran oleh Admin
 */
class PesananController {
    private $db;

    public function __construct($db) {
        // Proteksi Akses: Hanya Admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BASEURL . "/auth/login");
            exit;
        }
        $this->db = $db;
    }

    /**
     * Menampilkan semua daftar pesanan masuk
     */
    public function index() {
        // Ambil semua pesanan dikombinasikan dengan nama pelanggan (tabel users)
        $query = "SELECT p.*, u.nama FROM pesanan p 
                  JOIN users u ON p.user_id = u.id 
                  ORDER BY p.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $daftar_pesanan = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/admin/pesanan.php';
    }

    /**
     * Mengubah status pesanan secara dinamis
     */
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pesanan_id = $_POST['pesanan_id'];
            $status_baru = $_POST['status_pesanan'];

            $query = "UPDATE pesanan SET status_pesanan = :status_baru WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status_baru', $status_baru);
            $stmt->bindParam(':id', $pesanan_id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Status pesanan #DC-{$pesanan_id} berhasil diperbarui menjadi {$status_baru}!"; 
            } else {
                $_SESSION['error'] = "Gagal memperbarui status pesanan.";
            }
        }
        header("Location: " . BASEURL . "/pesanan");
        exit;
    }

    /**
     * Menampilkan form pilih rentang tanggal sebelum cetak laporan
     */
    public function filterLaporan() {
        require_once __DIR__ . '/../views/admin/filter_laporan.php';
    }

    /**
     * Menampilkan Halaman Laporan Finansial Ramah Cetak (Print-Friendly)
     * Query difilter berdasarkan parameter GET tgl_mulai & tgl_selesai.
     * Jika parameter tidak ada, redirect ke halaman filter.
     */
    public function cetakLaporan() {
        // ── Validasi & sanitasi parameter tanggal ────────────────────────
        $tgl_mulai   = isset($_GET['tgl_mulai'])   ? trim($_GET['tgl_mulai'])   : '';
        $tgl_selesai = isset($_GET['tgl_selesai']) ? trim($_GET['tgl_selesai']) : '';

        // Jika salah satu tidak ada, arahkan ke form filter
        if (empty($tgl_mulai) || empty($tgl_selesai)) {
            header("Location: " . BASEURL . "/pesanan/filterLaporan");
            exit;
        }

        // Validasi format tanggal (Y-m-d)
        $fmt = 'Y-m-d';
        $d1  = DateTime::createFromFormat($fmt, $tgl_mulai);
        $d2  = DateTime::createFromFormat($fmt, $tgl_selesai);

        if (!$d1 || !$d2 || $d1->format($fmt) !== $tgl_mulai || $d2->format($fmt) !== $tgl_selesai) {
            header("Location: " . BASEURL . "/pesanan/filterLaporan");
            exit;
        }

        // Pastikan tgl_mulai ≤ tgl_selesai
        if ($tgl_mulai > $tgl_selesai) {
            // Tukar supaya tetap logis
            [$tgl_mulai, $tgl_selesai] = [$tgl_selesai, $tgl_mulai];
        }

        // ── Label periode untuk tampilan & nama file ─────────────────────
        if ($tgl_mulai === $tgl_selesai) {
            $label_periode      = date('d F Y', strtotime($tgl_mulai));
            $label_periode_file = date('d-m-Y', strtotime($tgl_mulai));
        } else {
            $label_periode      = date('d F Y', strtotime($tgl_mulai))
                                  . ' s/d '
                                  . date('d F Y', strtotime($tgl_selesai));
            $label_periode_file = date('d-m-Y', strtotime($tgl_mulai))
                                  . '_sd_'
                                  . date('d-m-Y', strtotime($tgl_selesai));
        }

        // ── 1. Omzet & jumlah pesanan SELESAI dalam periode ──────────────
        $queryOmzet = "SELECT SUM(total_harga) AS omzet, COUNT(*) AS total_sukses
                       FROM pesanan
                       WHERE status_pesanan = 'Selesai'
                         AND DATE(tanggal_pengambilan) BETWEEN :tgl_mulai AND :tgl_selesai";
        $stmtOmzet = $this->db->prepare($queryOmzet);
        $stmtOmzet->bindParam(':tgl_mulai',   $tgl_mulai);
        $stmtOmzet->bindParam(':tgl_selesai', $tgl_selesai);
        $stmtOmzet->execute();
        $stat = $stmtOmzet->fetch(PDO::FETCH_ASSOC);

        // ── 2. Statistik pending & batal dalam periode ───────────────────
        $queryStat = "SELECT
                        COUNT(CASE WHEN status_pesanan = 'Batal' THEN 1 END) AS total_batal,
                        COUNT(CASE WHEN status_pesanan IN ('Diproses', 'Siap Diambil', 'Menunggu Pembayaran')
                                   THEN 1 END) AS total_pending
                      FROM pesanan
                      WHERE DATE(tanggal_pengambilan) BETWEEN :tgl_mulai AND :tgl_selesai";
        $stmtStat = $this->db->prepare($queryStat);
        $stmtStat->bindParam(':tgl_mulai',   $tgl_mulai);
        $stmtStat->bindParam(':tgl_selesai', $tgl_selesai);
        $stmtStat->execute();
        $statTambahan = $stmtStat->fetch(PDO::FETCH_ASSOC);

        // ── 3. Detail semua pesanan dalam periode ─────────────────────────
        $queryLaporan = "SELECT p.*, u.nama
                         FROM pesanan p
                         JOIN users u ON p.user_id = u.id
                         WHERE DATE(p.tanggal_pengambilan) BETWEEN :tgl_mulai AND :tgl_selesai
                         ORDER BY p.tanggal_pengambilan ASC, p.jam_pengambilan ASC";
        $stmtLaporan = $this->db->prepare($queryLaporan);
        $stmtLaporan->bindParam(':tgl_mulai',   $tgl_mulai);
        $stmtLaporan->bindParam(':tgl_selesai', $tgl_selesai);
        $stmtLaporan->execute();
        $laporan_data = $stmtLaporan->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/admin/cetak_laporan.php';
    }
}