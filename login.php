<?php
/**
 * Login Page
 * Halaman login untuk Admin dan Writer
 */

require_once 'includes/auth.php';

// Redirect jika sudah login
if (isLoggedIn()) {
    $user = getCurrentUser();
    if ($user['role'] === 'User') {
        header("Location: user_dashboard/index.php");
    } else {
        header("Location: dashboard/index.php");
    }
    exit();
}

$error = '';

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        $result = login($username, $password);

        if ($result['success']) {
            if ($result['role'] === 'User') {
                header("Location: user_dashboard/index.php");
            } else {
                header("Location: dashboard/index.php");
            }
            exit();
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MeSketch</title>

    <!-- Bootstrap CSS -->
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

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, #3b2f2f 0%, #ca9880 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }

        .login-body {
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

        .btn-login {
            background: linear-gradient(135deg, #c4a484 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: transform 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            color: #3b2f2f;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>MeSketch</h1>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Email atau Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Masukkan email atau username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                        required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn btn-login">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="resgister.php" class="text-decoration-none">Belum punya akun? Daftar di sini</a>
            </div>

            <div class="back-home mt-3">
                <a href="index.php">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>