<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan - Rental Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            margin: 8px 0;
            border-radius: 5px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include_once '../../config/koneksi.php';
    
    // Check session dan role
    if (!isset($_SESSION['id']) || $_SESSION['user_status'] != 1) {
        header("Location: ../../views/login.php");
        exit();
    }
    
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_kendaraan = isset($_POST['nama_kendaraan']) ? trim($_POST['nama_kendaraan']) : '';
        $jenis = isset($_POST['jenis']) ? trim($_POST['jenis']) : '';
        $plat_nomor = isset($_POST['plat_nomor']) ? trim($_POST['plat_nomor']) : '';
        $harga_perhari = isset($_POST['kendaraan_harga_perhari']) ? trim($_POST['kendaraan_harga_perhari']) : '';

        
        // Validasi
        if (empty($nama_kendaraan) || empty($jenis) || empty($plat_nomor)) {
            $error = 'Semua field harus diisi!';
        } else {
            // Check apakah plat nomor sudah ada
            $check = $koneksi->query("SELECT * FROM kendaraan WHERE plat_nomor = '" . $koneksi->real_escape_string($plat_nomor) . "'");
            
            if ($check->num_rows > 0) {
                $error = 'Plat nomor sudah terdaftar!';
            } else {
                // Insert data
                $sql = "INSERT INTO kendaraan (nama_kendaraan, jenis, plat_nomor, pinjam_status, kendaraan_harga_perhari) 
                        VALUES (?, ?, ?, 1, ?)";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param("ssss", $nama_kendaraan, $jenis, $plat_nomor, $harga_perhari);
                
                if ($stmt->execute()) {
                    header("Location: index.php?success=Kendaraan berhasil ditambahkan");
                    exit();
                } else {
                    $error = 'Error: ' . $koneksi->error;
                }
            }
        }
    }
    ?>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white mb-4">
            <i class="fas fa-car"></i> Admin Panel
        </h4>
        <a href="../../views/admin/index.php">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="index.php">
            <i class="fas fa-car"></i> Kelola Kendaraan
        </a>
        <a href="tambah.php" class="active">
            <i class="fas fa-plus"></i> Tambah Kendaraan
        </a>
        <a href="../../views/admin/peminjaman.php">
            <i class="fas fa-list"></i> Data Peminjaman
        </a>
        <hr class="bg-white">
        <a href="../../proses/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <span class="navbar-text">
                    <i class="fas fa-plus"></i> <strong>Tambah Kendaraan Baru</strong>
                </span>
            </div>
        </nav>
        
        <?php
        if ($error) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ' . htmlspecialchars($error) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }
        ?>
        
        <!-- Form -->
        <div class="card" style="max-width: 600px;">
            <div class="card-header bg-light">
                <h5 class="mb-0">Form Tambah Kendaraan</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_kendaraan" class="form-label">Nama Kendaraan</label>
                        <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Kendaraan</label>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Motor">Motor</option>
                            <option value="Bus">Bus</option>
                            <option value="Truck">Truck</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="plat_nomor" class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" placeholder="Contoh: B 1234 ABC" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_kendaraan" class="form-label">Harga Perhari</label>
                        <input type="text" class="form-control" id="kendaraan_harga_perhari" name="kendaraan_harga_perhari" required>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-submit text-white">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
