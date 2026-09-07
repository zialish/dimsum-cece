<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Laporan - Admin Dimsum Cece</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
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
                <a href="<?= BASEURL; ?>/produk" class="nav-item nav-link">
                    <i class="fa fa-th me-2"></i>Kelola Produk
                </a>
                <a href="<?= BASEURL; ?>/pesanan" class="nav-item nav-link active">
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
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="height:64px;">
            <div class="navbar-nav align-items-center ms-auto">
                <span class="text-dark font-weight-bold">
                    Halo, <?= htmlspecialchars($_SESSION['nama']); ?> (Admin)
                </span>
            </div>
        </nav>

        <div class="container-fluid pt-4 px-4">

            <!-- Breadcrumb -->
            <div class="d-flex align-items-center mb-4">
                <a href="<?= BASEURL; ?>/pesanan" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="fa fa-arrow-left me-1"></i>Kembali
                </a>
                <h5 class="mb-0">
                    <i class="fa fa-file-pdf me-2 text-primary"></i>Cetak Laporan Keuangan
                </h5>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="bg-light rounded p-4">

                        <p class="text-muted mb-4">
                            Pilih rentang tanggal laporan yang ingin dicetak.
                            Data transaksi akan difilter berdasarkan
                            <strong>tanggal pengambilan pesanan</strong>.
                        </p>

                        <form action="<?= BASEURL; ?>/pesanan/cetakLaporan" method="GET" target="_blank">

                            <!-- Shortcut preset -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Cepat</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary preset-btn"
                                            data-preset="hari_ini">Hari Ini</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary preset-btn"
                                            data-preset="minggu_ini">Minggu Ini</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary preset-btn"
                                            data-preset="bulan_ini">Bulan Ini</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary preset-btn"
                                            data-preset="bulan_lalu">Bulan Lalu</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary preset-btn"
                                            data-preset="semua">Semua Data</button>
                                </div>
                            </div>

                            <hr>

                            <!-- Tanggal mulai & selesai -->
                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label for="tgl_mulai" class="form-label fw-semibold">
                                        Dari Tanggal <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="date" class="form-control" id="tgl_mulai"
                                           name="tgl_mulai"
                                           value="<?= date('Y-m-d'); ?>"
                                           max="<?= date('Y-m-d'); ?>"
                                           required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tgl_selesai" class="form-label fw-semibold">
                                        Sampai Tanggal <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="date" class="form-control" id="tgl_selesai"
                                           name="tgl_selesai"
                                           value="<?= date('Y-m-d'); ?>"
                                           max="<?= date('Y-m-d'); ?>"
                                           required>
                                </div>
                            </div>

                            <div id="preview-periode" class="alert alert-info py-2 small mb-4">
                                <i class="fa fa-info-circle me-1"></i>
                                Laporan akan dicetak untuk periode:
                                <strong id="preview-teks">
                                    <?= date('d/m/Y'); ?> s/d <?= date('d/m/Y'); ?>
                                </strong>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fa fa-print me-2"></i>Buka Pratinjau & Cetak
                            </button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    var tglMulai   = document.getElementById('tgl_mulai');
    var tglSelesai = document.getElementById('tgl_selesai');
    var preview    = document.getElementById('preview-teks');

    // Format Y-m-d ke dd/mm/yyyy untuk tampilan
    function fmt(ymd) {
        if (!ymd) return '-';
        var p = ymd.split('-');
        return p[2] + '/' + p[1] + '/' + p[0];
    }

    function updatePreview() {
        var m = tglMulai.value;
        var s = tglSelesai.value;
        if (m && s) {
            if (m === s) {
                preview.textContent = fmt(m) + ' (Hanya hari ini)';
            } else {
                preview.textContent = fmt(m) + ' s/d ' + fmt(s);
            }
        }
    }

    tglMulai.addEventListener('change', function () {
        // Pastikan tgl_selesai tidak lebih kecil dari tgl_mulai
        if (tglSelesai.value < tglMulai.value) {
            tglSelesai.value = tglMulai.value;
        }
        tglSelesai.min = tglMulai.value;
        updatePreview();
    });

    tglSelesai.addEventListener('change', updatePreview);

    // Preset buttons
    document.querySelectorAll('.preset-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var today  = new Date();
            var preset = this.dataset.preset;
            var mulai, selesai;

            if (preset === 'hari_ini') {
                mulai   = toYmd(today);
                selesai = toYmd(today);
            } else if (preset === 'minggu_ini') {
                var dow = today.getDay() === 0 ? 6 : today.getDay() - 1; // Senin=0
                var sen = new Date(today); sen.setDate(today.getDate() - dow);
                mulai   = toYmd(sen);
                selesai = toYmd(today);
            } else if (preset === 'bulan_ini') {
                mulai   = today.getFullYear() + '-' + pad(today.getMonth() + 1) + '-01';
                selesai = toYmd(today);
            } else if (preset === 'bulan_lalu') {
                var bl = new Date(today.getFullYear(), today.getMonth(), 0); // Hari terakhir bulan lalu
                var ba = new Date(today.getFullYear(), today.getMonth() - 1, 1); // Hari pertama bulan lalu
                mulai   = toYmd(ba);
                selesai = toYmd(bl);
            } else if (preset === 'semua') {
                mulai   = '2020-01-01';
                selesai = toYmd(today);
            }

            tglMulai.value   = mulai;
            tglSelesai.value = selesai;
            tglSelesai.min   = mulai;
            updatePreview();

            // Highlight tombol aktif
            document.querySelectorAll('.preset-btn').forEach(function (b) {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary', 'btn-outline-primary');
            this.classList.add('btn-primary');
        });
    });

    function toYmd(d) {
        return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
    }
    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    updatePreview();
})();
</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
