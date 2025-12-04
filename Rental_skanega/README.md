# 🚗 Sistem Informasi Rental Kendaraan

Sistem manajemen rental kendaraan sederhana dengan PHP Native dan MySQL untuk keperluan sekolah.

## 📋 Persyaratan
- Laragon (PHP & MySQL)
- Web Browser modern
- phpMyAdmin (untuk setup database)

## 🚀 Cara Setup

### 1. Buat Database
1. Buka phpMyAdmin di Laragon (biasanya `http://localhost/phpmyadmin`)
2. Copy isi file `database.sql` dari folder project
3. Paste ke tab "SQL" di phpMyAdmin
4. Jalankan query

**Atau** jika ada cara lain:
```bash
# Buka terminal MySQL dan jalankan
mysql -u root < database.sql
```

### 2. Konfigurasi Koneksi (Opsional)
File `config/koneksi.php` sudah dikonfigurasi untuk:
- Host: `localhost`
- Username: `root`
- Password: (kosong)
- Database: `db_rental_skanega`

Jika berbeda, edit file tersebut.

### 3. Jalankan Project
1. Buka browser
2. Ketikkan: `http://localhost/rental_skanega/`
3. Anda akan diarahkan ke halaman login

## 🔐 Akun Test

### Admin
- Username: `admin`
- Password: `password123`

### User Biasa
- Username: `user1`
- Password: `user123`

## 📁 Struktur Folder

```
rental_skanega/
├── config/
│   └── koneksi.php          (Koneksi Database)
├── views/
│   ├── login.php            (Halaman Login)
│   ├── admin/
│   │   ├── index.php        (Dashboard Admin)
│   │   └── peminjaman.php   (Data Peminjaman)
│   ├── user/
│   │   └── index.php        (Dashboard User)
│   └── kendaraan/
│       ├── index.php        (List Kendaraan)
│       ├── tambah.php       (Tambah Kendaraan)
│       └── edit.php         (Edit Kendaraan)
├── proses/
│   ├── login.php            (Proses Login)
│   ├── logout.php           (Proses Logout)
│   ├── pinjam.php           (Proses Pinjam Kendaraan)
│   └── kembali.php          (Proses Kembalikan Kendaraan)
├── assets/                  (CSS, JS, Gambar)
├── database.sql             (SQL untuk Create DB)
└── index.php                (Redirect ke Login)
```

## 🎯 Fitur Utama

### 1. **Login dengan Session**
- Cek username dan password
- Hash password dengan bcrypt
- Redirect otomatis sesuai role:
  - Admin (user_status = 1) → Dashboard Admin
  - User (user_status = 2) → Dashboard User

### 2. **Dashboard Admin**
- Lihat statistik kendaraan
- CRUD Kendaraan (Create, Read, Update, Delete)
- Lihat data peminjaman semua user
- Update status kendaraan (Ready/Dipinjam)

### 3. **Dashboard User**
- Lihat kendaraan yang tersedia
- Pinjam kendaraan (status otomatis berubah ke Dipinjam)
- Lihat peminjaman aktif
- Kembalikan kendaraan (status otomatis berubah ke Ready)

### 4. **Manajemen Kendaraan**
- Tambah kendaraan baru
- Edit data kendaraan
- Hapus kendaraan
- Track status kendaraan (Ready/Dipinjam)

## 📊 Database

### Tabel: `users`
| Field | Type | Keterangan |
|-------|------|-----------|
| id | INT | Primary Key |
| username | VARCHAR | Unik |
| password | VARCHAR | Hash bcrypt |
| user_status | TINYINT | 1=Admin, 2=User |

### Tabel: `kendaraan`
| Field | Type | Keterangan |
|-------|------|-----------|
| id_kendaraan | INT | Primary Key |
| nama_kendaraan | VARCHAR | Nama kendaraan |
| jenis | VARCHAR | Mobil, Motor, dll |
| plat_nomor | VARCHAR | Unik |
| pinjam_status | TINYINT | 1=Ready, 2=Dipinjam |

### Tabel: `pinjam`
| Field | Type | Keterangan |
|-------|------|-----------|
| id_pinjam | INT | Primary Key |
| id_user | INT | Foreign Key |
| id_kendaraan | INT | Foreign Key |
| tanggal_pinjam | DATE | Tgl pinjam |
| tanggal_kembali | DATE | Tgl kembali (bisa NULL) |

## 🔧 Teknologi

- **Backend**: PHP Native (Procedural)
- **Database**: MySQL
- **Frontend**: Bootstrap 5, HTML5, CSS3
- **Password Hash**: bcrypt (password_hash, password_verify)

## 🎨 Design

- Responsive Bootstrap 5 Layout
- Gradient color scheme (Purple)
- Professional UI dengan sidebar navigation
- Alert notifications
- Status badges

## ⚠️ Notes

1. **Password Hash**: Semua password disimpan dengan bcrypt untuk keamanan
2. **Session Security**: Menggunakan PHP `$_SESSION` untuk session management
3. **SQL Injection Prevention**: Menggunakan prepared statements
4. **Redirect Logic**: Otomatis redirect berdasarkan user_status

## 📝 Contoh Penggunaan

### Admin - Tambah Kendaraan
1. Login sebagai admin
2. Klik menu "Tambah Kendaraan"
3. Isi form (Nama, Jenis, Plat Nomor)
4. Klik "Simpan"
5. Kendaraan muncul di list dengan status "Ready"

### User - Pinjam Kendaraan
1. Login sebagai user
2. Lihat "Kendaraan Tersedia"
3. Klik tombol "Pinjam Sekarang"
4. Kendaraan akan muncul di "Peminjaman Aktif"
5. Status kendaraan berubah ke "Dipinjam"

### User - Kembalikan Kendaraan
1. Lihat "Peminjaman Aktif"
2. Klik tombol "Kembalikan"
3. Kendaraan kembali ke status "Ready"
4. Hilang dari "Peminjaman Aktif"

## 🐛 Troubleshooting

### Koneksi Database Gagal
- Pastikan MySQL sudah berjalan di Laragon
- Cek konfigurasi di `config/koneksi.php`
- Pastikan database `db_rental_skanega` sudah dibuat

### Login Gagal
- Pastikan database sudah di-setup dengan `database.sql`
- Cek username dan password di akun test
- Buka browser baru atau clear cache

### Halaman Blank
- Check PHP error di browser inspect (F12)
- Lihat logs di Laragon
- Pastikan koneksi database aktif

## 📚 Referensi

- Bootstrap 5: https://getbootstrap.com/
- PHP Manual: https://www.php.net/manual/
- MySQL: https://www.mysql.com/
- Font Awesome: https://fontawesome.com/

## 👨‍💼 Author

Dibuat untuk tugas sekolah - Sistem Informasi Rental Kendaraan

---

**Selamat menggunakan! 🎉**
