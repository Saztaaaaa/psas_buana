<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Rental Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container" style="max-width: 400px; width: 100%;">
        <div class="login-header">
            <h2 class="mb-0">Rental Kendaraan</h2>
            <p class="mb-0 mt-2">Sistem Manajemen Rental</p>
        </div>
        <div class="login-body">
            <?php
            session_start();
            
            // Jika sudah login, redirect sesuai role
            if (isset($_SESSION['id'])) {
                if ($_SESSION['user_status'] == 1) {
                    header("Location: views/admin/index.php");
                } else {
                    header("Location: views/user/index.php");
                }
                exit();
            }
            
            // Tampilkan pesan error jika ada
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Login Gagal!</strong> ' . htmlspecialchars($_GET['error']) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
            }
            
            if (isset($_GET['logout'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> Anda telah logout dari sistem.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
            }
            ?>
            
            <form action="../proses/login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-login w-100 text-white">Login</button>
            </form>
            
            <hr class="my-4">
            <div class="alert alert-info" role="alert">
                <h6 class="mb-3">Data Akun Test:</h6>
                <p class="mb-2"><strong>Admin:</strong><br>
                   Username: <code>admin</code><br>
                   Password: <code>password123</code>
                </p>
                <p class="mb-0"><strong>User:</strong><br>
                   Username: <code>user1</code><br>
                   Password: <code>user123</code>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
