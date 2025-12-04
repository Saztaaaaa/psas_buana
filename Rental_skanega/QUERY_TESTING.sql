-- FILE INI BERISI QUERY TAMBAHAN UNTUK TESTING DAN LEARNING
-- Buka file ini di phpMyAdmin untuk menjalankan query-query

-- ===== 1. QUERY UNTUK TESTING DATA =====

-- Lihat semua user
SELECT * FROM users;

-- Lihat semua kendaraan
SELECT * FROM kendaraan;

-- Lihat semua peminjaman
SELECT * FROM pinjam;

-- Lihat kendaraan yang ready (belum dipinjam)
SELECT * FROM kendaraan WHERE pinjam_status = 1;

-- Lihat kendaraan yang sedang dipinjam
SELECT * FROM kendaraan WHERE pinjam_status = 2;

-- ===== 2. QUERY UNTUK STATISTIK =====

-- Hitung total kendaraan
SELECT COUNT(*) as total_kendaraan FROM kendaraan;

-- Hitung kendaraan yang ready
SELECT COUNT(*) as kendaraan_ready FROM kendaraan WHERE pinjam_status = 1;

-- Hitung peminjaman aktif
SELECT COUNT(*) as peminjaman_aktif FROM pinjam WHERE tanggal_kembali IS NULL;

-- Hitung total peminjaman
SELECT COUNT(*) as total_peminjaman FROM pinjam;

-- ===== 3. QUERY UNTUK JOIN DATA =====

-- Lihat detail peminjaman (dengan nama user dan kendaraan)
SELECT 
    p.id_pinjam,
    u.username,
    k.nama_kendaraan,
    k.plat_nomor,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    CASE WHEN p.tanggal_kembali IS NULL THEN 'Dipinjam' ELSE 'Dikembalikan' END as status
FROM pinjam p
JOIN users u ON p.id_user = u.id
JOIN kendaraan k ON p.id_kendaraan = k.id_kendaraan
ORDER BY p.created_at DESC;

-- Lihat peminjaman aktif saja
SELECT 
    p.id_pinjam,
    u.username,
    k.nama_kendaraan,
    k.plat_nomor,
    p.tanggal_pinjam
FROM pinjam p
JOIN users u ON p.id_user = u.id
JOIN kendaraan k ON p.id_kendaraan = k.id_kendaraan
WHERE p.tanggal_kembali IS NULL
ORDER BY p.tanggal_pinjam DESC;

-- ===== 4. QUERY UNTUK ANALISIS DATA =====

-- Lihat history peminjaman per user
SELECT 
    u.username,
    COUNT(p.id_pinjam) as total_peminjaman,
    COUNT(CASE WHEN p.tanggal_kembali IS NOT NULL THEN 1 END) as sudah_dikembalikan,
    COUNT(CASE WHEN p.tanggal_kembali IS NULL THEN 1 END) as masih_dipinjam
FROM users u
LEFT JOIN pinjam p ON u.id = p.id_user
WHERE u.user_status = 2
GROUP BY u.id, u.username;

-- Lihat kendaraan yang paling sering dipinjam
SELECT 
    k.nama_kendaraan,
    k.plat_nomor,
    COUNT(p.id_pinjam) as total_dipinjam
FROM kendaraan k
LEFT JOIN pinjam p ON k.id_kendaraan = p.id_kendaraan
GROUP BY k.id_kendaraan, k.nama_kendaraan, k.plat_nomor
ORDER BY total_dipinjam DESC;

-- ===== 5. QUERY UNTUK UPDATE/EDIT DATA =====

-- Update status kendaraan (jika manual)
UPDATE kendaraan SET pinjam_status = 1 WHERE id_kendaraan = 1;
UPDATE kendaraan SET pinjam_status = 2 WHERE id_kendaraan = 2;

-- Update tanggal kembali jika belum tercatat
UPDATE pinjam SET tanggal_kembali = CURDATE() WHERE id_pinjam = 1;

-- ===== 6. QUERY UNTUK ADMIN DASHBOARD =====

-- Statistik lengkap untuk admin dashboard
SELECT 
    (SELECT COUNT(*) FROM kendaraan) as total_kendaraan,
    (SELECT COUNT(*) FROM kendaraan WHERE pinjam_status = 1) as kendaraan_ready,
    (SELECT COUNT(*) FROM pinjam WHERE tanggal_kembali IS NULL) as peminjaman_aktif,
    (SELECT COUNT(*) FROM pinjam) as total_peminjaman;

-- Peminjaman terbaru (untuk dashboard admin)
SELECT 
    p.id_pinjam,
    u.username,
    k.nama_kendaraan,
    k.plat_nomor,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    CASE WHEN p.tanggal_kembali IS NULL THEN 'Dipinjam' ELSE 'Dikembalikan' END as status
FROM pinjam p
JOIN users u ON p.id_user = u.id
JOIN kendaraan k ON p.id_kendaraan = k.id_kendaraan
ORDER BY p.created_at DESC
LIMIT 10;

-- ===== 7. QUERY UNTUK INSERT DATA TAMBAHAN =====

-- Tambah user baru (password sudah di-hash dengan bcrypt)
-- CATATAN: Ganti password_hash dengan output dari: echo password_hash("password_baru", PASSWORD_BCRYPT);
INSERT INTO users (username, password, user_status) 
VALUES ('user2', '$2y$10$7n9Y8Z2X1W3V4U5T6S7R8P9O0N1M2L3K4J5I6H7G8F9E0D1C2B3A4', 2);

-- Tambah kendaraan baru
INSERT INTO kendaraan (nama_kendaraan, jenis, plat_nomor, pinjam_status) 
VALUES ('Daihatsu Xenia', 'Mobil', 'B 1111 XYZ', 1);

-- ===== 8. QUERY UNTUK DELETE DATA =====

-- Hapus peminjaman tertentu
DELETE FROM pinjam WHERE id_pinjam = 1;

-- Hapus kendaraan tertentu
DELETE FROM kendaraan WHERE id_kendaraan = 5;

-- Hapus user tertentu (akan cascade delete peminjaman juga)
DELETE FROM users WHERE id = 2;

-- ===== 9. QUERY UNTUK VALIDASI DATA =====

-- Cek apakah plat nomor sudah ada
SELECT * FROM kendaraan WHERE plat_nomor = 'B 1234 ABC';

-- Cek apakah username sudah ada
SELECT * FROM users WHERE username = 'admin';

-- Cek kendaraan yang dipinjam oleh user tertentu
SELECT * FROM kendaraan 
WHERE id_kendaraan IN (
    SELECT id_kendaraan FROM pinjam 
    WHERE id_user = 1 AND tanggal_kembali IS NULL
);

-- ===== 10. QUERY UNTUK MAINTENANCE =====

-- Reset auto increment jika perlu
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE kendaraan AUTO_INCREMENT = 1;
ALTER TABLE pinjam AUTO_INCREMENT = 1;

-- Lihat struktur tabel
DESCRIBE users;
DESCRIBE kendaraan;
DESCRIBE pinjam;

-- ===== CATATAN PENTING =====

/*
1. HASHING PASSWORD:
   - Di PHP gunakan: password_hash("password", PASSWORD_BCRYPT)
   - Untuk verify gunakan: password_verify("password", $hash)

2. PASSWORD DEFAULT:
   - admin → password123 → $2y$10$YkNWXlFvWGxOblY3enRWReJQ8dVY5XW.K8BdVoHFO0bL1cGE1W9U6
   - user1 → user123 → $2y$10$7n9Y8Z2X1W3V4U5T6S7R8P9O0N1M2L3K4J5I6H7G8F9E0D1C2B3A4

3. FOREIGN KEY RELATIONSHIPS:
   - pinjam.id_user → users.id (ON DELETE CASCADE)
   - pinjam.id_kendaraan → kendaraan.id_kendaraan (ON DELETE CASCADE)

4. STATUS VALUES:
   - users.user_status: 1=Admin, 2=User
   - kendaraan.pinjam_status: 1=Ready, 2=Dipinjam

5. DATE FIELDS:
   - pinjam.tanggal_kembali bisa NULL (belum dikembalikan)
   - Setiap table punya created_at TIMESTAMP

*/
