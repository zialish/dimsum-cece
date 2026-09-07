<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin Dimsum Cece</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid position-relative bg-white d-flex p-0">

    <!-- Sidebar -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <a href="<?= BASEURL; ?>/produk" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Dimsum Cece</h3>
            </a>
            <div class="navbar-nav w-100">
                <a href="<?= BASEURL; ?>/produk" class="nav-item nav-link active">
                    <i class="fa fa-th me-2"></i>Kelola Produk
                </a>
                <a href="<?= BASEURL; ?>/pesanan" class="nav-item nav-link">
                    <i class="fa fa-shopping-cart me-2"></i>Kelola Pesanan
                </a>
                <a href="<?= BASEURL; ?>/auth/logout" class="nav-item nav-link text-danger">
                    <i class="fa fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </nav>
    </div>

    <!-- Content -->
    <div class="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="height: 64px;">
            <span class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
            </span>
            <div class="navbar-nav align-items-center ms-auto">
                <span class="d-none d-lg-inline-flex text-dark font-weight-bold">
                    Halo, <?= htmlspecialchars($_SESSION['nama']); ?> (Admin)
                </span>
            </div>
        </nav>

        <div class="container-fluid pt-4 px-4">

            <!-- Flash messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i><?= $_SESSION['success']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i><?= $_SESSION['error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Header row -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fa fa-list me-2 text-primary"></i>Daftar Menu Dimsum Cece</h5>
                <a href="<?= BASEURL; ?>/produk/tambah" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i>Tambah Produk
                </a>
            </div>

            <!-- Tabel produk -->
            <div class="bg-light rounded p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Ukuran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($produk)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="fa fa-box-open fa-2x mb-2 d-block"></i>
                                        Belum ada data produk.
                                        <a href="<?= BASEURL; ?>/produk/tambah" class="ms-1">Tambah sekarang?</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($produk as $p): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= BASEURL; ?>/uploads/<?= htmlspecialchars($p['foto'] ?: 'default.jpg'); ?>"
                                                 alt="Foto" class="rounded"
                                                 style="width:50px;height:50px;object-fit:cover;">
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($p['nama_produk']); ?></strong>
                                            <?php if (!empty($p['is_best_seller'])): ?>
                                                <span class="badge bg-warning text-dark ms-1">🔥 Terlaris</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($p['nama_kategori']); ?></span>
                                        </td>
                                        <td>Rp <?= number_format($p['harga'], 0, ',', '.'); ?></td>
                                        <td><?= (int)$p['stok']; ?></td>
                                        <td><?= htmlspecialchars($p['ukuran'] ?? '-'); ?></td>
                                        <td>
                                            <?php if ($p['tersedia'] == 1): ?>
                                                <a href="<?= BASEURL; ?>/produk/toggleStatus?id=<?= $p['id']; ?>"
                                                   class="btn btn-success btn-sm">🟢 Tersedia</a>
                                            <?php else: ?>
                                                <a href="<?= BASEURL; ?>/produk/toggleStatus?id=<?= $p['id']; ?>"
                                                   class="btn btn-secondary btn-sm">🔴 Tidak Tersedia</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= BASEURL; ?>/produk/edit?id=<?= $p['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit me-1"></i>Edit
                                            </a>
                                            <a href="<?= BASEURL; ?>/produk/hapus?id=<?= $p['id']; ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin hapus produk ini?')">
                                                <i class="fa fa-trash me-1"></i>Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /container -->
    </div><!-- /content -->
</div><!-- /wrapper -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?= BASEURL; ?>/../admin/dashmin-1.0.0/js/main.js"></script>
</body>
</html>
