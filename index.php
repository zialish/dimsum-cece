<?php
require_once 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Pelanggan') {
    header("Location: login.php");
    exit;
}

// Mengambil data produk
$stmt = $pdo->query("SELECT * FROM produk WHERE stok > 0");
$products = $stmt->fetchAll();

// Proses Pemesanan Sederhana
if (isset($_POST['pesan'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
    $waktu_pengambilan = $_POST['waktu_pengambilan'];
    $fasilitas_tambahan = $_POST['fasilitas_tambahan'];
    
    // Ambil harga produk
    $st = $pdo->prepare("SELECT harga, stok FROM produk WHERE id = ?");
    $st->execute([$id_produk]);
    $prod = $st->fetch();

    if ($prod && $prod['stok'] >= $jumlah) {
        $total_harga = $prod['harga'] * $jumlah;
        $tanggal_pesanan = date('Y-m-d');

        // Insert ke tabel pesanan
        $ins = $pdo->prepare("INSERT INTO pesanan (id_user, tanggal_pesanan, waktu_pengambilan, fasilitas_tambahan, total_harga) VALUES (?, ?, ?, ?, ?)");
        $ins->execute([$_SESSION['user_id'], $tanggal_pesanan, $waktu_pengambilan, $fasilitas_tambahan, $total_harga]);
        $id_pesanan = $pdo->lastInsertId();

        // Insert ke detail pesanan
        $ins_detail = $pdo->prepare("INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan) VALUES (?, ?, ?, ?)");
        $ins_detail->execute([$id_pesanan, $id_produk, $jumlah, $prod['harga']]);

        // Potong stok produk
        $up_stok = $pdo->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");
        $up_stok->execute([$jumlah, $id_produk]);

        echo "<script>alert('Pesanan berhasil dibuat!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Stok tidak mencukupi!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu - Dimsum Cece</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#">Dimsum Cece</a>
        <span class="navbar-text text-white ms-auto">Halo, <?= htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php" class="text-white text-decoration-none">Logout</a></span>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Menu Dimsum Pilihan</h2>
    <div class="row">
        <?php foreach ($products as $p): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['nama_produk']); ?> <span class="badge bg-secondary"><?= htmlspecialchars($p['ukuran']); ?></span></h5>
                        <p class="text-muted"><?= htmlspecialchars($p['deskripsi']); ?></p>
                        <p class="text-danger fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></p>
                        <p class="small text-secondary">Tersedia: <?= $p['stok']; ?> porsi</p>
                        
                        <form action="" method="POST" class="mt-3 border-top pt-3">
                            <input type="hidden" name="id_produk" value="<?= $p['id']; ?>">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="small">Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" min="1" max="<?= $p['stok']; ?>" value="1" required>
                                </div>
                                <div class="col-6">
                                    <label class="small">Fasilitas Kemasan</label>
                                    <select name="fasilitas_tambahan" class="form-select">
                                        <option value="Standar">Standar Box</option>
                                        <option value="Tema Acara">Tema Acara / Dekorasi</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="small">Waktu Pengambilan</label>
                                    <input type="datetime-local" name="waktu_pengambilan" class="form-control" required>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" name="pesan" class="btn btn-danger w-100">Pesan Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>