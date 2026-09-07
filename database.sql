CREATE DATABASE IF NOT EXISTS dimsum_cece;
USE dimsum_cece;

-- Tabel Users (Autentikasi Multi-role)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Pelanggan') NOT NULL DEFAULT 'Pelanggan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Produk (Manajemen Menu & Stok)
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL,
    stok INT NOT NULL,
    ukuran VARCHAR(30),
    kategori VARCHAR(50),
    foto VARCHAR(255) DEFAULT 'default.jpg'
);

-- Tabel Pesanan (Transaksi & Slot Waktu)
CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    tanggal_pesanan DATE NOT NULL,
    waktu_pengambilan DATETIME NOT NULL,
    fasilitas_tambahan VARCHAR(255),
    status_pembayaran ENUM('Belum Bayar', 'DP', 'Lunas') DEFAULT 'Belum Bayar',
    diskon INT DEFAULT 0,
    total_harga INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel Detail Pesanan (Rincian Item)
CREATE TABLE IF NOT EXISTS detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    id_produk INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan INT NOT NULL,
    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produk) REFERENCES produk(id) ON DELETE CASCADE
);

-- Akun Default untuk Login (Password: admin123 & user123)
INSERT IGNORE INTO users (id, username, email, password, role) VALUES 
(1, 'admin', 'admin@dimsumcece.com', '$2y$10$wK6FqG6wK9.yMhX8UeP.re2qU1K/A8GByRmd7V0f2Q8H7kObyq2fS', 'Admin'),
(2, 'pelanggan', 'pelanggan@gmail.com', '$2y$10$2HBlm4CunDq0o6hC862Ioej8V7wA1Dox9z7B97rK9.V86wA87E8m.', 'Pelanggan');

-- Data Dummy Produk Dimsum
INSERT IGNORE INTO produk (id, nama_produk, deskripsi, harga, stok, ukuran, kategori) VALUES 
(1, 'Dimsum Ayam Premium', 'Dimsum ayam isi 4 pcs dengan saus merah pedas manis.', 15000, 50, 'Reguler', 'Makanan'),
(2, 'Dimsum Udang Keju', 'Dimsum udang dengan lelehan keju mozzarella di atasnya, isi 3 pcs.', 20000, 30, 'Large', 'Makanan');
