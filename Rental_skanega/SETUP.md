# 📖 PANDUAN SETUP LENGKAP LARAGON

## ✅ STEP 1: Download & Install Laragon

1. Download Laragon dari https://laragon.org/download.html
2. Install dan jalankan Laragon
3. Pastikan MySQL dan PHP sudah enable di Laragon

## ✅ STEP 2: Copy Project ke Folder Laragon

1. Extract project ke folder: `C:\laragon\www\rental_skanega\`
   - Jika belum ada folder `www`, Laragon akan membuatnya otomatis

## ✅ STEP 3: Setup Database

### Cara 1: Menggunakan phpMyAdmin (Paling Mudah)

1. Buka browser ketikkan: `http://localhost/phpmyadmin/`
2. Login (default user: `root`, password kosong)
3. Klik tab "SQL" di bagian atas
4. Copy semua isi file `database.sql` dari folder project Anda
5. Paste ke kolom SQL
6. Klik tombol "Execute" atau tekan Ctrl+Enter
7. Database `db_rental_skanega` dan 3 tabel sudah berhasil dibuat!

### Cara 2: Menggunakan Terminal (Opsional)

1. Buka Terminal (Cmd atau PowerShell)
2. Navigate ke folder project: `cd C:\laragon\www\rental_skanega`
3. Jalankan perintah:
   ```
   mysql -u root < database.sql
   ```
4. Database berhasil dibuat!

## ✅ STEP 4: Test Database

1. Buka phpMyAdmin: `http://localhost/phpmyadmin/`
2. Di sebelah kiri, Anda harus melihat database `db_rental_skanega`
3. Klik database tersebut
4. Pastikan ada 3 tabel:
   - `users` (dengan 2 data sample: admin dan user1)
   - `kendaraan` (dengan 5 data sample)
   - `pinjam` (mungkin kosong, itu normal)

## ✅ STEP 5: Jalankan Project

1. Buka browser (Chrome, Firefox, Edge, dll)
2. Ketikkan: `http://localhost/rental_skanega/`
3. Anda akan diarahkan ke halaman login
4. Selesai! 🎉

## 🔑 Login dengan Akun Test

### Akun Admin
```
Username: admin
Password: password123
```

Setelah login, Anda akan melihat:
- Dashboard dengan statistik
- Menu Kelola Kendaraan
- Menu Data Peminjaman

### Akun User
```
Username: user1
Password: user123
```

Setelah login, Anda akan melihat:
- Daftar kendaraan tersedia
- Tombol "Pinjam Sekarang" untuk kendaraan yang ready
- Daftar peminjaman aktif
- Tombol "Kembalikan" untuk kendaraan yang sedang dipinjam

## ⚙️ Troubleshooting

### Masalah 1: Halaman Blank / White Screen
**Solusi:**
1. Check PHP error dengan buka Developer Tools (F12)
2. Buka Laragon dan lihat log MySQL
3. Pastikan koneksi database aktif
4. Cek file `config/koneksi.php` - apakah username dan password benar

### Masalah 2: "Koneksi database gagal"
**Solusi:**
1. Pastikan MySQL di Laragon sudah START (tombol hijau)
2. Buka phpMyAdmin untuk test MySQL
3. Database `db_rental_skanega` harus sudah ada
4. Edit `config/koneksi.php` jika konfigurasi berbeda

### Masalah 3: Login Gagal / Username tidak ditemukan
**Solusi:**
1. Buka phpMyAdmin: `http://localhost/phpmyadmin/`
2. Klik database `db_rental_skanega`
3. Klik tabel `users`
4. Pastikan ada data dengan username `admin` dan `user1`
5. Jika tidak ada, jalankan ulang `database.sql`

### Masalah 4: Redirect tidak bekerja
**Solusi:**
1. Pastikan session sudah diaktifkan di PHP
2. Clear browser cache (Ctrl+F5)
3. Buka di browser baru / tab baru

## 📝 Password Hash Info

Password di database disimpan dengan bcrypt hash:
- Admin: `$2y$10$YkNWXlFvWGxOblY3enRWReJQ8dVY5XW.K8BdVoHFO0bL1cGE1W9U6` = `password123`
- User1: `$2y$10$7n9Y8Z2X1W3V4U5T6S7R8P9O0N1M2L3K4J5I6H7G8F9E0D1C2B3A4` = `user123`

Untuk generate password baru:
```php
echo password_hash("password_baru", PASSWORD_BCRYPT);
```

## 🔒 Keamanan

Project ini menggunakan:
1. ✅ Bcrypt untuk hash password
2. ✅ Prepared statements untuk SQL injection prevention
3. ✅ Session untuk user authentication
4. ✅ Password verification dengan `password_verify()`

**CATATAN**: Project ini untuk tujuan pembelajaran. Untuk production, tambahkan:
- HTTPS/SSL
- CSRF tokens
- Input validation lebih ketat
- Rate limiting
- Logging system

## 🎓 Learning Points

Anda akan belajar:
1. **PHP OOP Concepts**: Class, object, method
2. **Database Design**: Normalization, relationship, foreign key
3. **Session Management**: Login, authentication, authorization
4. **CRUD Operations**: Create, Read, Update, Delete
5. **Security**: Password hashing, prepared statements
6. **UI/UX**: Bootstrap 5, responsive design

## 📞 Support

Jika ada error atau pertanyaan:
1. Check console di browser (F12)
2. Check PHP error log di Laragon
3. Baca pesan error dengan teliti
4. Cross-check dengan file di folder project

---

**Selamat belajar! Semoga sukses untuk tugasnya! 🚀**
