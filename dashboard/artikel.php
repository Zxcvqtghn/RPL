<?php

require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Check login
requireLogin();

$user = getCurrentUser();
$isAdmin = isAdmin();

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$success = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_action = $_POST['action'];

    if ($post_action === 'create') {
        $author = $user['username'];
        $judul = trim($_POST['judul']);
        $isi = trim($_POST['isi']);

        // Handle image upload
        $gambar = 'default-blog.jpg';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploaded = uploadGambar($_FILES['gambar'], '../img/blog/');
            if ($uploaded) {
                $gambar = $uploaded;
            }
        }

        if (insertArtikel($author, $judul, $isi, $gambar)) {
            $success = 'Artikel berhasil ditambahkan!';
            $action = 'list';
        } else {
            $error = 'Gagal menambahkan artikel!';
        }
    } elseif ($post_action === 'update') {
        $id = $_POST['id'];
        $author = $user['username'];
        $judul = trim($_POST['judul']);
        $isi = trim($_POST['isi']);
        $old_gambar = $_POST['old_gambar'];

        // Handle image upload
        $gambar = $old_gambar;
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploaded = uploadGambar($_FILES['gambar'], '../img/blog/');
            if ($uploaded) {
                $gambar = $uploaded;
                // Delete old image if not default
                if ($old_gambar !== 'default-blog.jpg' && file_exists('../img/blog/' . $old_gambar)) {
                    unlink('../img/blog/' . $old_gambar);
                }
            }
        }

        if (updateArtikel($id, $author, $judul, $isi, $gambar)) {
            $success = 'Artikel berhasil diupdate!';
            $action = 'list';
        } else {
            $error = 'Gagal mengupdate artikel!';
        }
    }
}

// Handle delete
if ($action === 'delete' && $id) {
    $artikel = getArtikelById($id);
    if ($artikel) {
        // Check permission (admin bisa hapus semua, writer hanya artikelnya sendiri)
        if ($isAdmin || $artikel['author'] === $user['username']) {
            if (deleteArtikel($id)) {
                // Delete image
                if ($artikel['gambar'] !== 'default-blog.jpg' && file_exists('../img/blog/' . $artikel['gambar'])) {
                    unlink('../img/blog/' . $artikel['gambar']);
                }
                $success = 'Artikel berhasil dihapus!';
                $action = 'list';
            } else {
                $error = 'Gagal menghapus artikel!';
            }
        } else {
            $error = 'Anda tidak memiliki akses untuk menghapus artikel ini!';
        }
    }
}

// Get data for edit
if ($action === 'edit' && $id) {
    $artikel = getArtikelById($id);
    if (!$artikel) {
        $error = 'Artikel tidak ditemukan!';
        $action = 'list';
    } elseif (!$isAdmin && $artikel['author'] !== $user['username']) {
        $error = 'Anda tidak memiliki akses untuk mengedit artikel ini!';
        $action = 'list';
    }
}

// Get artikel list
if ($action === 'list') {
    if ($isAdmin) {
        $artikelList = getAllArtikel();
    } else {
        $artikelList = getArtikelByAuthor($user['username']);
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - MeSketch</title>

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
            background: linear-gradient(135deg, #c4a484 0%, #3b2f2f 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .table-artikel img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .badge-author {
            background: linear-gradient(135deg, #ca9880 100%);
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-finish {
            background-color: #d1edff;
            color: #0d6efd;
        }

        .status-canceled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            background: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-text {
            color: #fff;
            font-weight: bold;
            font-size: 14px;
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
                    <a class="nav-link active" href="artikel.php">
                        <i class="bi bi-file-text"></i> Artikel
                    </a>
                    <?php if ($isAdmin): ?>
                        <a class="nav-link" href="testimoni.php">
                            <i class="bi bi-chat-quote"></i> Testimoni
                        </a>
                        <a class="nav-link" href="staff.php">
                            <i class="bi bi-people"></i> Staff
                        </a>
                        <a class="nav-link" href="user.php">
                            <i class="bi bi-calendar-check"></i> User Bookings
                        </a>
                    <?php endif; ?>
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
                    <h1><i class="bi bi-file-text"></i> Kelola Artikel</h1>
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
                            <h4 class="mb-0">Daftar Artikel</h4>
                            <a href="?action=create" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Artikel
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-artikel">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Judul</th>
                                        <th>Author</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($artikelList)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada artikel</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($artikelList as $i => $artikel): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td>
                                                    <img src="../img/blog/<?= htmlspecialchars($artikel['gambar']) ?>" alt="">
                                                </td>
                                                <td>
                                                    <strong><?= htmlspecialchars($artikel['judul']) ?></strong>
                                                    <br>
                                                    <small
                                                        class="text-muted"><?= htmlspecialchars(substr($artikel['excerpt'], 0, 50)) ?>...</small>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-author"><?= htmlspecialchars($artikel['author']) ?></span>
                                                </td>
                                                <td><?= formatTanggal($artikel['tanggal']) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <?php if ($isAdmin || $artikel['author'] === $user['username']): ?>
                                                            <a href="?action=edit&id=<?= $artikel['id_blog'] ?>"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a href="?action=delete&id=<?= $artikel['id_blog'] ?>"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus artikel ini?')">
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
                        <h4 class="mb-4">Tambah Artikel Baru</h4>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="create">

                            <div class="mb-3">
                                <label class="form-label">Judul Artikel</label>
                                <input type="text" name="judul" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Isi Artikel</label>
                                <textarea name="isi" class="form-control" rows="10" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="artikel.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>

                <?php elseif ($action === 'edit' && isset($artikel)): ?>
                    <!-- Edit Form -->
                    <div class="content-card">
                        <h4 class="mb-4">Edit Artikel</h4>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $artikel['id_blog'] ?>">
                            <input type="hidden" name="old_gambar" value="<?= htmlspecialchars($artikel['gambar']) ?>">

                            <div class="mb-3">
                                <label class="form-label">Judul Artikel</label>
                                <input type="text" name="judul" class="form-control"
                                    value="<?= htmlspecialchars($artikel['judul']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Isi Artikel</label>
                                <textarea name="isi" class="form-control" rows="10"
                                    required><?= htmlspecialchars($artikel['isi']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <?php if ($artikel['gambar']): ?>
                                    <div class="mb-2">
                                        <img src="../img/blog/<?= htmlspecialchars($artikel['gambar']) ?>"
                                            style="max-width: 200px;" class="img-thumbnail">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update
                                </button>
                                <a href="artikel.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                <!-- Recent Bookings -->
                <div class="content-card mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="bi bi-calendar-event"></i> Booking Terbaru</h4>
                        <a href="user.php" class="btn btn-sm btn-outline-primary">Kelola Booking</a>
                    </div>

                    <?php
                    $recentBookings = getRecentBookings(3);
                    if (empty($recentBookings)): ?>
                        <div class="alert alert-secondary">Belum ada booking dari user.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Proyek</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBookings as $booking): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-2">
                                                        <?php if ($booking['user_gambar'] && $booking['user_gambar'] !== 'default.jpg' && file_exists('../img/user/' . $booking['user_gambar'])): ?>
                                                            <img src="../img/user/<?= htmlspecialchars($booking['user_gambar']) ?>" alt="Avatar">
                                                        <?php else: ?>
                                                            <div class="avatar-text"><?= strtoupper(substr($booking['user_nama'], 0, 1)) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="fw-bold"><?= htmlspecialchars($booking['user_nama']) ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($booking['project_name']) ?></div>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower($booking['status']) ?>">
                                                    <?= htmlspecialchars($booking['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y', strtotime($booking['created_at'])) ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>