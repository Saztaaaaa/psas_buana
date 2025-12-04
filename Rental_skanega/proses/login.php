<?php
session_start();
include_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Validasi input
    if (empty($username) || empty($password)) {
        header("Location: ../views/login.php?error=Username dan Password harus diisi");
        exit();
    }
    
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    
    if (!$stmt) {
        header("Location: ../views/login.php?error=Error: " . $koneksi->error);
        exit();
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($password === $user['password']) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_status'] = $user['user_status'];
            

            if ($user['user_status'] == 1) {

                header("Location: ../views/admin/index.php");
            } else {

                header("Location: ../views/user/index.php");
            }
            exit();
        } else {
            header("Location: ../views/login.php?error=Password salah");
            exit();
        }
    } else {
        header("Location: ../views/login.php?error=Username tidak ditemukan");
        exit();
    }
    
    $stmt->close();
} else {
    header("Location: ../views/login.php");
    exit();
}
?>
