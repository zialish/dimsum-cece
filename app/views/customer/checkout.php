<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - Dimsum Cece</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/style.css" rel="stylesheet">
</head>
<body>
<?php $active_page = 'checkout'; require_once __DIR__ . '/_navbar.php'; ?>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Formulir Checkout Pesanan</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; ?><?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/home/prosesCheckout" method="POST">
                <input type="hidden" name="total_harga" value="<?= $total_harga; ?>">

                <div class="row g-5">
                    <div class="col-md-12 col-lg-6-custom col-xl-7">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4">Detail Reservasi Pengambilan</h4>
                            <div class="row">
                                <div class="col-md-12 col-lg-6 mb-3">
                                    <label class="form-label">Tanggal Pengambilan<sup>*</sup></label>
                                    <input type="date" name="tanggal_pengambilan" class="form-control" required min="<?= date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-12 col-lg-6 mb-3">
                                    <label class="form-label">Jam Pengambilan<sup>*</sup></label>
                                    <input type="time" name="jam_pengambilan" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fasilitas Tambahan (Opsional)</label>
                                <input type="text" name="fasilitas_tambahan" class="form-control" placeholder="Contoh: Pakai pita kado, Kotak hangat">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Tambahan Pesanan</label>
                                <textarea name="catatan" class="form-control" rows="4" placeholder="Contoh: Sambal diganti saus tomat, ekstra sumpit"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            <table class="table border-bottom">
                                <thead>
                                    <tr>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td class="py-3">Dimsum</td>
                                            <td class="py-3"><?= $item['nama_produk']; ?></td>
                                            <td class="py-3">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                            <td class="py-3"><?= $item['jumlah']; ?></td>
                                            <td class="py-3">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <th scope="row" colspan="4" class="text-start ps-4 py-3">Total Bayar :</th>
                                        <td class="py-3 fw-bold text-primary">Rp <?= number_format($total_harga, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary font-weight-bold rounded-pill">Konfirmasi & Buat Pesanan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php require_once __DIR__ . '/_footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>