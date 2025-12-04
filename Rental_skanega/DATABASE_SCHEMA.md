# 📊 Entity Relationship Diagram (ERD)

## Database Schema Visualization

```
┌─────────────────────────┐
│        USERS            │
├─────────────────────────┤
│ PK: id (INT)            │
│ UN: username (VARCHAR)  │
│     password (VARCHAR)  │
│     user_status (TINYINT)│
│     created_at (TS)     │
└────────────┬────────────┘
             │
             │ 1:N
             │
             ▼
┌─────────────────────────┐     ┌──────────────────────┐
│       PINJAM            │────▶│    KENDARAAN         │
├─────────────────────────┤     ├──────────────────────┤
│ PK: id_pinjam (INT)     │     │ PK: id_kendaraan (INT)
│ FK: id_user (INT)       │     │ UN: plat_nomor       │
│ FK: id_kendaraan (INT)  │     │     nama_kendaraan   │
│     tanggal_pinjam (DATE)     │     jenis            │
│     tanggal_kembali (DATE)    │     pinjam_status    │
│     created_at (TS)     │     │     created_at       │
└─────────────────────────┘     └──────────────────────┘
```

---

## Relationships

### 1. Users → Pinjam (1:N)
- **Cardinality**: 1 User dapat memiliki banyak Pinjam
- **Foreign Key**: `pinjam.id_user` → `users.id`
- **On Delete**: CASCADE (jika user dihapus, semua peminjaman juga dihapus)

### 2. Kendaraan → Pinjam (1:N)
- **Cardinality**: 1 Kendaraan dapat memiliki banyak Pinjam
- **Foreign Key**: `pinjam.id_kendaraan` → `kendaraan.id_kendaraan`
- **On Delete**: CASCADE (jika kendaraan dihapus, semua peminjaman juga dihapus)

---

## Normalization

### Normal Form Analysis

#### USERS Table (3NF)
✅ 1NF: Semua value atomic (tidak ada repeating groups)
✅ 2NF: Semua non-key attributes fully depend on primary key
✅ 3NF: Tidak ada transitive dependency

#### KENDARAAN Table (3NF)
✅ 1NF: Atomic values
✅ 2NF: Full dependency pada primary key
✅ 3NF: Tidak ada transitive dependency

#### PINJAM Table (3NF)
✅ 1NF: Atomic values
✅ 2NF: Composite key dengan full dependency
✅ 3NF: Tidak ada transitive dependency

---

## Data Model

### USERS Entity
```
Attribute           Type        Constraint
─────────────────────────────────────────
id                  INT         PK, AI
username            VARCHAR(50) UNIQUE, NOT NULL
password            VARCHAR(255) NOT NULL
user_status         TINYINT     NOT NULL
                                1=Admin
                                2=User
created_at          TIMESTAMP   DEFAULT NOW()
```

**Example Data:**
```
id | username | password                                     | user_status
1  | admin    | $2y$10$YkNWXlFvWGxOblY3enRWReJQ8d...         | 1
2  | user1    | $2y$10$7n9Y8Z2X1W3V4U5T6S7R8P9O0...         | 2
```

### KENDARAAN Entity
```
Attribute           Type        Constraint
─────────────────────────────────────────
id_kendaraan        INT         PK, AI
nama_kendaraan      VARCHAR(100) NOT NULL
jenis               VARCHAR(50)  NOT NULL
plat_nomor          VARCHAR(20)  UNIQUE, NOT NULL
pinjam_status       TINYINT      NOT NULL
                                 1=Ready
                                 2=Dipinjam
created_at          TIMESTAMP    DEFAULT NOW()
```

**Example Data:**
```
id_kendaraan | nama_kendaraan  | jenis | plat_nomor    | pinjam_status
1            | Toyota Avanza   | Mobil | B 1234 ABC    | 1
2            | Honda Jazz      | Mobil | B 5678 DEF    | 1
3            | Honda CB150     | Motor | B 3456 JKL    | 2
```

### PINJAM Entity
```
Attribute           Type        Constraint
─────────────────────────────────────────
id_pinjam           INT         PK, AI
id_user             INT         FK (users.id)
id_kendaraan        INT         FK (kendaraan.id_kendaraan)
tanggal_pinjam      DATE        NOT NULL
tanggal_kembali     DATE        NULLABLE
created_at          TIMESTAMP   DEFAULT NOW()
```

**Example Data:**
```
id_pinjam | id_user | id_kendaraan | tanggal_pinjam | tanggal_kembali
1         | 2       | 1            | 2025-12-01     | NULL (masih dipinjam)
2         | 2       | 3            | 2025-11-28     | 2025-11-30
```

---

## Constraints

### Primary Key Constraints
- `users.id` - Unique identifier untuk setiap user
- `kendaraan.id_kendaraan` - Unique identifier untuk setiap kendaraan
- `pinjam.id_pinjam` - Unique identifier untuk setiap peminjaman

### Unique Constraints
- `users.username` - Tidak boleh ada username duplikat
- `kendaraan.plat_nomor` - Tidak boleh ada plat nomor duplikat

### Foreign Key Constraints
- `pinjam.id_user` → `users.id` (ON DELETE CASCADE)
- `pinjam.id_kendaraan` → `kendaraan.id_kendaraan` (ON DELETE CASCADE)

### Not Null Constraints
- `users.username`, `password`, `user_status` - Harus diisi
- `kendaraan.nama_kendaraan`, `jenis`, `plat_nomor` - Harus diisi
- `pinjam.id_user`, `id_kendaraan`, `tanggal_pinjam` - Harus diisi

### Check Constraints (Implicit)
- `user_status` hanya bernilai 1 atau 2
- `pinjam_status` hanya bernilai 1 atau 2

---

## Business Logic

### State Transitions

#### Kendaraan Status Flow
```
Ready (1) ──pinjam──> Dipinjam (2)
                         │
                      kembali
                         │
                         ▼
                      Ready (1)
```

#### Peminjaman Status Flow
```
New Entry                    Dikembalikan
(tanggal_kembali = NULL) ──> (tanggal_kembali = DATE)
      ↓
  Peminjaman Aktif       Peminjaman Selesai
```

### Business Rules

1. **Peminjaman Kendaraan**
   - Hanya bisa pinjam kendaraan dengan status Ready (1)
   - Status otomatis berubah ke Dipinjam (2)
   - User tidak bisa pinjam kendaraan yang sama 2x (jika masih aktif)

2. **Pengembalian Kendaraan**
   - Hanya bisa kembalikan kendaraan yang status Dipinjam (2)
   - tanggal_kembali diisi dengan tanggal hari ini
   - Status otomatis berubah ke Ready (1)

3. **User Management**
   - Admin (user_status = 1) bisa CRUD kendaraan
   - User (user_status = 2) hanya bisa pinjam/kembali
   - Password disimpan dengan bcrypt hash

---

## Query Patterns

### JOIN Example
```sql
SELECT u.username, k.nama_kendaraan, p.tanggal_pinjam, p.tanggal_kembali
FROM pinjam p
JOIN users u ON p.id_user = u.id
JOIN kendaraan k ON p.id_kendaraan = k.id_kendaraan;
```

### Aggregation Example
```sql
SELECT k.nama_kendaraan, COUNT(p.id_pinjam) as total_dipinjam
FROM kendaraan k
LEFT JOIN pinjam p ON k.id_kendaraan = p.id_kendaraan
GROUP BY k.id_kendaraan;
```

### Filter Example
```sql
SELECT * FROM pinjam 
WHERE id_user = 1 
AND tanggal_kembali IS NULL;
```

---

## Integrity Constraints

### Referential Integrity
```
INSERT pinjam: HARUS ada user dengan id = pinjam.id_user
              HARUS ada kendaraan dengan id = pinjam.id_kendaraan

DELETE users: Otomatis DELETE semua pinjam dengan id_user tersebut
DELETE kendaraan: Otomatis DELETE semua pinjam dengan id_kendaraan tersebut
```

### Domain Integrity
```
users.user_status ∈ {1, 2}
kendaraan.pinjam_status ∈ {1, 2}
pinjam.tanggal_kembali ≥ pinjam.tanggal_pinjam
```

---

## Indexing Strategy

```
Recommended Indexes:
- users(username) - UNIQUE INDEX untuk login
- kendaraan(plat_nomor) - UNIQUE INDEX untuk validasi
- pinjam(id_user) - untuk query peminjaman per user
- pinjam(id_kendaraan) - untuk query peminjaman per kendaraan
- pinjam(tanggal_kembali) - untuk filter peminjaman aktif
```

---

## Performance Considerations

### Current Volume
- Users: ~2
- Kendaraan: ~5
- Pinjam: ~0-100+ (scalable)

### Query Optimization
1. ✅ Foreign keys untuk data integrity
2. ✅ Unique constraints untuk validasi
3. ✅ NOT NULL untuk mandatory fields
4. ✅ TIMESTAMP untuk audit trail
5. ⚠️ Indexes untuk frequently queried fields (jika scale up)

### Scalability
- Dapat handle ribuan transaksi
- Normalized design mengurangi redundansi
- CASCADE DELETE memastikan data consistency

---

## Backup & Recovery

```sql
-- Backup MySQL
mysqldump -u root db_rental_skanega > backup.sql

-- Restore MySQL
mysql -u root db_rental_skanega < backup.sql
```

---

## Security Considerations

1. **Password Storage**
   - ✅ Bcrypt hash dengan salt
   - ✅ NOT plain text password

2. **Data Access**
   - ✅ Role-based (Admin vs User)
   - ✅ Session-based authentication

3. **SQL Injection Prevention**
   - ✅ Prepared statements di PHP
   - ✅ Parameterized queries

4. **Data Validation**
   - ✅ Username unique
   - ✅ Plat nomor unique
   - ✅ Not null constraints

---

**Version**: 1.0
**Last Updated**: 2025-12-02
