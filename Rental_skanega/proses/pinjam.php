<?php
session_start();
include_once '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['user_status'] != 2) {
    header("Location: ../views/login.php");
    exit();
}

if (isset($_GET['id_kendaraan'])) {
    $id_kendaraan = intval($_GET['id_kendaraan']);
    $id_user = $_SESSION['id'];
    $tanggal_pinjam = date('Y-m-d');
    
    $check = $koneksi->query("SELECT * FROM kendaraan WHERE id_kendaraan = $id_kendaraan AND pinjam_status = 1");
    
    if ($check->num_rows > 0) {
        // Check apakah user sudah memiliki peminjaman aktif untuk kendaraan ini
        $check_existing = $koneksi->query(
            "SELECT * FROM pinjam WHERE id_user = $id_user AND id_kendaraan = $id_kendaraan AND tanggal_kembali IS NULL"
        );
        
        if ($check_existing->num_rows > 0) {
            header("Location: ../views/user/index.php?error=Anda sudah meminjam kendaraan ini");
            exit();
        }
        
        $sql = "INSERT INTO pinjam (id_user, id_kendaraan, tanggal_pinjam) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("iis", $id_user, $id_kendaraan, $tanggal_pinjam);
        
        if ($stmt->execute()) {
            // Update status kendaraan menjadi Dipinjam
            $koneksi->query("UPDATE kendaraan SET pinjam_status = 2 WHERE id_kendaraan = $id_kendaraan");
            header("Location: ../views/user/index.php?success=Kendaraan berhasil dipinjam");
        } else {
            header("Location: ../views/user/index.php?error=Error: " . $koneksi->error);
        }
        
        $stmt->close();
    } else {
        header("Location: ../views/user/index.php?error=Kendaraan tidak tersedia");
    }
} else {
    header("Location: ../views/user/index.php");
}
?>
