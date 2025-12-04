<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Rental Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .navbar-custom .navbar-text {
            color: rgba(255, 255, 255, 0.9);
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px 8px 0 0;
            border: none;
        }
        .vehicle-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
        }
        .status-ready {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .status-dipinjam {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .btn-pinjam {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-pinjam:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        .btn-kembali {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }
        .btn-kembali:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
            color: white;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include_once '../../config/koneksi.php';
    
    // Check session
    if (!isset($_SESSION['id']) || $_SESSION['user_status'] != 2) {
        header("Location: ../../views/login.php");
        exit();
    }
    
    $user_id = $_SESSION['id'];
    
    $kendaraan_data = $koneksi->query("SELECT * FROM kendaraan ORDER BY id_kendaraan DESC");
    
    // Get user's active rentals
    $rental_data = $koneksi->query("
        SELECT p.*, k.nama_kendaraan, k.plat_nomor
        FROM pinjam p
        JOIN kendaraan k ON p.id_kendaraan = k.id_kendaraan
        WHERE p.id_user = $user_id AND p.tanggal_kembali IS NULL
        ORDER BY p.created_at DESC
    ");
    ?>
    
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-car"></i> Rental Kendaraan
            </a>
            <div class="ms-auto">
                <span class="navbar-text me-3">
                    Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </span>
                <a href="../../proses/logout.php" class="btn btn-sm btn-light">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid py-4">
        <!-- Active Rentals Section -->
        <div class="row">
            <div class="col-md-8">
                <h4 class="mb-3">
                    <i class="fas fa-list"></i> Peminjaman Aktif Anda
                </h4>
                <?php
                if ($rental_data->num_rows > 0) {
                    while ($row = $rental_data->fetch_assoc()) {
                        echo "
                        <div class='vehicle-card'>
                            <div class='row align-items-center'>
                                <div class='col-md-8'>
                                    <h6 class='mb-2'>" . htmlspecialchars($row['nama_kendaraan']) . "</h6>
                                    <p class='mb-1'><strong>Plat Nomor:</strong> <code>" . htmlspecialchars($row['plat_nomor']) . "</code></p>
                                    <p class='mb-0'><strong>Tanggal Pinjam:</strong> " . date('d-m-Y', strtotime($row['tanggal_pinjam'])) . "</p>
                                </div>
                                <div class='col-md-4 text-end'>
                                    <a href='../../proses/kembali.php?id_pinjam=" . $row['id_pinjam'] . "' class='btn btn-sm btn-kembali'>
                                        <i class='fas fa-undo'></i> Kembalikan
                                    </a>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                } else {
                    echo '<div class="alert alert-info">Anda tidak memiliki peminjaman aktif</div>';
                }
                ?>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ringkasan</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $peminjaman_aktif = $koneksi->query("
                            SELECT COUNT(*) as total FROM pinjam 
                            WHERE id_user = $user_id AND tanggal_kembali IS NULL
                        ")->fetch_assoc()['total'];
                        
                        $kendaraan_ready = $koneksi->query("
                            SELECT COUNT(*) as total FROM kendaraan 
                            WHERE pinjam_status = 1
                        ")->fetch_assoc()['total'];
                        
                        $total_pinjam = $koneksi->query("
                            SELECT COUNT(*) as total FROM pinjam 
                            WHERE id_user = $user_id
                        ")->fetch_assoc()['total'];
                        ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Peminjaman Aktif</label>
                            <p class="h5"><?php echo $peminjaman_aktif; ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Kendaraan Tersedia</label>
                            <p class="h5"><?php echo $kendaraan_ready; ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Total Peminjaman</label>
                            <p class="h5"><?php echo $total_pinjam; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="mb-3">
                    <i class="fas fa-car"></i> Kendaraan Tersedia
                </h4>
                <div class="row">
                    <?php
                    if ($kendaraan_data->num_rows > 0) {
                        while ($row = $kendaraan_data->fetch_assoc()) {
                            $status = $row['pinjam_status'] == 1 ? 'Ready' : 'Dipinjam';
                            $status_class = $row['pinjam_status'] == 1 ? 'status-ready' : 'status-dipinjam';
                            $btn_disabled = $row['pinjam_status'] == 2 ? 'disabled' : '';
                            
                            echo "
                            <div class='col-md-6 col-lg-4'>
                                <div class='card'>
                                    <div class='card-body'>
                                        <h6 class='card-title'>" . htmlspecialchars($row['nama_kendaraan']) . "</h6>
                                        <p class='text-muted mb-2'><small>" . htmlspecialchars($row['jenis']) . "</small></p>
                                        <p class='mb-2'><strong>Plat:</strong> <code>" . htmlspecialchars($row['plat_nomor']) . "</code></p>
                                        <p class='mb-3'>Status: <span class='" . $status_class . "'>" . $status . "</span></p>
                                        
                                        " . ($row['pinjam_status'] == 1 ? 
                                            "<a href='../../proses/pinjam.php?id_kendaraan=" . $row['id_kendaraan'] . "' class='btn btn-sm btn-pinjam w-100'>
                                                <i class='fas fa-check'></i> Pinjam Sekarang
                                            </a>" 
                                            : 
                                            "<button class='btn btn-sm btn-secondary w-100' disabled>
                                                <i class='fas fa-times'></i> Tidak Tersedia
                                            </button>"
                                        ) . "
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo '<div class="alert alert-info">Belum ada data kendaraan</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
