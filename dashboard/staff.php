<?php


require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Check login dan admin
requireAdmin();

$user = getCurrentUser();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$success = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_action = $_POST['action'];

    if ($post_action === 'create') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $nama = trim($_POST['nama']);
        $role = $_POST['role'];

        // Handle image upload
        $gambar = 'default.jpg';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploaded = uploadGambar($_FILES['gambar'], '../img/user/');
            if ($uploaded) {
                $gambar = $uploaded;
            }
        }

        if (insertUser($username, $password, $nama, $role, $gambar)) {
            $success = 'Staff berhasil ditambahkan!';
            $action = 'list';
        } else {
            $error = 'Gagal menambahkan staff!';
        }
    } elseif ($post_action === 'update') {
        $id = $_POST['id'];
        $username = trim($_POST['username']);
        $password = $_POST['password']; // Bisa kosong jika tidak ganti password
        $nama = trim($_POST['nama']);
        $role = $_POST['role'];
        $old_gambar = $_POST['old_gambar'];

        // Handle image upload
        $gambar = $old_gambar;
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploaded = uploadGambar($_FILES['gambar'], '../img/user/');
            if ($uploaded) {
                $gambar = $uploaded;
                // Delete old image if not default
                if ($old_gambar !== 'default.jpg' && file_exists('../img/user/' . $old_gambar)) {
                    unlink('../img/user/' . $old_gambar);
                }
            }
        }

        if (updateUser($id, $username, $password, $nama, $role, $gambar)) {
            $success = 'Staff berhasil diupdate!';
            $action = 'list';
        } else {
            $error = 'Gagal mengupdate staff!';
        }
    }
}

// Handle delete
if ($action === 'delete' && $id) {
    $targetUser = getUserById($id);

    // Prevent deleting self
    if ($targetUser && $targetUser['id_user'] != $user['id']) {
        if (deleteUser($id)) {
            // Delete image
            if ($targetUser['gambar'] !== 'default.jpg' && file_exists('../img/user/' . $targetUser['gambar'])) {
                unlink('../img/user/' . $targetUser['gambar']);
            }
            $success = 'Staff berhasil dihapus!';
            $action = 'list';
        } else {
            $error = 'Gagal menghapus staff!';
        }
    } else {
        $error = 'Tidak dapat menghapus staff sendiri!';
        $action = 'list';
    }
}

// Get data for edit
if ($action === 'edit' && $id) {
    $editUser = getUserById($id);
    if (!$editUser) {
        $error = 'Staff tidak ditemukan!';
        $action = 'list';
    }
}

// Get staff list (only Admin and Writer roles)
if ($action === 'list') {
    $allUsers = getAllUser();
    $userList = array_filter($allUsers, function($user) {
        return in_array($user['role'], ['Admin', 'Writer']);
    });
    $userList = array_values($userList); // Reindex array
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Staff - MeSketch</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, #3b2f2f 0%, #c4a484 100%);
            min-height: 100vh;
            color: white;
            padding: 20px 0;
            position: fixed;
            width: 16.66%;
        }

        .sidebar .brand {
            padding: 20px;
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 25px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 16.66%;
            padding: 30px;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: #333;
        }

        .content-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b2f2f 0%, #c4a484 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .badge-role {
            padding: 5px 12px;
            border-radius: 20px;
        }

        .badge-admin {
            background: linear-gradient(135deg, #ca9880 100%);
            color: white;
        }

        .badge-writer {
            background: linear-gradient(135deg, #3b2f2f 0%, #f5f1eb 100%);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="brand">MeSketch</div>

                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="artikel.php">
                        <i class="bi bi-file-text"></i> Artikel
                    </a>
                    <a class="nav-link" href="testimoni.php">
                        <i class="bi bi-chat-quote"></i> Testimoni
                    </a>
                    <a class="nav-link active" href="staff.php">
                        <i class="bi bi-people"></i> Staff
                    </a>
                    <a class="nav-link" href="user.php">
                        <i class="bi bi-calendar-check"></i> User Bookings
                    </a>
                    <a class="nav-link" href="../index.php" target="_blank">
                        <i class="bi bi-globe"></i> Lihat Website
                    </a>
                    <a class="nav-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Header -->
                <div class="header">
                    <h1><i class="bi bi-people"></i> Kelola Staff</h1>
                </div>

                <!-- Alerts -->
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <?php if ($action === 'list'): ?>
                    <!-- List View -->
                    <div class="content-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Daftar Staff</h4>
                            <a href="?action=create" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Staff
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Avatar</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($userList)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada staff</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($userList as $i => $u): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td>
                                                    <img src="../img/user/<?= htmlspecialchars($u['gambar']) ?>" alt=""
                                                        class="user-avatar" onerror="this.src='https://via.placeholder.com/50'">
                                                </td>
                                                <td><strong><?= htmlspecialchars($u['nama']) ?></strong></td>
                                                <td><?= htmlspecialchars($u['username']) ?></td>
                                                <td>
                                                    <span
                                                        class="badge badge-role <?= $u['role'] === 'Admin' ? 'badge-admin' : 'badge-writer' ?>">
                                                        <?= htmlspecialchars($u['role']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="?action=edit&id=<?= $u['id_user'] ?>"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <?php if ($u['id_user'] != $user['id']): ?>
                                                            <a href="?action=delete&id=<?= $u['id_user'] ?>"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus staff ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($action === 'create'): ?>
                    <!-- Create Form -->
                    <div class="content-card">
                        <h4 class="mb-4">Tambah Staff Baru</h4>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="create">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Writer">Writer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="staff.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>

                <?php elseif ($action === 'edit' && isset($editUser)): ?>
                    <!-- Edit Form -->
                    <div class="content-card">
                        <h4 class="mb-4">Edit Staff</h4>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $editUser['id_user'] ?>">
                            <input type="hidden" name="old_gambar" value="<?= htmlspecialchars($editUser['gambar']) ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="<?= htmlspecialchars($editUser['nama']) ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="<?= htmlspecialchars($editUser['username']) ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="Admin" <?= $editUser['role'] === 'Admin' ? 'selected' : '' ?>>Admin
                                        </option>
                                        <option value="Writer" <?= $editUser['role'] === 'Writer' ? 'selected' : '' ?>>Writer
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <?php if ($editUser['gambar']): ?>
                                    <div class="mb-2">
                                        <img src="../img/user/<?= htmlspecialchars($editUser['gambar']) ?>"
                                            style="max-width: 100px;" class="img-thumbnail"
                                            onerror="this.src='https://via.placeholder.com/100'">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update
                                </button>
                                <a href="staff.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>