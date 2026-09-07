<?php
require_once 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

// Proses Update Status & Diskon oleh Admin
if (isset($_POST['update_pesanan'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $status_pembayaran = $_POST['status_pembayaran'];
    $diskon = (int)$_POST['diskon'];
    
    // Ambil harga total awal sebelum diskon diubah
    $st = $pdo->prepare("SELECT total_harga, diskon FROM pesanan WHERE id = ?");
    $st->execute([$id_pesanan]);
    $p = $st->fetch();
    
    if ($p) {
        // Hitung total harga baru berdasarkan perubahan diskon
        $harga_bersih_awal = $p['total_harga'] + $p['diskon'];
        $total_harga_baru = $harga_bersih_awal - $diskon;

        $up = $pdo->prepare("UPDATE pesanan SET status_pembayaran = ?, diskon = ?, total_harga = ? WHERE id = ?");
        $up->execute([$status_pembayaran, $diskon, $total_harga_baru, $id_pesanan]);
        
        echo "<script>alert('Data transaksi pesanan berhasil diperbarui!'); window.location.href='admin_dashboard.php';</script>";
    }
}

// Ambil riwayat pesanan masuk
$query = "SELECT p.*, u.username, dp.jumlah, pr.nama_produk 
          FROM pesanan p 
          JOIN users u ON p.id_user = u.id
          JOIN detail_pesanan dp ON p.id = dp.id_pesanan
          JOIN produk pr ON dp.id_produk = pr.id
          ORDER BY p.id DESC";
$orders = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Dimsum Cece</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Dimsum Cece - Admin Panel</a>
        <a href="logout.php" class="btn btn-outline-light btn-sm ms-auto">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Daftar Transaksi Pemesanan Masuk</h2>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover m-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Menu & Qty</th>
                        <th>Waktu Ambil</th>
                        <th>Fasilitas</th>
                        <th>Total Tagihan</th>
                        <th>Status Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= $o['id']; ?></td>
                            <td><strong><?= htmlspecialchars($o['username']); ?></strong></td>
                            <td><?= htmlspecialchars($o['nama_produk']); ?> (x<?= $o['jumlah']; ?>)</td>
                            <td><?= date('d M Y H:i', strtotime($o['waktu_pengambilan'])); ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($o['fasilitas_tambahan']); ?></span></td>
                            <td>Rp <?= number_format($o['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge bg-<?= $o['status_pembayaran'] === 'Lunas' ? 'success' : ($o['status_pembayaran'] === 'DP' ? 'warning' : 'danger'); ?>">
                                    <?= $o['status_pembayaran']; ?>
                                </span>
                            </td>
                            <td>
                                <form action="" method="POST" class="row g-1 align-items-center">
                                    <input type="hidden" name="id_pesanan" value="<?= $o['id']; ?>">
                                    <div class="col-auto">
                                        <select name="status_pembayaran" class="form-select form-select-sm">
                                            <option value="Belum Bayar" <?= $o['status_pembayaran'] == 'Belum Bayar' ? 'selected' : ''; ?>>Belum Bayar</option>
                                            <option value="DP" <?= $o['status_pembayaran'] == 'DP' ? 'selected' : ''; ?>>DP</option>
                                            <option value="Lunas" <?= $o['status_pembayaran'] == 'Lunas' ? 'selected' : ''; ?>>Lunas</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <input type="number" name="diskon" class="form-control form-control-sm" placeholder="Diskon (Rp)" value="<?= $o['diskon']; ?>" style="width: 100px;">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" name="update_pesanan" class="btn btn-primary btn-sm">Simpan</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>