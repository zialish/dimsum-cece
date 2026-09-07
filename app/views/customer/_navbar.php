<?php
/**
 * Partial: _navbar.php
 * Include di setiap halaman customer. Set $active_page sebelum include.
 * Nilai valid: 'home' | 'profil' | 'riwayat' | 'keranjang' | 'checkout'
 */
$active_page   = $active_page   ?? 'home';
$cart_count    = isset($_SESSION['keranjang']) ? array_sum($_SESSION['keranjang']) : 0;
$nama_user     = htmlspecialchars($_SESSION['nama'] ?? 'Pelanggan');
?>
<style>
/* ── Topbar ─────────────────────────────────────────────────────────── */
.topbar-dc {
    background: linear-gradient(90deg, #2e7d32 0%, #1b5e20 100%);
    font-size: .78rem;
    padding: .35rem 0;
}
.topbar-dc a { color: rgba(255,255,255,.82); text-decoration: none; }
.topbar-dc a:hover { color: #fff; }
.topbar-dc .separator { color: rgba(255,255,255,.35); margin: 0 .5rem; }

/* ── Navbar utama ───────────────────────────────────────────────────── */
.navbar-dc {
    background: #fff;
    box-shadow: 0 2px 12px rgba(0,0,0,.08);
    padding: .6rem 0;
    transition: box-shadow .2s;
}
.navbar-dc .navbar-brand-text {
    font-family: 'Raleway', sans-serif;
    font-weight: 800;
    font-size: 1.6rem;
    color: #2e7d32;
    letter-spacing: -.5px;
    line-height: 1;
}
.navbar-dc .navbar-brand-text span { color: #f9a825; }
.navbar-dc .nav-link {
    font-weight: 600;
    font-size: .92rem;
    color: #424242;
    padding: .5rem .9rem;
    border-radius: 8px;
    transition: background .18s, color .18s;
    position: relative;
}
.navbar-dc .nav-link:hover,
.navbar-dc .nav-link.active {
    color: #2e7d32;
    background: #f1f8e9;
}
.navbar-dc .nav-link.active::after {
    content: '';
    display: block;
    height: 3px;
    background: #2e7d32;
    border-radius: 2px;
    position: absolute;
    bottom: 2px; left: .9rem; right: .9rem;
}

/* ── Cart badge ─────────────────────────────────────────────────────── */
.cart-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px; height: 42px;
    border-radius: 50%;
    background: #f1f8e9;
    border: 1.5px solid #c8e6c9;
    color: #2e7d32;
    font-size: 1.1rem;
    transition: background .2s, transform .15s;
    text-decoration: none;
}
.cart-btn:hover { background: #dcedc8; transform: scale(1.08); color: #1b5e20; }
.cart-badge {
    position: absolute;
    top: -5px; right: -6px;
    background: #f9a825;
    color: #212121;
    font-size: .65rem;
    font-weight: 700;
    border-radius: 50px;
    min-width: 18px; height: 18px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 4px;
    border: 2px solid #fff;
}

/* ── User chip ──────────────────────────────────────────────────────── */
.user-chip {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: #f5f5f5;
    border-radius: 50px;
    padding: .3rem .75rem .3rem .45rem;
    font-size: .82rem;
    font-weight: 600;
    color: #424242;
    border: 1px solid #e0e0e0;
}
.user-chip .avatar {
    width: 26px; height: 26px;
    border-radius: 50%;
    background: #2e7d32;
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* ── Logout btn ─────────────────────────────────────────────────────── */
.btn-logout {
    font-size: .82rem;
    font-weight: 600;
    border-radius: 50px;
    padding: .35rem .9rem;
    border: 1.5px solid #e53935;
    color: #e53935;
    background: transparent;
    transition: background .18s, color .18s;
    text-decoration: none;
    white-space: nowrap;
}
.btn-logout:hover { background: #e53935; color: #fff; }
</style>

<!-- ── Topbar ──────────────────────────────────────────────────────────── -->
<div class="topbar-dc d-none d-lg-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <i class="fa fa-map-marker-alt me-1"></i>
            Jl. Garuda Sakti KM.2, Pekanbaru
            <span class="separator">|</span>
            <i class="fa fa-clock me-1"></i>
            Buka: 08.00 – 20.00 WIB
        </div>
        <div>
            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp me-1"></i>+62 812-3456-7890
            </a>
            <span class="separator">|</span>
            <a href="<?= BASEURL; ?>/home/profil">Tentang Kami</a>
        </div>
    </div>
</div>

<!-- ── Navbar utama ────────────────────────────────────────────────────── -->
<nav class="navbar-dc fixed-top-nav navbar navbar-expand-xl px-3 px-lg-0">
    <div class="container">

        <!-- Brand -->
        <a href="<?= BASEURL; ?>/home" class="navbar-brand p-0 me-4">
            <div class="navbar-brand-text">🥟 Dimsum<span>Cece</span></div>
        </a>

        <!-- Toggler mobile -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navDC" aria-label="Toggle navigation">
            <span class="fa fa-bars" style="color:#2e7d32;font-size:1.3rem;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navDC">

            <!-- Nav links -->
            <ul class="navbar-nav mx-auto mb-2 mb-xl-0 gap-1">
                <li class="nav-item">
                    <a href="<?= BASEURL; ?>/home"
                       class="nav-link <?= $active_page === 'home' ? 'active' : ''; ?>">
                        <i class="fa fa-utensils me-1"></i>Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASEURL; ?>/home/profil"
                       class="nav-link <?= $active_page === 'profil' ? 'active' : ''; ?>">
                        <i class="fa fa-store me-1"></i>Profil UMKM
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASEURL; ?>/home/riwayat"
                       class="nav-link <?= $active_page === 'riwayat' ? 'active' : ''; ?>">
                        <i class="fa fa-history me-1"></i>Riwayat Pesanan
                    </a>
                </li>
            </ul>

            <!-- Right side: cart + user + logout -->
            <div class="d-flex align-items-center gap-3 mt-3 mt-xl-0">

                <!-- Cart -->
                <a href="<?= BASEURL; ?>/home/keranjang"
                   class="cart-btn <?= $active_page === 'keranjang' ? 'bg-success text-white' : ''; ?>"
                   title="Keranjang Belanja">
                    <i class="fa fa-shopping-bag"></i>
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?= $cart_count; ?></span>
                    <?php endif; ?>
                </a>

                <!-- User chip -->
                <div class="user-chip d-none d-lg-inline-flex">
                    <div class="avatar"><?= mb_strtoupper(mb_substr($_SESSION['nama'] ?? 'P', 0, 1)); ?></div>
                    <?= $nama_user; ?>
                </div>

                <!-- Logout -->
                <a href="<?= BASEURL; ?>/auth/logout"
                   onclick="return confirm('Yakin ingin logout?')"
                   class="btn-logout">
                    <i class="fa fa-sign-out-alt me-1"></i>Logout
                </a>

            </div>
        </div>
    </div>
</nav>

<!-- Spacer agar konten tidak tertutup navbar -->
<div style="height: <?= ($active_page === 'home') ? '0' : '80px'; ?>;"></div>
<?php if ($active_page !== 'home'): ?>
<div style="height: 16px;" class="d-block d-lg-none"></div>
<?php endif; ?>
