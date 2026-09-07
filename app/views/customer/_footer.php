<?php
/**
 * Partial: _footer.php
 * Include di setiap halaman customer.
 */
$cart_count_footer = isset($_SESSION['keranjang']) ? array_sum($_SESSION['keranjang']) : 0;
?>
<style>
/* ── Footer utama ───────────────────────────────────────────────────── */
.footer-dc {
    background: linear-gradient(160deg, #1a2e1a 0%, #0f1f0f 100%);
    color: rgba(255,255,255,.72);
    padding: 3.5rem 0 0;
}
.footer-dc h5 {
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 1.1rem;
    position: relative;
    padding-bottom: .55rem;
}
.footer-dc h5::after {
    content: '';
    display: block;
    width: 32px; height: 3px;
    background: #f9a825;
    border-radius: 2px;
    position: absolute;
    bottom: 0; left: 0;
}
.footer-dc .brand-name {
    font-family: 'Raleway', sans-serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -.5px;
}
.footer-dc .brand-name span { color: #f9a825; }
.footer-dc .footer-link {
    display: block;
    color: rgba(255,255,255,.65);
    text-decoration: none;
    padding: .22rem 0;
    font-size: .88rem;
    transition: color .18s, padding-left .18s;
}
.footer-dc .footer-link:hover { color: #a5d6a7; padding-left: 6px; }
.footer-dc .footer-link i {
    width: 16px;
    margin-right: .45rem;
    color: #81c784;
}
.footer-dc .contact-item {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    font-size: .88rem;
    margin-bottom: .6rem;
    color: rgba(255,255,255,.7);
}
.footer-dc .contact-item i {
    color: #81c784;
    margin-top: 2px;
    flex-shrink: 0;
    width: 14px;
}
.footer-dc .social-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    color: rgba(255,255,255,.7);
    font-size: .95rem;
    text-decoration: none;
    transition: background .2s, color .2s, transform .15s;
}
.footer-dc .social-btn:hover {
    background: #f9a825;
    color: #212121;
    transform: translateY(-2px);
    border-color: #f9a825;
}
.footer-dc .divider {
    border-top: 1px solid rgba(255,255,255,.1);
    margin-top: 2.5rem;
}

/* ── Jam operasional pill ───────────────────────────────────────────── */
.jam-pill {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 50px;
    padding: .28rem .85rem;
    font-size: .8rem;
    color: rgba(255,255,255,.8);
    margin-bottom: .4rem;
}
.jam-pill.open { border-color: #81c784; color: #a5d6a7; }
.jam-pill .dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #81c784;
    flex-shrink: 0;
}

/* ── Copyright bar ──────────────────────────────────────────────────── */
.footer-copy {
    background: rgba(0,0,0,.35);
    padding: .85rem 0;
    font-size: .8rem;
    color: rgba(255,255,255,.5);
    text-align: center;
}
.footer-copy a { color: rgba(255,255,255,.7); text-decoration: none; }
.footer-copy a:hover { color: #fff; }
</style>

<footer class="footer-dc">
    <div class="container">
        <div class="row g-5">

            <!-- Kolom 1: Brand & deskripsi -->
            <div class="col-lg-4 col-md-6">
                <div class="brand-name mb-2">🥟 Dimsum<span>Cece</span></div>
                <p class="small mb-3" style="color:rgba(255,255,255,.6);line-height:1.7;">
                    Usaha kuliner rumahan yang menyajikan aneka dimsum lezat dengan cita rasa
                    autentik khas Tionghoa. Dibuat fresh setiap hari tanpa pengawet.
                </p>
                <!-- Sosial media -->
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="social-btn" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Kolom 2: Link navigasi -->
            <div class="col-lg-2 col-md-6">
                <h5>Navigasi</h5>
                <a href="<?= BASEURL; ?>/home" class="footer-link">
                    <i class="fa fa-utensils"></i>Menu Dimsum
                </a>
                <a href="<?= BASEURL; ?>/home/profil" class="footer-link">
                    <i class="fa fa-store"></i>Profil UMKM
                </a>
                <a href="<?= BASEURL; ?>/home/keranjang" class="footer-link">
                    <i class="fa fa-shopping-bag"></i>Keranjang
                    <?php if ($cart_count_footer > 0): ?>
                        <span class="badge bg-warning text-dark ms-1" style="font-size:.68rem;"><?= $cart_count_footer; ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?= BASEURL; ?>/home/riwayat" class="footer-link">
                    <i class="fa fa-history"></i>Riwayat Pesanan
                </a>
            </div>

            <!-- Kolom 3: Jam operasional -->
            <div class="col-lg-3 col-md-6">
                <h5>Jam Operasional</h5>
                <?php
                $jam_now = (int)date('G');
                $is_open = ($jam_now >= 8 && $jam_now < 20);
                ?>
                <div class="jam-pill <?= $is_open ? 'open' : ''; ?> mb-2">
                    <span class="dot" style="background:<?= $is_open ? '#81c784' : '#ef9a9a'; ?>"></span>
                    <?= $is_open ? 'Sedang Buka' : 'Sedang Tutup'; ?>
                </div>
                <table class="table table-sm table-borderless mb-0" style="color:rgba(255,255,255,.65);font-size:.85rem;">
                    <tbody>
                        <tr><td class="ps-0 py-1">Senin – Jumat</td><td class="py-1 fw-semibold text-white">08.00 – 20.00</td></tr>
                        <tr><td class="ps-0 py-1">Sabtu – Minggu</td><td class="py-1 fw-semibold text-white">08.00 – 21.00</td></tr>
                        <tr><td class="ps-0 py-1">Hari Libur</td><td class="py-1 text-warning fw-semibold">Menyesuaikan</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Kolom 4: Kontak -->
            <div class="col-lg-3 col-md-6">
                <h5>Hubungi Kami</h5>
                <div class="contact-item">
                    <i class="fa fa-map-marker-alt"></i>
                    <span>Jl. Garuda Sakti KM. 2, Simpang Baru, Kec. Tampan, Pekanbaru, Riau 28293</span>
                </div>
                <div class="contact-item">
                    <i class="fab fa-whatsapp"></i>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
                       style="color:rgba(255,255,255,.7);text-decoration:none;">+62 812-3456-7890</a>
                </div>
                <div class="contact-item">
                    <i class="fa fa-envelope"></i>
                    <span>dimsum@cece.com</span>
                </div>
                <a href="https://maps.google.com/?q=0.5212995994736076,101.47223077472354"
                   target="_blank" rel="noopener"
                   class="btn btn-sm mt-2 rounded-pill px-3"
                   style="background:rgba(255,255,255,.1);color:#a5d6a7;border:1px solid rgba(255,255,255,.2);font-size:.8rem;">
                    <i class="fa fa-map me-1"></i>Lihat di Google Maps
                </a>
            </div>

        </div><!-- /row -->
    </div>

    <!-- Copyright -->
    <div class="divider"></div>
    <div class="footer-copy">
        <div class="container">
            &copy; <?= date('Y'); ?> <strong style="color:rgba(255,255,255,.8);">Dimsum Cece</strong>
            &mdash; Seluruh hak cipta dilindungi.
            &nbsp;|&nbsp;
            Dibuat dengan <i class="fa fa-heart" style="color:#ef9a9a;"></i> di Pekanbaru
        </div>
    </div>
</footer>
