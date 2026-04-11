<?php
require_once 'includes/functions.php';

// Redirect ke dashboard jika sudah login
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'User') {
        header('Location: user_dashboard/index.php');
    } else {
        header('Location: dashboard/index.php');
    }
    exit();
}

$error = '';
$success = '';
$email = '';
$nama = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($email) || empty($nama) || empty($password) || empty($confirmPassword)) {
        $error = 'Semua field harus diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($email) > 30) {
        $error = 'Email terlalu panjang. Gunakan maksimal 30 karakter.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Password dan konfirmasi password tidak cocok.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif (getUserByUsername($email) !== null) {
        $error = 'Email sudah terdaftar. Silakan login atau gunakan email lain.';
    } else {
        $created = insertUser($email, $password, $nama, 'User', 'default.jpg');
        if ($created) {
            $success = 'Daftar berhasil. Silakan login.';
            $email = '';
            $nama = '';
        } else {
            $error = 'Terjadi kesalahan saat membuat akun. Coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MeSketch</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f1eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        .register-header {
            background: linear-gradient(135deg, #3b2f2f 0%, #ca9880 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .register-body {
            padding: 40px 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #f5f1eb;
            box-shadow: 0 0 0 0.2rem rgba(130, 94, 59, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #c4a484 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: transform 0.3s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .back-login {
            text-align: center;
            margin-top: 20px;
        }
        .back-login a {
            color: #3b2f2f;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Daftar Akun</h1>
            <p>Gunakan email sebagai username untuk masuk.</p>
        </div>
        <div class="register-body">
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Masukkan email" value="<?= htmlspecialchars($email) ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($nama) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-register">Daftar</button>
            </form>
            <div class="back-login">
                <a href="login.php">Sudah punya akun? Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
