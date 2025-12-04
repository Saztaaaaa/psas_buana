# 🚀 QUICK START GUIDE

Panduan cepat untuk langsung menggunakan Sistem Rental Kendaraan!

---

## ⚡ 3 LANGKAH MUDAH

### 1️⃣ SETUP DATABASE (2 menit)

**Pilih salah satu:**

#### Cara A: phpMyAdmin
```
1. Buka http://localhost/phpmyadmin/
2. Login (root / kosong)
3. Klik "SQL" di tab atas
4. Copy-paste isi file "database.sql"
5. Klik "Execute" 
6. ✅ SELESAI!
```

#### Cara B: Terminal
```powershell
cd C:\laragon\www\rental_skanega
mysql -u root < database.sql
```

### 2️⃣ JALANKAN PROJECT (1 menit)

```
Buka browser → ketikkan: http://localhost/rental_skanega/
✅ Halaman login terbuka!
```

### 3️⃣ LOGIN & EXPLORE (1 menit)

```
Pilih akun:
├── Admin: admin / password123
└── User: user1 / user123
```

---

## 🎯 QUICK COMMANDS

### Admin Tasks

| Tujuan | Langkah |
|--------|---------|
| Lihat dashboard | Login → otomatis ke dashboard |
| Tambah kendaraan | Menu "Tambah Kendaraan" → isi form → Simpan |
| Edit kendaraan | Menu "Kelola Kendaraan" → Edit → ubah → Update |
| Hapus kendaraan | Menu "Kelola Kendaraan" → Hapus → Confirm |
| Lihat peminjaman | Menu "Data Peminjaman" → lihat tabel |
| Logout | Tombol "Logout" di sidebar |

### User Tasks

| Tujuan | Langkah |
|--------|---------|
| Lihat kendaraan | Login → otomatis ke dashboard |
| Pinjam kendaraan | Scroll ke "Kendaraan Tersedia" → Klik "Pinjam Sekarang" |
| Kembalikan kendaraan | Lihat "Peminjaman Aktif" → Klik "Kembalikan" |
| Lihat peminjaman aktif | Di dashboard → bagian "Peminjaman Aktif" |
| Logout | Tombol "Logout" di navbar |

---

## 📂 FILE STRUCTURE

```
rental_skanega/
├── 📄 index.php               ← Mulai dari sini!
├── 📄 database.sql            ← Setup database
├── 📄 README.md               ← Dokumentasi lengkap
├── 📄 SETUP.md                ← Panduan setup Laragon
├── 📄 CHECKLIST.md            ← Checklist fitur
├── 📄 QUERY_TESTING.sql       ← Query contoh
├── 📄 DATABASE_SCHEMA.md      ← ERD & schema
│
├── 📁 config/
│   └── koneksi.php            ← Koneksi database
│
├── 📁 views/
│   ├── login.php              ← Form login
│   ├── 📁 admin/
│   │   ├── index.php          ← Dashboard admin
│   │   └── peminjaman.php     ← Data peminjaman
│   ├── 📁 user/
│   │   └── index.php          ← Dashboard user
│   └── 📁 kendaraan/
│       ├── index.php          ← List kendaraan
│       ├── tambah.php         ← Form tambah
│       └── edit.php           ← Form edit
│
├── 📁 proses/
│   ├── login.php              ← Proses login
│   ├── logout.php             ← Proses logout
│   ├── pinjam.php             ← Proses pinjam
│   └── kembali.php            ← Proses kembalikan
│
└── 📁 assets/                 ← Folder CSS, JS (kosong)
```

---

## 🔑 AKUN TEST

### Admin Account
```
URL: http://localhost/rental_skanega/
Username: admin
Password: password123
Role: Administrator
```

**Akses:**
- Dashboard dengan statistik
- CRUD Kendaraan
- Lihat semua peminjaman
- Manage status kendaraan

### User Account
```
URL: http://localhost/rental_skanega/
Username: user1
Password: user123
Role: Regular User
```

**Akses:**
- Dashboard dengan kendaraan
- Pinjam kendaraan (status Ready)
- Lihat peminjaman aktif
- Kembalikan kendaraan

---

## 🧪 TEST SCENARIOS

### Test 1: Login Admin
```
✅ Buka: http://localhost/rental_skanega/
✅ Input: admin / password123
✅ Result: Redirect ke admin dashboard
```

### Test 2: Login User
```
✅ Buka: http://localhost/rental_skanega/
✅ Input: user1 / user123
✅ Result: Redirect ke user dashboard
```

### Test 3: Pinjam Kendaraan
```
✅ Login sebagai user1
✅ Lihat "Kendaraan Tersedia"
✅ Klik "Pinjam Sekarang" di kendaraan yang Ready
✅ Result: Muncul di "Peminjaman Aktif" & status berubah Dipinjam
```

### Test 4: Kembalikan Kendaraan
```
✅ Login sebagai user1
✅ Lihat "Peminjaman Aktif"
✅ Klik "Kembalikan"
✅ Result: Hilang dari peminjaman aktif & status berubah Ready
```

### Test 5: CRUD Kendaraan
```
✅ Login sebagai admin
✅ Klik "Tambah Kendaraan" → isi form → Simpan
✅ Result: Kendaraan muncul di list
✅ Klik "Edit" → ubah data → Update
✅ Result: Data terupdate
✅ Klik "Hapus" → confirm
✅ Result: Kendaraan hilang dari list
```

---

## ⚙️ TECHNICAL STACK

| Layer | Technology |
|-------|-----------|
| Frontend | HTML5, CSS3, Bootstrap 5, JavaScript |
| Backend | PHP 7.4+ |
| Database | MySQL 5.7+ |
| Security | Bcrypt Hash, Sessions, Prepared Statements |
| Server | Apache (Laragon) |

---

## 📋 TABEL DATABASE

### users
```sql
id (PK) | username | password (hash) | user_status
1       | admin    | bcrypt...       | 1
2       | user1    | bcrypt...       | 2
```

### kendaraan
```sql
id_kendaraan (PK) | nama_kendaraan | jenis | plat_nomor | pinjam_status
1                 | Toyota Avanza  | Mobil | B 1234 ABC | 1 (Ready)
2                 | Honda CB150    | Motor | B 3456 JKL | 2 (Dipinjam)
```

### pinjam
```sql
id_pinjam (PK) | id_user | id_kendaraan | tanggal_pinjam | tanggal_kembali
1              | 2       | 1            | 2025-12-01     | NULL (masih dipinjam)
2              | 2       | 3            | 2025-11-28     | 2025-11-30
```

---

## 🔧 CONFIG

### File: config/koneksi.php
```php
$host = 'localhost';      // Alamat server MySQL
$username = 'root';       // Username MySQL
$password = '';           // Password MySQL (kosong)
$database = 'db_rental_skanega';  // Nama database
```

**Jika berbeda, edit file ini!**

---

## 📚 FITUR UTAMA

### ✅ Implemented Features
- [x] Login dengan session
- [x] Password hashing dengan bcrypt
- [x] Role-based access (Admin/User)
- [x] CRUD Kendaraan (Admin only)
- [x] Pinjam kendaraan (User)
- [x] Kembalikan kendaraan (User)
- [x] Status tracking otomatis
- [x] Dashboard dengan statistik
- [x] Responsive UI dengan Bootstrap 5
- [x] Data peminjaman history

### 🎨 UI Components
- Sidebar navigation (Admin)
- Top navbar (User)
- Status badges
- Alert notifications
- Form validation
- Responsive cards

---

## ⚠️ COMMON ISSUES & FIXES

| Issue | Cause | Solution |
|-------|-------|----------|
| Koneksi gagal | MySQL tidak jalan | Start MySQL di Laragon |
| Login gagal | Database belum setup | Jalankan database.sql |
| Redirect error | Session issue | Clear browser cache (Ctrl+F5) |
| Blank page | PHP error | Open DevTools (F12) |
| 404 Not Found | Path salah | Pastikan folder di www/rental_skanega |

---

## 📞 TROUBLESHOOTING

### Koneksi Database Gagal?
```
1. Check MySQL di Laragon → pastikan START (hijau)
2. Buka phpMyAdmin → test koneksi
3. Edit config/koneksi.php jika username/password berbeda
4. Pastikan database db_rental_skanega sudah ada
```

### Login Tidak Bisa?
```
1. Refresh page (Ctrl+F5)
2. Buka phpMyAdmin → cek tabel users
3. Pastikan data sample sudah ada (admin & user1)
4. Jalankan ulang database.sql
```

### Tombol Pinjam Tidak Muncul?
```
1. Pastikan login sebagai user (user_status = 2)
2. Kendaraan harus status Ready (pinjam_status = 1)
3. Refresh page jika sudah pinjam di kendaraan lain
```

---

## 🎓 LEARNING OUTCOMES

Setelah menggunakan system ini, Anda bisa:
1. ✅ Membuat aplikasi PHP native dari nol
2. ✅ Merancang database dengan relationships
3. ✅ Implementasi login/authentication
4. ✅ Membuat CRUD dengan prepared statements
5. ✅ Menggunakan Bootstrap untuk UI responsive
6. ✅ Memahami session & security basics
7. ✅ Deploy di localhost dengan Laragon

---

## 📝 NOTES

1. **Production Ready?** 
   - Tidak, project ini untuk pembelajaran
   - Untuk production tambahkan HTTPS, CSRF tokens, rate limiting

2. **Database Backup?**
   - Backup dari phpMyAdmin atau gunakan mysqldump

3. **Password Reset?**
   - Edit langsung di phpMyAdmin → generate bcrypt hash baru

4. **Tambah User Baru?**
   - Masuk phpMyAdmin → insert ke tabel users (jangan lupa hash password!)

---

## 🎉 YOU'RE ALL SET!

Sekarang Anda sudah siap menggunakan Sistem Rental Kendaraan!

```
┌─────────────────────────────────┐
│  Buka: http://localhost/        │
│         rental_skanega/         │
│                                 │
│  Username: admin / user1        │
│  Password: password123 / user123│
│                                 │
│  Selamat Belajar! 🚀            │
└─────────────────────────────────┘
```

---

**Version**: 1.0
**Created**: December 2, 2025
**Status**: ✅ Ready to Use

Happy Coding! 💻
