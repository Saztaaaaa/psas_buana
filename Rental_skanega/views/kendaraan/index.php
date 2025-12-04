<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kendaraan - Rental Kendaraan</title>
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
    
    if (isset($_GET['hapus'])) {
        $id = intval($_GET['hapus']);
        $koneksi->query("DELETE FROM kendaraan WHERE id_kendaraan = $id");
        header("Location: index.php?success=Kendaraan berhasil dihapus");
        exit();
    }
    

    $kendaraan_data = $koneksi->query("SELECT * FROM kendaraan ORDER BY id_kendaraan DESC");
    ?>
    

    <div class="sidebar">
        <h4 class="text-white mb-4">
            <i class="fas fa-car"></i> Admin Panel
        </h4>
        <a href="../../views/admin/index.php">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="index.php" class="active">
            <i class="fas fa-car"></i> Kelola Kendaraan
        </a>
        <a href="tambah.php">
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
    
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <span class="navbar-text">
                    <i class="fas fa-car"></i> <strong>Kelola Kendaraan</strong>
                </span>
                <a href="tambah.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Kendaraan
                </a>
            </div>
        </nav>
        
        <?php
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> ' . htmlspecialchars($_GET['success']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }
        ?>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Daftar Kendaraan
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Kendaraan</th>
                                <th>Jenis</th>
                                <th>Plat Nomor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                <th>Harga Perhari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if ($kendaraan_data->num_rows > 0) {
                                while ($row = $kendaraan_data->fetch_assoc()) {
                                    $status = $row['pinjam_status'] == 1 ? 
                                        '<span class="badge bg-success">Ready</span>' : 
                                        '<span class="badge bg-danger">Dipinjam</span>';
                                    echo "
                                    <tr>
                                        <td>" . $no . "</td>
                                        <td>" . htmlspecialchars($row['nama_kendaraan']) . "</td>
                                        <td>" . htmlspecialchars($row['jenis']) . "</td>
                                        <td><code>" . htmlspecialchars($row['plat_nomor']) . "</code></td>
                                        <td>" . $status . "</td>
                                        <td>
                                            <a href='edit.php?id=" . $row['id_kendaraan'] . "' class='btn btn-sm btn-warning'>
                                                <i class='fas fa-edit'></i> Edit
                                            </a>
                                            <a href='index.php?hapus=" . $row['id_kendaraan'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus kendaraan ini?\")'>
                                                <i class='fas fa-trash'></i> Hapus
                                            </a>
                                        </td>
                                        <td>" . htmlspecialchars($row['kendaraan_harga_perhari']) . "</td>
                                    </tr>
                                    ";
                                    $no++;
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-muted">Belum ada data kendaraan</td></tr>';
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
