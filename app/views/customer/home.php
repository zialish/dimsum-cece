<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Dimsum Cece</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/style.css" rel="stylesheet">
    <style>
        /* ── Override hero-header: gradasi gelap dari bawah ke tengah ── */
        .hero-header {
            background:
                linear-gradient(
                    to top,
                    rgba(0, 0, 0, 0.72) 0%,
                    rgba(0, 0, 0, 0.38) 45%,
                    rgba(0, 0, 0, 0.10) 100%
                ),
                url(<?= BASEURL; ?>/../fruitables-1.0.0/img/bghome.png) center center / cover no-repeat;
            min-height: 420px;
            display: flex;
            align-items: flex-end;
        }

        /* ── Teks hero ────────────────────────────────────────────────── */
        .hero-subtitle {
            display: inline-block;
            color: #fff;
            font-weight: 600;
            font-size: 1.15rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            background: rgba(255, 181, 36, 0.25);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 181, 36, 0.5);
            border-radius: 50px;
            padding: .25rem 1rem;
            text-shadow: 0 1px 6px rgba(0,0,0,.6);
        }

        .hero-title {
            color: #fff;
            font-weight: 800;
            text-shadow:
                0 2px 8px rgba(0, 0, 0, .7),
                0 0 30px rgba(0, 0, 0, .35);
            line-height: 1.1;
        }

        /* ── Navbar spacer untuk hero ────────────────────────────────── */
        .fixed-top-nav { top: 0; }
        @media (min-width: 992px) { .fixed-top-nav { top: 30px; } }
    </style>
</head>

<body>
<?php $active_page = 'home'; require_once __DIR__ . '/_navbar.php'; ?>
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fa fa-check-circle me-2"></i>
                    <?= $_SESSION['success']; ?><?php unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 hero-subtitle">100% Lezat &amp; Halal</h4>
                    <h1 class="mb-5 display-3 hero-title">Dimsum Cece</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Menu Varian Kami</h1>
                    </div>
                </div>

                <div class="col-lg-8">
        <form method="GET">

            <div class="input-group">

                <input type="text"
                       name="cari"
                       class="form-control"
                       placeholder="Cari produk..."
                       value="<?= $_GET['cari'] ?? ''; ?>">

                <button class="btn btn-primary">
                    Cari
                </button>

            </div>

        </form>
    </div>

</div>

                <div class="tab-content mt-4">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">

                                    <?php if (empty($produk)): ?>
                                        <div class="col-12 text-center py-5">
                                            <p class="text-muted fs-5">Maaf, saat ini belum ada varian produk dimsum yang
                                                tersedia.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($produk as $p): ?>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div
                                                    class="rounded position-relative fruite-item border border-secondary border-top-0">
                                                    <div class="fruite-img">
                                                        <img src="<?= BASEURL; ?>/uploads/<?= $p['foto'] ? $p['foto'] : 'default.jpg'; ?>"
                                                            class="img-fluid w-100 rounded-top" alt="<?= $p['nama_produk']; ?>"
                                                            style="height: 230px; object-fit: cover;">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                        style="top: 10px; left: 10px;">
                                                        <?= $p['nama_kategori']; ?>
                                                    </div>
                                                    <div class="p-4 border-top-0 rounded-bottom">
                                                        <?php if(isset($p['is_best_seller']) && $p['is_best_seller'] == 1): ?>

<span class="badge bg-warning text-dark mb-2">
    🔥 Produk Terlaris
</span>

<?php endif; ?>

<?php if($p['tersedia'] == 0): ?>

<span class="badge bg-secondary mb-2">
    🔴 Tidak Tersedia
</span>

<?php endif; ?>

                                                        <h4><?= $p['nama_produk']; ?></h4>
                                                        <p class="text-muted mb-2" style="font-size: 0.9rem;">
                                                            <?= $p['ukuran'] ? $p['ukuran'] : '-'; ?>
                                                        </p>
                                                        <p class="small mb-2">
    Stok: <?= $p['stok']; ?>
</p>

<?php if($p['stok'] > 0 && $p['stok'] < 5): ?>

<span class="badge bg-warning text-dark mb-2">
    ⚠️ Stok Menipis
</span>

<?php endif; ?>
                                                        <p class="text-start"
                                                            style="height: 50px; overflow: hidden; text-overflow: ellipsis; font-size: 0.85rem;">
                                                            <?= $p['deskripsi']; ?>
                                                        </p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">Rp
                                                                <?= number_format($p['harga'], 0, ',', '.'); ?>
                                                            </p>

                                                            <a href="<?= BASEURL; ?>/home/tambahKeranjang?id=<?= $p['id']; ?>"
                                                                class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Beli
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/_footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASEURL; ?>/../fruitables-1.0.0/js/main.js"></script>
<script>
let jam = new Date().getHours();
if ((jam >= 22 || jam < 8) && !sessionStorage.getItem("notifJam")) {
    alert("🕒 Dimsum Cece buka pukul 08.00 - 20.00 WIB");
    sessionStorage.setItem("notifJam", "sudah");
}
</script>
</body>
</html>