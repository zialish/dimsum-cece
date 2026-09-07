<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil UMKM - Dimsum Cece</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/../fruitables-1.0.0/css/style.css" rel="stylesheet">
    <style>
        .info-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            height: 100%;
            transition: box-shadow .2s;
        }
        .info-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
        .info-card h5 { font-size: 1rem; margin-bottom: .5rem; }
        .gallery-item img {
            height: 180px;
            object-fit: cover;
            width: 100%;
            transition: transform .3s;
        }
        .gallery-item:hover img { transform: scale(1.04); }
        .gallery-item { border-radius: 10px; overflow: hidden; border: 1px solid #dee2e6; }
        .section-label {
            font-size: .8rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 600;
        }
        .hero-badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            border-radius: 20px;
            padding: .25rem .85rem;
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php $active_page = 'profil'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ── Hero / Tentang Kami ──────────────────────────────────────────────── -->
<div class="container-fluid py-5" style="margin-top:4px;">
    <div class="container py-4">
        <div class="row g-5 align-items-start">

            <!-- Kolom kiri: Info toko -->
            <div class="col-lg-7">
                <span class="section-label text-secondary">Tentang Kami</span>
                <div class="hero-badge mt-2">🥟 UMKM Lokal Pekanbaru</div>
                <h1 class="mb-3 text-primary fw-bold">Dimsum Cece</h1>
                <p class="mb-4 fs-5 text-dark lh-lg">
                    Dimsum Cece adalah usaha kuliner rumahan yang menyajikan aneka dimsum lezat
                    dengan cita rasa autentik khas Tionghoa. Berdiri sejak 2019, kami hadir
                    untuk memenuhi kebutuhan pecinta dimsum di Pekanbaru dengan menu yang terus
                    berkembang — mulai dari siomay, hakau, ceker saus tiram, hingga paket frozen
                    yang praktis untuk dinikmati di rumah.
                </p>
                <p class="text-muted mb-4">
                    Setiap produk kami dibuat <strong>fresh setiap hari</strong> menggunakan
                    bahan-bahan pilihan tanpa pengawet. Kami percaya bahwa makanan yang baik
                    dimulai dari bahan yang baik — jadi kepuasan pelanggan adalah prioritas utama
                    kami.
                </p>

                <!-- Info cards -->
                <div class="row g-3 mt-1">

                    <div class="col-sm-6">
                        <div class="info-card">
                            <h5><i class="fa fa-map-marker-alt text-primary me-2"></i>Alamat Toko</h5>
                            <p class="text-muted mb-2">
                                Jl. Garuda Sakti KM. 2, Simpang Baru,<br>
                                Kec. Tampan, Kota Pekanbaru,<br>
                                Riau 28293
                            </p>
                            <a href="https://maps.google.com/?q=0.5212995994736076,101.47223077472354"
                               target="_blank" rel="noopener"
                               class="btn btn-sm btn-success rounded-pill px-3">
                                <i class="fa fa-map me-1"></i>Buka Google Maps
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="info-card">
                            <h5><i class="fab fa-whatsapp text-primary me-2"></i>Kontak / WhatsApp</h5>
                            <p class="text-muted mb-2">+62 812-3456-7890</p>
                            <a href="https://wa.me/6281234567890?text=Halo+Dimsum+Cece,+saya+ingin+pesan"
                               target="_blank" rel="noopener"
                               class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="fab fa-whatsapp me-1"></i>Chat Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="info-card">
                            <h5><i class="fa fa-clock text-primary me-2"></i>Jam Operasional</h5>
                            <table class="table table-sm table-borderless mb-0 text-muted">
                                <tbody>
                                    <tr>
                                        <td class="ps-0 py-1">Senin – Jumat</td>
                                        <td class="py-1 fw-semibold">08.00 – 20.00 WIB</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 py-1">Sabtu – Minggu</td>
                                        <td class="py-1 fw-semibold">08.00 – 21.00 WIB</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 py-1">Hari Libur</td>
                                        <td class="py-1 text-warning fw-semibold">Menyesuaikan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="info-card">
                            <h5><i class="fa fa-star text-primary me-2"></i>Layanan Utama</h5>
                            <ul class="text-muted mb-0 ps-3">
                                <li>Dimsum kukus &amp; goreng segar</li>
                                <li>Paket frozen siap masak</li>
                                <li>Pesan antar area Pekanbaru</li>
                                <li>Pre-order untuk acara / hampers</li>
                            </ul>
                        </div>
                    </div>

                </div><!-- /row info-cards -->
            </div>

            <!-- Kolom kanan: Galeri -->
            <div class="col-lg-5">
                <h4 class="mb-3 fw-bold text-dark">
                    <i class="fa fa-images text-primary me-2"></i>Galeri Menu Terpopuler
                </h4>
                <div class="row g-3">

                    <div class="col-6">
                        <div class="gallery-item">
                            <img src="<?= BASEURL; ?>/uploads/1782389704_6a3d1bc81102d.jpeg"
                                 alt="Dimsum Mentai">
                            <div class="p-2 bg-light text-center small fw-bold">Dimsum Mentai</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="gallery-item">
                            <img src="<?= BASEURL; ?>/uploads/1782389862_6a3d1c66f23c3.jpeg"
                                 alt="Dimsum Birthday">
                            <div class="p-2 bg-light text-center small fw-bold">Dimsum Birthday</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="gallery-item">
                            <img src="<?= BASEURL; ?>/uploads/1782390031_6a3d1d0f3a0cd.jpg"
                                 alt="Dimsum Frozen">
                            <div class="p-2 bg-light text-center small fw-bold">Dimsum Frozen</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="gallery-item">
                            <img src="<?= BASEURL; ?>/uploads/1782390288_6a3d1e102a455.jpeg"
                                 alt="Dimsum Birthday Pack">
                            <div class="p-2 bg-light text-center small fw-bold">Dimsum Birthday Pack</div>
                        </div>
                    </div>

                </div>

                <!-- Sosmed -->
                <div class="mt-4 p-3 bg-light rounded-3 border">
                    <p class="mb-2 fw-semibold small text-muted text-uppercase" style="letter-spacing:.08em;">
                        Ikuti Kami
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fab fa-instagram me-1 text-danger"></i>Instagram
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fab fa-tiktok me-1"></i>TikTok
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fab fa-facebook me-1 text-primary"></i>Facebook
                        </a>
                    </div>
                </div>

            </div>
        </div><!-- /row -->
    </div>
</div>

<!-- ── Keunggulan ──────────────────────────────────────────────────────────── -->
<div class="container-fluid bg-light py-5">
    <div class="container py-3">
        <h4 class="text-center fw-bold mb-4">Mengapa Pilih Dimsum Cece?</h4>
        <div class="row g-4 text-center">

            <div class="col-sm-6 col-lg-3">
                <div class="p-4 bg-white rounded-3 h-100 border">
                    <div class="display-5 mb-3">🥟</div>
                    <h6 class="fw-bold">Resep Autentik</h6>
                    <p class="text-muted small mb-0">Menggunakan resep turun-temurun dengan bumbu pilihan khas Tionghoa.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="p-4 bg-white rounded-3 h-100 border">
                    <div class="display-5 mb-3">🌿</div>
                    <h6 class="fw-bold">Bahan Segar</h6>
                    <p class="text-muted small mb-0">Dibuat fresh setiap hari tanpa pengawet. Bahan baku diperoleh langsung dari pemasok terpercaya.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="p-4 bg-white rounded-3 h-100 border">
                    <div class="display-5 mb-3">🚴</div>
                    <h6 class="fw-bold">Pesan Antar</h6>
                    <p class="text-muted small mb-0">Layanan antar ke seluruh area Pekanbaru. Bisa juga ambil sendiri di toko.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="p-4 bg-white rounded-3 h-100 border">
                    <div class="display-5 mb-3">📦</div>
                    <h6 class="fw-bold">Paket Frozen</h6>
                    <p class="text-muted small mb-0">Tersedia paket frozen siap masak — cocok untuk stok di rumah atau hadiah.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once __DIR__ . '/_footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
