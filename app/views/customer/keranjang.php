<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Dimsum Cece</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/style.css" rel="stylesheet">
</head>
<body>
<?php $active_page = 'keranjang'; require_once __DIR__ . '/_navbar.php'; ?>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h2 class="mb-4">Keranjang Belanja Anda</h2>
<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?= $_SESSION['success']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <?= $_SESSION['error']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>
            <?php if (empty($items)): ?>
                <div class="text-center py-5">
                    <p class="text-muted fs-4 mb-4">Keranjang belanja Anda masih kosong.</p>
                    <a href="<?= BASEURL; ?>/home" class="btn btn-primary rounded-pill px-4 py-2 text-white">Kembali Belanja Menu</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Produk</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="<?= BASEURL; ?>/uploads/<?= $item['foto'] ? $item['foto'] : 'default.jpg'; ?>"
                                                 class="img-fluid me-3 rounded-circle"
                                                 style="width:80px;height:80px;object-fit:cover;" alt="">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 text-start"><strong><?= htmlspecialchars($item['nama_produk']); ?></strong></p>
                                        <small class="text-muted d-block text-start"><?= htmlspecialchars($item['ukuran'] ?? ''); ?></small>
                                    </td>
                                    <td>
                                        <p class="mb-0">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></p>
                                    </td>
                                    <!-- Kontrol jumlah: kurang | angka | tambah -->
                                    <td>
                                        <div class="qty-control d-inline-flex align-items-center gap-1">
                                            <a href="<?= BASEURL; ?>/home/ubahJumlahKeranjang?id=<?= $item['id']; ?>&aksi=kurang"
                                               class="btn btn-sm btn-outline-secondary rounded-circle qty-btn"
                                               style="width:30px;height:30px;padding:0;line-height:28px;"
                                               title="Kurangi">
                                                <i class="fa fa-minus" style="font-size:.7rem;"></i>
                                            </a>
                                            <span class="qty-value fw-bold px-2" style="min-width:28px;text-align:center;">
                                                <?= (int)$item['jumlah']; ?>
                                            </span>
                                            <a href="<?= BASEURL; ?>/home/ubahJumlahKeranjang?id=<?= $item['id']; ?>&aksi=tambah"
                                               class="btn btn-sm btn-outline-primary rounded-circle qty-btn"
                                               style="width:30px;height:30px;padding:0;line-height:28px;"
                                               title="Tambah">
                                                <i class="fa fa-plus" style="font-size:.7rem;"></i>
                                            </a>
                                        </div>
                                        <div class="text-muted" style="font-size:.72rem;margin-top:3px;">
                                            Stok: <?= (int)$item['stok']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-semibold">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></p>
                                    </td>
                                    <td>
                                        <a href="<?= BASEURL; ?>/home/hapusKeranjang?id=<?= $item['id']; ?>"
                                           class="btn btn-sm rounded-circle bg-light border text-danger"
                                           style="width:34px;height:34px;padding:0;line-height:32px;"
                                           onclick="return confirm('Hapus produk ini dari keranjang?')"
                                           title="Hapus">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end mt-4">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <div class="bg-light rounded p-4">
                            <h1 class="display-6 mb-4">Total <span class="fw-normal">Keranjang</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0">Rp <?= number_format($total_harga, 0, ',', '.'); ?></p>
                            </div>
                            <div class="py-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total Bayar:</h5>
                                <p class="mb-0 pe-4 fw-bold">Rp <?= number_format($total_harga, 0, ',', '.'); ?></p>
                            </div>
                            <a href="<?= BASEURL; ?>/home/checkout" class="btn border-secondary text-primary rounded-pill px-4 py-3 text-uppercase font-weight-bold w-100 mt-4">Lanjut ke Checkout</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once __DIR__ . '/_footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>