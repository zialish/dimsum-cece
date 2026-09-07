<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin Dimsum Cece</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS dari dashmin — path sama persis dengan produk.php -->
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <!-- ── Sidebar ───────────────────────────────────────────────────── -->
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

        <!-- ── Content ───────────────────────────────────────────────────── -->
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

                <!-- Alert dari session -->
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

                <!-- Breadcrumb -->
                <div class="d-flex align-items-center mb-4">
                    <a href="<?= BASEURL; ?>/produk" class="btn btn-sm btn-outline-secondary me-3">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <h5 class="mb-0">Edit Produk</h5>
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-sm-12 col-xl-7">
                        <div class="bg-light rounded p-4">
                            <h6 class="mb-4">
                                <i class="fa fa-edit me-2 text-warning"></i>
                                Edit: <strong><?= htmlspecialchars($produk['nama_produk']); ?></strong>
                            </h6>

                            <form action="<?= BASEURL; ?>/produk/update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= (int)$produk['id']; ?>">

                                <!-- Nama Produk -->
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                           value="<?= htmlspecialchars($produk['nama_produk']); ?>" required>
                                </div>

                                <!-- Kategori -->
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($kategori as $kat): ?>
                                            <option value="<?= $kat['id']; ?>"
                                                <?= (isset($produk['kategori_id']) && $produk['kategori_id'] == $kat['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($kat['nama_kategori']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Harga & Stok -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="harga" class="form-label">Harga (Rp)</label>
                                        <input type="number" class="form-control" id="harga" name="harga"
                                               value="<?= (int)$produk['harga']; ?>" min="0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" class="form-control" id="stok" name="stok"
                                               value="<?= (int)$produk['stok']; ?>" min="0" required>
                                    </div>
                                </div>

                                <!-- Best Seller -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_best_seller"
                                               id="is_best_seller" value="1"
                                               <?= (!empty($produk['is_best_seller'])) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="is_best_seller">
                                            🔥 Produk Terlaris
                                        </label>
                                    </div>
                                </div>

                                <!-- Ukuran / Porsi -->
                                <div class="mb-3">
                                    <label for="ukuran" class="form-label">Ukuran / Porsi</label>
                                    <input type="text" class="form-control" id="ukuran" name="ukuran"
                                           value="<?= htmlspecialchars($produk['ukuran'] ?? ''); ?>"
                                           placeholder="Contoh: Isi 4 Pcs, Frozen Pack">
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi"
                                              rows="3"><?= htmlspecialchars($produk['deskripsi'] ?? ''); ?></textarea>
                                </div>

                                <!-- Foto -->
                                <div class="mb-4">
                                    <label for="foto" class="form-label">Foto Produk</label>
                                    <?php if (!empty($produk['foto']) && $produk['foto'] !== 'default.jpg'): ?>
                                        <div class="mb-2">
                                            <img src="<?= BASEURL; ?>/uploads/<?= htmlspecialchars($produk['foto']); ?>"
                                                 alt="Foto saat ini" class="rounded border"
                                                 style="width:80px;height:80px;object-fit:cover;">
                                            <small class="text-muted ms-2">Foto saat ini</small>
                                        </div>
                                    <?php endif; ?>
                                    <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                                    <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="fa fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                    <a href="<?= BASEURL; ?>/produk" class="btn btn-outline-secondary w-100">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div><!-- /container -->
        </div><!-- /content -->
    </div><!-- /wrapper -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="<?= BASEURL; ?>/../admin/dashmin-1.0.0/js/main.js"></script>
</body>

</html>
