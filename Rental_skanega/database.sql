-- Create Database
CREATE DATABASE IF NOT EXISTS db_rental_skanega;
USE db_rental_skanega;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_status TINYINT NOT NULL COMMENT '1=Admin, 2=User',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Kendaraan
CREATE TABLE IF NOT EXISTS kendaraan (
    id_kendaraan INT AUTO_INCREMENT PRIMARY KEY,
    nama_kendaraan VARCHAR(100) NOT NULL,
    jenis VARCHAR(50) NOT NULL,
    plat_nomor VARCHAR(20) NOT NULL UNIQUE,
    pinjam_status TINYINT NOT NULL DEFAULT 1 COMMENT '1=Ready, 2=Dipinjam',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Pinjam
CREATE TABLE IF NOT EXISTS pinjam (
    id_pinjam INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_kendaraan INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_kendaraan) REFERENCES kendaraan(id_kendaraan) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Data Users
INSERT INTO users (username, password, user_status) VALUES
('admin', '$2y$10$YkNWXlFvWGxOblY3enRWReJQ8dVY5XW.K8BdVoHFO0bL1cGE1W9U6', 1),
('user1', '$2y$10$7n9Y8Z2X1W3V4U5T6S7R8P9O0N1M2L3K4J5I6H7G8F9E0D1C2B3A4', 2);

-- Insert Sample Data Kendaraan
INSERT INTO kendaraan (nama_kendaraan, jenis, plat_nomor, pinjam_status) VALUES
('Toyota Avanza', 'Mobil', 'B 1234 ABC', 1),
('Honda Jazz', 'Mobil', 'B 5678 DEF', 1),
('Suzuki Ertiga', 'Mobil', 'B 9012 GHI', 1),
('Honda CB150', 'Motor', 'B 3456 JKL', 1),
('Yamaha NMAX', 'Motor', 'B 7890 MNO', 1);

-- Catatan password:
-- admin: password123
-- user1: user123
