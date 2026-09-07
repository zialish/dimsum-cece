# AI.md

# Sistem Informasi Tata Kelola UMKM Dimsum Cece Berbasis Web

## Deskripsi Project

Project ini merupakan Sistem Informasi Tata Kelola UMKM Dimsum Cece Berbasis Web yang dikembangkan sebagai proyek mata kuliah Rekayasa Perangkat Lunak Program Studi Sistem Informasi Politeknik Caltex Riau.

Tujuan utama sistem adalah mengotomatisasi proses pemesanan, pengelolaan produk, pengelolaan stok, reservasi waktu pengambilan pesanan, transaksi, notifikasi, dan pelaporan yang sebelumnya dilakukan secara manual.

Sistem dibangun menggunakan:

* PHP Native
* MySQL
* HTML5
* CSS3
* Bootstrap 5
* JavaScript
* PHPMailer
* FullCalendar.js

Sistem menerapkan:

* Three Tier Architecture
* MVC (Model View Controller)

---

# Identitas UMKM

Nama UMKM : Dimsum Cece

Bidang Usaha : Kuliner

Produk :

* Dimsum Original
* Dimsum Premium
* Frozen Dimsum
* Paket Dimsum
* Produk Promo

Target Pengguna :

1. Administrator
2. Pelanggan

---

# Tujuan Sistem

Sistem dibuat untuk:

1. Mengelola pemesanan dimsum secara digital.
2. Mengelola stok produk secara real-time.
3. Mengelola jadwal pengambilan pesanan.
4. Menghindari double booking slot waktu.
5. Mengirim notifikasi otomatis kepada pelanggan.
6. Menyediakan laporan penjualan dan transaksi.
7. Mempermudah pengelolaan UMKM Dimsum Cece.

---

# Arsitektur Sistem

## Presentation Layer

Teknologi:

* HTML5
* CSS3
* Bootstrap 5
* JavaScript
* jQuery

Template Frontend:

Fruitables

Digunakan untuk:

* Homepage
* Daftar Produk
* Detail Produk
* Login Customer
* Registrasi
* Keranjang
* Checkout
* Riwayat Pemesanan

---

## Application Layer

Teknologi:

PHP Native

Pola:

MVC (Model View Controller)

Tanggung Jawab:

* Autentikasi
* Validasi
* Pemesanan
* Reservasi
* Pengelolaan Stok
* Pengiriman Email
* Pembuatan Laporan

---

## Data Layer

Teknologi:

MySQL

Tanggung Jawab:

* Penyimpanan Data
* Relasi Database
* Pengelolaan Transaksi

---

# Template Yang Digunakan

## Customer Area

Folder:

fruitables-1.0.0

Digunakan untuk:

* Landing Page
* Produk
* Checkout
* Riwayat Pesanan

---

## Admin Area

Folder:

admin/dashmin-1.0.0

Digunakan untuk:

* Dashboard
* Manajemen Produk
* Manajemen Pesanan
* Manajemen Pengguna
* Laporan

---

# Aktor Sistem

## Administrator

Hak Akses:

* Login
* Logout
* Dashboard
* CRUD Produk
* CRUD Kategori
* Kelola Stok
* Kelola Pesanan
* Kelola Pembayaran
* Kelola Reservasi
* Kelola Diskon
* Kelola Pengguna
* Kelola Notifikasi
* Lihat Laporan
* Cetak Laporan

---

## Pelanggan

Hak Akses:

* Registrasi
* Login
* Logout
* Melihat Produk
* Mencari Produk
* Melakukan Pemesanan
* Memilih Slot Waktu
* Melihat Kalender Ketersediaan
* Mengubah Pesanan (minimal H-1)
* Membatalkan Pesanan (minimal H-1)
* Melihat Riwayat Transaksi
* Melihat Status Pesanan

---

# Kebutuhan Fungsional Sistem

## Modul Autentikasi

Fitur:

* Login
* Registrasi
* Logout
* Session Management
* Role Management

Role:

* Admin
* Customer

---

## Modul Produk

Admin dapat:

* Menambah Produk
* Mengubah Produk
* Menghapus Produk
* Mengatur Stok
* Mengatur Harga
* Mengunggah Foto Produk

Customer dapat:

* Melihat Produk
* Melihat Detail Produk
* Mencari Produk

Data Produk:

* Nama Produk
* Deskripsi
* Harga
* Stok
* Ukuran
* Foto
* Kategori

---

## Modul Reservasi dan Pemesanan

Customer dapat:

* Memilih Produk
* Menentukan Jumlah
* Menentukan Tanggal Pengambilan
* Menentukan Jam Pengambilan
* Menambahkan Catatan
* Memilih Fasilitas Tambahan

Sistem harus:

* Mengecek stok otomatis
* Mengecek slot waktu otomatis
* Menolak slot penuh
* Menolak stok habis

Status Pesanan:

* Menunggu Pembayaran
* Diproses
* Siap Diambil
* Selesai
* Dibatalkan

---

## Modul Kalender

Menggunakan:

FullCalendar.js

Fitur:

* Menampilkan slot waktu tersedia
* Menampilkan kepadatan jadwal
* Mencegah double booking
* Menampilkan jadwal harian

---

## Modul Pembayaran

Status:

* Belum Bayar
* DP
* Lunas

Fitur:

* Upload Bukti Pembayaran
* Verifikasi Pembayaran
* Diskon Pesanan
* Riwayat Pembayaran

---

## Modul Notifikasi

Menggunakan:

PHPMailer + SMTP

Jenis Notifikasi:

* Email Konfirmasi Pemesanan
* Email Pengingat H-1
* Email Perubahan Status Pesanan

---

## Modul Riwayat Transaksi

Customer dapat:

* Melihat seluruh riwayat transaksi
* Melihat detail pesanan
* Melihat status pembayaran

---

## Modul Laporan

Admin dapat:

* Laporan Harian
* Laporan Mingguan
* Laporan Bulanan

Isi Laporan:

* Total Pesanan
* Total Pendapatan
* Produk Terlaris
* Produk Stok Menipis
* Jumlah Pelanggan

Output:

* Tabel
* Cetak PDF

---

## 📁 Struktur Folder MVC

```text
project-root/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ProdukController.php
│   │   ├── PesananController.php
│   │   ├── ReservasiController.php
│   │   ├── PembayaranController.php
│   │   └── LaporanController.php
│   │
│   ├── models/
│   │   ├── UserModel.php
│   │   ├── ProdukModel.php
│   │   ├── KategoriModel.php
│   │   ├── PesananModel.php
│   │   ├── DetailPesananModel.php
│   │   ├── ReservasiModel.php
│   │   ├── PembayaranModel.php
│   │   └── NotifikasiModel.php
│   │
│   ├── views/
│   │   ├── customer/
│   │   └── admin/
│   │
│   ├── config/
│   ├── helpers/
│   └── middleware/
│
├── public/
│   ├── assets/
│   └── uploads/
│
├── database/
│   └── dimsum_cece.sql
│
├── admin/
├── dashmin-1.0.0/
├── fruitables-1.0.0/
├── index.php
├── login.php
├── logout.php
├── koneksi.php
└── README.md
```

# Standar Pengembangan

AI wajib mengikuti aturan berikut:

1. Selalu menggunakan MVC.
2. Tidak boleh menulis query database di View.
3. Query database hanya berada di Model.
4. Controller hanya mengatur alur aplikasi.
5. View hanya menampilkan data.
6. Menggunakan Prepared Statement.
7. Menggunakan password_hash().
8. Menggunakan password_verify().
9. Menggunakan Session Authentication.
10. Menggunakan Bootstrap 5.
11. Mengikuti standar PSR-12.
12. Kode harus terdokumentasi.

---

# Kebutuhan Non Fungsional

Performance

* Waktu loading < 3 detik
* Query database < 1 detik

Security

* Password Hash
* Prepared Statement
* Session Timeout 30 Menit

Usability

* Responsive Design
* Mobile Friendly

Reliability

* Error Handling
* Validasi Data

Compatibility

* Chrome
* Firefox
* Edge
* Safari

Maintainability

* MVC
* Modular
* Reusable Code

Accessibility

* Alt Text
* Keyboard Navigation
* Responsive Layout

---

# Prioritas Pengembangan

Tahap 1

* Database
* Login
* Registrasi
* Role

Tahap 2

* CRUD Produk
* CRUD Kategori
* Upload Gambar

Tahap 3

* Pemesanan
* Keranjang
* Checkout

Tahap 4

* Kalender Reservasi
* Slot Waktu
* Double Booking Validation

Tahap 5

* Pembayaran
* Notifikasi Email

Tahap 6

* Dashboard Admin
* Laporan

Tahap 7

* Pengujian
* Dokumentasi

---

