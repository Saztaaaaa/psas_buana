<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman - Rental Kendaraan</title>
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
    
    $sql = "
        SELECT p.id_pinjam, p.id_user, p.id_kendaraan, p.tanggal_pinjam, p.tanggal_kembali,
               u.username, u.user_alamat, k.nama_kendaraan, k.plat_nomor
        FROM pinjam p
        LEFT JOIN users u ON p.id_user = u.id
        LEFT JOIN kendaraan k ON p.id_kendaraan = k.id_kendaraan
        ORDER BY p.id_pinjam DESC
    ";
    $rental_data = $koneksi->query($sql);
    

    $count_result = $koneksi->query("SELECT COUNT(*) as total FROM pinjam");
    $total_peminjaman = $count_result ? $count_result->fetch_assoc()['total'] : 0;
    ?>
    

    <div class="sidebar">
        <h4 class="text-white mb-4">
            <i class="fas fa-car"></i> Admin Panel
        </h4>
        <a href="index.php">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="../../views/kendaraan/index.php">
            <i class="fas fa-car"></i> Kelola Kendaraan
        </a>
        <a href="../../views/kendaraan/tambah.php">
            <i class="fas fa-plus"></i> Tambah Kendaraan
        </a>
        <a href="peminjaman.php" class="active">
            <i class="fas fa-list"></i> Data Peminjaman
        </a>
        <hr class="bg-white">
        <a href="../../proses/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
    

    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <span class="navbar-text">
                    <i class="fas fa-list"></i> <strong>Data Peminjaman</strong>
                </span>
            </div>
        </nav>
        

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Daftar Semua Peminjaman
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Alamat</th>
                                <th>Kendaraan</th>
                                <th>Plat Nomor</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if ($rental_data && $rental_data->num_rows > 0) {
                                while ($row = $rental_data->fetch_assoc()) {
                                    $status = empty($row['tanggal_kembali']) ? 
                                        '<span class="badge bg-warning text-dark">Dipinjam</span>' : 
                                        '<span class="badge bg-success">Dikembalikan</span>';
                                    
                                    $tgl_kembali = empty($row['tanggal_kembali']) ? '-' : date('d-m-Y', strtotime($row['tanggal_kembali']));
                                    
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . htmlspecialchars($row['username'] ?? 'User Deleted') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['user_alamat'] ?? 'User Deleted') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_kendaraan'] ?? 'Kendaraan Deleted') . "</td>";
                                    echo "<td><code>" . htmlspecialchars($row['plat_nomor'] ?? '-') . "</code></td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['tanggal_pinjam'])) . "</td>";
                                    echo "<td>" . $tgl_kembali . "</td>";
                                    echo "<td>" . $status . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center text-muted py-4">📭 Belum ada data peminjaman</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
