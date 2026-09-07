<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Dimsum Cece</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/style.css" rel="stylesheet">
</head>
<body>
<?php $active_page = 'riwayat'; require_once __DIR__ . '/_navbar.php'; ?>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h2 class="mb-4">Riwayat Pengambilan & Pesanan Anda</h2>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i><?= $_SESSION['success']; ?><?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($daftar_pesanan)): ?>
                <div class="text-center py-5 bg-light rounded">
                    <p class="text-muted fs-5">Anda belum pernah melakukan reservasi pemesanan.</p>
                    <a href="<?= BASEURL; ?>/home" class="btn btn-primary rounded-pill text-white mt-2">Pesan Dimsum Sekarang</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Rencana Pengambilan</th>
                                <th>Catatan / Fasilitas</th>
                                <th>Total Bayar</th>
                                <th>Status Pesanan</th>
                                <th>Aksi Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($daftar_pesanan as $pesanan): ?>
                                <tr>
                                    <td><strong>#DC-<?= $pesanan['id']; ?></strong></td>
                                    <td>
                                        <span class="d-block text-primary fw-bold"><?= date('d M Y', strtotime($pesanan['tanggal_pengambilan'])); ?></span>
                                        <small class="text-muted">Jam: <?= substr($pesanan['jam_pengambilan'], 0, 5); ?> WIB</small>
                                    </td>
                                    <td class="text-start">
                                        <small><strong>Fasilitas:</strong> <?= $pesanan['fasilitas_tambahan'] ? $pesanan['fasilitas_tambahan'] : '-'; ?></small><br>
                                        <small><strong>Catatan:</strong> <?= $pesanan['catatan'] ? $pesanan['catatan'] : '-'; ?></small>
                                    </td>
                                    <td class="fw-bold text-success">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php 
                                        $status = $pesanan['status_pesanan'];
                                        $badgeColor = 'bg-warning text-dark';
                                        if($status == 'Diproses') $badgeColor = 'bg-info text-white';
                                        if($status == 'Siap Diambil') $badgeColor = 'bg-primary text-white';
                                        if($status == 'Selesai') $badgeColor = 'bg-success text-white';
                                        if($status == 'Dibatalkan') $badgeColor = 'bg-danger text-white';
                                        ?>
                                        <span class="badge <?= $badgeColor; ?> px-3 py-2 fs-7"><?= $status; ?></span>
                                    </td>
                                    <td>
                                        <?php if ($status === 'Menunggu Pembayaran'): ?>
                                            <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadModal<?= $pesanan['id']; ?>">
                                                <i class="fa fa-upload me-1"></i> Upload Bukti
                                            </button>

                                            <div class="modal fade" id="uploadModal<?= $pesanan['id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Upload Bukti Transfer #DC-<?= $pesanan['id']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?= BASEURL; ?>/home/uploadPembayaran" method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body text-start">
                                                                <input type="hidden" name="pesanan_id" value="<?= $pesanan['id']; ?>">
                                                                <p class="text-muted mb-3">Silakan transfer sesuai total tagihan ke Rekening **BCA 12345678 a/n Dimsum Cece** lalu unggah foto struknya di bawah ini:</p>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Pilih Gambar Bukti Transfer</label>
                                                                    <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary text-white">Kirim Bukti</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted"><i class="fa fa-check-circle text-success"></i> Sudah Upload</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once __DIR__ . '/_footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>