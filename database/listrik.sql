CREATE DATABASE IF NOT EXISTS my_listrik;
USE my_listrik;

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','user') DEFAULT 'user'
);

-- Tabel pelanggan
CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    no_kwh VARCHAR(20) UNIQUE,
    nama_pelanggan VARCHAR(100),
    alamat TEXT,
    daya INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel pemakaian
CREATE TABLE pemakaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id INT,
    bulan VARCHAR(20),
    tahun INT,
    meter_awal INT,
    meter_akhir INT,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

-- Tabel tagihan
CREATE TABLE tagihan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pemakaian_id INT,
    jumlah_kwh INT,
    total_bayar DECIMAL(12,2),
    status ENUM('belum dibayar','lunas') DEFAULT 'belum dibayar',
    FOREIGN KEY (pemakaian_id) REFERENCES pemakaian(id)
);

-- Admin awal
INSERT INTO users (nama, username, password, role)
VALUES ('Administrator', 'admin', MD5('admin123'), 'admin');
