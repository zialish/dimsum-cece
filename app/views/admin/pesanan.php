<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - Admin Dimsum Cece</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="#" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Dimsum Cece</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="<?= BASEURL; ?>/produk" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Kelola
                        Produk</a>
                    <a href="<?= BASEURL; ?>/pesanan" class="nav-item nav-link active"><i
                            class="fa fa-shopping-cart me-2"></i>Kelola Pesanan</a>
                    <a href="<?= BASEURL; ?>/auth/logout" class="nav-item nav-link text-danger"><i
                            class="fa fa-sign-out-alt me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <div class="content">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="height: 64px;">
                <div class="navbar-nav align-items-center ms-auto">
                    <span class="text-dark font-weight-bold">Halo, <?= $_SESSION['nama']; ?> (Admin)</span>
                </div>
            </nav>
            <div class="container-fluid pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Daftar Reservasi & Pesanan Masuk</h3>
                    <a href="<?= BASEURL; ?>/pesanan/filterLaporan" class="btn btn-primary">
                        <i class="fa fa-file-pdf me-2"></i> Cetak Laporan Keuangan
                    </a>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i
                            class="fa fa-check-circle me-2"></i><?= $_SESSION['success']; ?><?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <div class="bg-light rounded p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th>ID Order</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Waktu Pengambilan</th>
                                    <th>Total Bayar</th>
                                    <th>Status Saat Ini</th>
                                    <th>Bukti Bayar</th>
                                    <th>Aksi Update Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($daftar_pesanan)): ?>
                                    <tr>
                                        <td colspan="7" class="text-muted py-4">Belum ada pesanan masuk dari pelanggan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($daftar_pesanan as $res): ?>
                                        <tr>
                                            <td><strong>#DC-<?= $res['id']; ?></strong></td>
                                            <td><?= $res['nama']; ?></td>
                                            <td>
                                                <span
                                                    class="text-dark fw-bold"><?= date('d/m/Y', strtotime($res['tanggal_pengambilan'])); ?></span><br>
                                                <small class="text-muted">Jam: <?= substr($res['jam_pengambilan'], 0, 5); ?>
                                                    WIB</small>
                                            </td>
                                            <td class="text-success fw-bold">Rp
                                                <?= number_format($res['total_harga'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?php
                                                $st = $res['status_pesanan'];
                                                $badge = 'bg-warning text-dark';
                                                if ($st == 'Diproses')
                                                    $badge = 'bg-info text-white';
                                                if ($st == 'Siap Diambil')
                                                    $badge = 'bg-primary text-white';
                                                if ($st == 'Selesai')
                                                    $badge = 'bg-success text-white';
                                                if ($st == 'Batal')
                                                    $badge = 'bg-danger text-white';
                                                ?>
                                                <span class="badge <?= $badge; ?>"><?= $st; ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                $dbInstan = (new Database())->getConnection();
                                                $qBayar = "SELECT bukti_pembayaran FROM pembayaran WHERE pesanan_id = :pid LIMIT 1";
                                                $stB = $dbInstan->prepare($qBayar);
                                                $stB->bindValue(':pid', $res['id']);
                                                $stB->execute();
                                                $pembayaran = $stB->fetch(PDO::FETCH_ASSOC);
                                                ?>

                                                <?php if ($pembayaran): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                                        data-bs-target="#imgModal<?= $res['id']; ?>">
                                                        <i class="fa fa-eye"></i> Lihat Struk
                                                    </button>

                                                    <div class="modal fade" id="imgModal<?= $res['id']; ?>" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Struk Transfer #DC-<?= $res['id']; ?>
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="<?= BASEURL; ?>/uploads/<?= $pembayaran['bukti_pembayaran']; ?>"
                                                                        class="img-fluid rounded" alt="Bukti Transfer">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small">Belum Bayar</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <form action="<?= BASEURL; ?>/pesanan/updateStatus" method="POST"
                                                    class="d-flex justify-content-center g-2">
                                                    <input type="hidden" name="pesanan_id" value="<?= $res['id']; ?>">
                                                    <select name="status_pesanan" class="form-select form-select-sm me-2"
                                                        style="width: 130px;" onchange="this.form.submit()">
                                                        <option value="Menunggu Pembayaran" <?= $st == 'Menunggu Pembayaran' ? 'selected' : ''; ?>>Menunggu</option>
                                                        <option value="Diproses" <?= $st == 'Diproses' ? 'selected' : ''; ?>>
                                                            Diproses</option>
                                                        <option value="Siap Diambil" <?= $st == 'Siap Diambil' ? 'selected' : ''; ?>>Siap Diambil</option>
                                                        <option value="Selesai" <?= $st == 'Selesai' ? 'selected' : ''; ?>>Selesai
                                                        </option>
                                                        <option value="Batal" <?= $st == 'Batal' ? 'selected' : ''; ?>>Batal
                                                        </option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>