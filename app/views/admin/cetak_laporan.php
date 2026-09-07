<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Keuangan_Dimsum_Cece_<?= $label_periode_file; ?></title>
    <link href="<?= BASEURL; ?>/../admin/dashmin-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body        { background:#fff; color:#000; font-family:'Times New Roman', Times, serif; }
        .line-dan-kop { border-top:3px double #000; margin-top:10px; margin-bottom:20px; }
        .card-stat  { border:1px solid #000; padding:15px; border-radius:5px; text-align:center; background:#f9f9f9; }
        .badge-status { padding:3px 8px; border-radius:4px; font-size:.78rem; font-weight:600; }
        .status-selesai   { background:#d1fae5; color:#065f46; }
        .status-diproses  { background:#dbeafe; color:#1e40af; }
        .status-menunggu  { background:#fef9c3; color:#713f12; }
        .status-batal     { background:#fee2e2; color:#991b1b; }
        .status-siap      { background:#ede9fe; color:#4c1d95; }

        @media print {
            .no-print { display:none !important; }
            body { font-size:11pt; }
            .card-stat { background:#fff !important; border:1px solid #000 !important; }
            table { font-size:10pt; }
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Toolbar (hanya tampil di layar, tidak ikut cetak) -->
    <div class="no-print d-flex justify-content-between align-items-center mb-4 bg-light p-3 rounded border">
        <a href="<?= BASEURL; ?>/pesanan/filterLaporan" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i>Ubah Periode
        </a>
        <div class="text-center">
            <span class="badge bg-primary fs-6">
                Periode: <?= htmlspecialchars($label_periode); ?>
            </span>
        </div>
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="fa fa-print me-1"></i>Cetak / Simpan PDF
        </button>
    </div>

    <!-- KOP SURAT -->
    <div class="text-center">
        <h2><strong>DIMSUM CECE PEKANBARU</strong></h2>
        <p class="mb-0">Sistem Informasi Reservasi dan Manajemen Pemesanan Berbasis Web</p>
        <p class="text-muted small">Mutiara Purwodadi, Kecamatan Panam, Kota Pekanbaru, Riau</p>
        <div class="line-dan-kop"></div>
    </div>

    <h4 class="text-center mb-1 text-uppercase">
        <strong>Laporan Rekapitulasi Pendapatan &amp; Transaksi</strong>
    </h4>
    <p class="text-center mb-1">
        Periode: <strong><?= htmlspecialchars($label_periode); ?></strong>
    </p>
    <p class="text-end mb-4 small text-muted">
        Dicetak pada: <strong><?= date('d F Y, H:i'); ?> WIB</strong>
        &nbsp;|&nbsp; Oleh: <strong><?= htmlspecialchars($_SESSION['nama']); ?></strong>
    </p>

    <!-- STATISTIK RINGKAS -->
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="card-stat">
                <h6><strong>Total Omzet Bersih</strong></h6>
                <h3 class="text-success mt-2">
                    <strong>Rp <?= number_format($stat['omzet'] ?? 0, 0, ',', '.'); ?></strong>
                </h3>
                <small class="text-muted">Dari Pesanan Selesai</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card-stat">
                <h6><strong>Pesanan Berhasil</strong></h6>
                <h3 class="text-primary mt-2">
                    <strong><?= (int)($stat['total_sukses'] ?? 0); ?> Transaksi</strong>
                </h3>
                <small class="text-muted">Status: Selesai</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card-stat">
                <h6><strong>Pending / Batal</strong></h6>
                <h3 class="text-dark mt-2">
                    <strong>
                        <?= (int)($statTambahan['total_pending'] ?? 0); ?>
                        /
                        <?= (int)($statTambahan['total_batal'] ?? 0); ?>
                    </strong>
                </h3>
                <small class="text-muted">Diproses / Dibatalkan</small>
            </div>
        </div>
    </div>

    <!-- TABEL TRANSAKSI -->
    <table class="table table-bordered align-middle text-center small">
        <thead class="table-light border-dark">
            <tr>
                <th style="width:70px">ID Order</th>
                <th class="text-start">Nama Pelanggan</th>
                <th>Tgl Pengambilan</th>
                <th>Jam</th>
                <th class="text-end">Total Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan_data)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        Tidak ada data transaksi pada periode
                        <strong><?= htmlspecialchars($label_periode); ?></strong>.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($laporan_data as $data): ?>
                    <?php
                    $st     = $data['status_pesanan'];
                    $cls    = 'status-menunggu';
                    if ($st === 'Selesai')              $cls = 'status-selesai';
                    elseif ($st === 'Diproses')         $cls = 'status-diproses';
                    elseif ($st === 'Batal')            $cls = 'status-batal';
                    elseif ($st === 'Siap Diambil')     $cls = 'status-siap';
                    ?>
                    <tr>
                        <td>#DC-<?= $data['id']; ?></td>
                        <td class="text-start"><?= htmlspecialchars($data['nama']); ?></td>
                        <td><?= date('d/m/Y', strtotime($data['tanggal_pengambilan'])); ?></td>
                        <td><?= substr($data['jam_pengambilan'], 0, 5); ?> WIB</td>
                        <td class="text-end fw-bold">
                            Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?>
                        </td>
                        <td>
                            <span class="badge-status <?= $cls; ?>"><?= htmlspecialchars($st); ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- Baris total -->
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">
                        Total Seluruh Transaksi (<?= count($laporan_data); ?> pesanan):
                    </td>
                    <td class="text-end text-success">
                        Rp <?= number_format(array_sum(array_column($laporan_data, 'total_harga')), 0, ',', '.'); ?>
                    </td>
                    <td></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="row mt-5 pt-3">
        <div class="col-7">
            <p class="small text-muted mb-0">
                Dokumen ini diterbitkan secara otomatis oleh sistem.<br>
                Laporan mencakup pesanan dengan tanggal pengambilan
                <strong><?= htmlspecialchars($label_periode); ?></strong>.
            </p>
        </div>
        <div class="col-5 text-center">
            <p class="mb-5">
                Pekanbaru, <?= date('d F Y'); ?><br>
                <strong>Manager Dimsum Cece</strong>
            </p>
            <br>
            <p class="mb-0"><u>________________________________</u></p>
            <p class="text-muted small mt-1">Tanda Tangan &amp; Stempel</p>
        </div>
    </div>

</div>
</body>
</html>
