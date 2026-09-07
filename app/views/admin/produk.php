<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin Dimsum Cece</title>

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

        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="#" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Dimsum Cece</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="<?= BASEURL; ?>/produk" class="nav-item nav-link active"><i
                            class="fa fa-th me-2"></i>Kelola Produk</a>
                    <a href="<?= BASEURL; ?>/pesanan" class="nav-item nav-link"><i
                            class="fa fa-shopping-cart me-2"></i>Kelola Pesanan</a> <a
                        href="<?= BASEURL; ?>/auth/logout" class="nav-item nav-link text-danger"><i
                            class="fa fa-sign-out-alt me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <div class="content">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="height: 64px;">
                <span class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </span>
                <div class="navbar-nav align-items-center ms-auto">
                    <span class="d-none d-lg-inline-flex text-dark font-weight-bold">Halo, <?= $_SESSION['nama']; ?>
                        (Admin)</span>
                </div>
            </nav>
            <div class="container-fluid pt-4 px-4">

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i><?= $_SESSION['success']; ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?= $_SESSION['error']; ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <div class="col-sm-12 col-xl-4">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Tambah Produk Baru</h6>
                            <form action="<?= BASEURL; ?>/produk/tambah" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($kategori as $kat): ?>
                                            <option value="<?= $kat['id']; ?>"><?= $kat['nama_kategori']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga (Rp)</label>
                                    <input type="number" class="form-control" id="harga" name="harga" required>
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" required>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="is_best_seller" value="1">

                                        <label class="form-check-label">
                                            🔥 Produk Terlaris
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="ukuran" class="form-label">Ukuran / Porsi</label>
                                    <input type="text" class="form-control" id="ukuran" name="ukuran"
                                        placeholder="Contoh: Isi 4 Pcs, Frozen Pack">
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Produk</label>
                                    <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-8">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Daftar Menu Dimsum Cece</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Stok</th>
                                            <th scope="col">Ukuran</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($produk)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">Belum ada data produk.
                                                    Silakan tambah data di form sebelah kiri.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($produk as $p): ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?= BASEURL; ?>/uploads/<?= $p['foto'] ? $p['foto'] : 'default.jpg'; ?>"
                                                            alt="Foto" class="rounded"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td><strong><?= $p['nama_produk']; ?></strong></td>
                                                    <td><span class="badge bg-secondary"><?= $p['nama_kategori']; ?></span></td>
                                                    <td>Rp <?= number_format($p['harga'], 0, ',', '.'); ?></td>
                                                    <td><?= $p['stok']; ?></td>
                                                    <td><?= $p['ukuran']; ?></td>
                                                    <td>

                                                        <?php if ($p['tersedia'] == 1): ?>

                                                            <a href="<?= BASEURL; ?>/produk/toggleStatus?id=<?= $p['id']; ?>"
                                                                class="btn btn-success btn-sm">

                                                                🟢 Tersedia

                                                            </a>

                                                        <?php else: ?>

                                                            <a href="<?= BASEURL; ?>/produk/toggleStatus?id=<?= $p['id']; ?>"
                                                                class="btn btn-secondary btn-sm">

                                                                🔴 Tidak Tersedia

                                                            </a>

                                                        <?php endif; ?>

                                                    </td>
                                                    <td>
                                                        <a href="<?= BASEURL; ?>/produk/edit?id=<?= $p['id']; ?>"
                                                            class="btn btn-warning btn-sm">

                                                            Edit

                                                        </a>

                                                        <a href="<?= BASEURL; ?>/produk/hapus?id=<?= $p['id']; ?>"
                                                            class="btn btn-danger btn-sm">

                                                            Hapus

                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="<?= BASEURL; ?>/../admin/dashmin-1.0.0/js/main.js"></script>
</body>

</html>