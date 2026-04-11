<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$error = '';
$success = ''; 
$userDetail = getUserById($user['id']);
$username = $userDetail['username'] ?? $user['username'];
$nama = $userDetail['nama'] ?? $user['nama'];
$telepon = $_SESSION['telepon'] ?? '';
$jenis_kelamin = $_SESSION['jenis_kelamin'] ?? '';
$gambar = $userDetail['gambar'] ?? $user['gambar'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? $user['username']);
    $nama = trim($_POST['nama'] ?? $user['nama']);
    $telepon = trim($_POST['telepon'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $gambar = $userDetail['gambar'] ?? $user['gambar'];

    if (empty($username) || empty($nama) || empty($telepon) || empty($jenis_kelamin)) {
        $error = 'Email, nama, nomor telepon, dan jenis kelamin wajib diisi.';
    } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        $existing = getUserByUsername($username);
        if ($existing && $username !== $user['username']) {
            $error = 'Email sudah digunakan oleh akun lain.';
        } else {
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $uploaded = uploadGambar($_FILES['gambar'], '../img/user/');
                if ($uploaded) {
                    if ($userDetail['gambar'] !== 'default.jpg' && file_exists('../img/user/' . $userDetail['gambar'])) {
                        unlink('../img/user/' . $userDetail['gambar']);
                    }
                    $gambar = $uploaded;
                } else {
                    $error = 'Gagal mengunggah foto profil. Pastikan file berupa JPG, PNG, atau GIF.';
                }
            }

            if (empty($error)) {
                if (updateUser($user['id'], $username, '', $nama, $user['role'], $gambar)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['nama'] = $nama;
                    $_SESSION['gambar'] = $gambar;
                    $_SESSION['telepon'] = $telepon;
                    $_SESSION['jenis_kelamin'] = $jenis_kelamin;
                    $success = 'Profil berhasil diperbarui.';
                } else {
                    $error = 'Terjadi kesalahan saat menyimpan profil.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - MeSketch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background: linear-gradient(135deg, #3b2f2f 0%, #c4a484 100%); min-height: 100vh; color: white; padding: 20px 0; }
        .sidebar .brand { padding: 20px; font-size: 1.8rem; font-weight: bold; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.2); margin-bottom: 20px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 15px 25px; transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: rgba(255,255,255,0.1); border-left-color: white; }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; }
        .main-content { padding: 30px; }
        .page-header { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .profile-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .profile-avatar { width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: #e9ecef; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .btn-brown { background: linear-gradient(135deg, #ca9880 100%); color: white; }
        .form-label { font-weight: 600; }
        @media (max-width: 992px) { .profile-card { text-align: center; } }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="brand">MeSketch</div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a class="nav-link" href="booking.php"><i class="bi bi-calendar-plus"></i> Booking</a>
                    <a class="nav-link active" href="profile.php"><i class="bi bi-person-circle"></i> Profile</a>
                    <a class="nav-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </nav>
            </div>
            <div class="col-md-10 main-content">
                <div class="page-header">
                    <h1>Profil Saya</h1>
                    <p class="text-muted">Perbarui foto, nama, dan email login Anda.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success" role="alert"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="profile-card row g-4">
                    <div class="col-lg-4 text-center">
                        <div class="profile-avatar mx-auto">
                            <?php if (!empty($user['gambar'])): ?>
                                <img src="../img/user/<?= htmlspecialchars($user['gambar']) ?>" alt="Avatar">
                            <?php else: ?>
                                <span class="fs-1 text-muted"><?= strtoupper(substr($user['nama'], 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="fw-bold mb-1"><?= htmlspecialchars($user['nama']) ?></p>
                        <p class="text-muted mb-0"><?= htmlspecialchars($user['username']) ?></p>
                    </div>
                    <div class="col-lg-8">
                        <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label" for="username">Email</label>
                                <input type="email" class="form-control" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="telepon">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= htmlspecialchars($telepon) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" <?= $jenis_kelamin === '' ? 'selected' : '' ?>>Pilih jenis kelamin</option>
                                    <option value="Laki-laki" <?= $jenis_kelamin === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= $jenis_kelamin === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                    <option value="Lainnya" <?= $jenis_kelamin === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="gambar">Foto Profil</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-brown">Simpan Profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
