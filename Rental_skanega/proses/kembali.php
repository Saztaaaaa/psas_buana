<?php
session_start();
include_once '../config/koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['user_status'] != 2) {
    header("Location: ../views/login.php");
    exit();
}

if (isset($_GET['id_pinjam'])) {
    $id_pinjam = intval($_GET['id_pinjam']);
    $id_user = $_SESSION['id'];
    $tanggal_kembali = date('Y-m-d');
    
    // Get peminjaman data
    $pinjam = $koneksi->query(
        "SELECT * FROM pinjam WHERE id_pinjam = $id_pinjam AND id_user = $id_user AND tanggal_kembali IS NULL"
    );
    
    if ($pinjam->num_rows > 0) {
        $row = $pinjam->fetch_assoc();
        $id_kendaraan = $row['id_kendaraan'];
        
        $sql = "UPDATE pinjam SET tanggal_kembali = ? WHERE id_pinjam = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("si", $tanggal_kembali, $id_pinjam);
        
        if ($stmt->execute()) {
            // Update status kendaraan kembali ke Ready
            $koneksi->query("UPDATE kendaraan SET pinjam_status = 1 WHERE id_kendaraan = $id_kendaraan");
            header("Location: ../views/user/index.php?success=Kendaraan berhasil dikembalikan");
        } else {
            header("Location: ../views/user/index.php?error=Error: " . $koneksi->error);
        }
        
        $stmt->close();
    } else {
        header("Location: ../views/user/index.php?error=Peminjaman tidak ditemukan");
    }
} else {
    header("Location: ../views/user/index.php");
}
?>
