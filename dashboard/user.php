<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Check login dan admin
requireAdmin();

$user = getCurrentUser();
$success = '';
$error = '';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $bookingId = $_POST['booking_id'];
    $status = $_POST['status'];

    if (in_array($status, ['Pending', 'Finish', 'Canceled'])) {
        if (updateBookingStatus($bookingId, $status)) {
            $success = 'Status booking berhasil diupdate!';
        } else {
            $error = 'Gagal mengupdate status booking!';
        }
    } else {
        $error = 'Status tidak valid!';
    }
}

// Get all bookings
$bookings = getAllBookings();

// Get statistics
$totalBookings = countTotalBookings();
$pendingBookings = countBookingsByStatus('Pending');
$finishedBookings = countBookingsByStatus('Finish');
$canceledBookings = countBookingsByStatus('Canceled');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Booking User - MeSketch</title>

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
            background: linear-gradient(135deg, #c4a484 0%, #3b2f2f 100%);
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stat-card.light-brown .icon {
            background: linear-gradient(135deg, #c4a484);
            color: white;
        }

        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin: 0;
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

        .table-responsive {
            overflow-x: auto;
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

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-text {
            color: #fff;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="brand">MeSketch</div>
        <nav class="nav flex-column">
            <a class="nav-link" href="index.php">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link" href="artikel.php">
                <i class="bi bi-file-earmark-text"></i> Artikel
            </a>
            <a class="nav-link" href="testimoni.php">
                <i class="bi bi-chat-quote"></i> Testimoni
            </a>
            <a class="nav-link" href="staff.php">
                <i class="bi bi-people"></i> Staff
            </a>
            <a class="nav-link active" href="user.php">
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

    <div class="main-content">
        <div class="header">
            <h1>Kelola Booking User</h1>
            <p class="text-muted mb-0">Lihat dan kelola status booking dari semua user.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card light-brown">
                    <div class="icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h3>Total Booking</h3>
                    <p class="number"><?= $totalBookings ?></p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); color: #856404;">
                    <div class="icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h3>Pending</h3>
                    <p class="number"><?= $pendingBookings ?></p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #d1edff 0%, #a3d9ff 100%); color: #0d6efd;">
                    <div class="icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h3>Finished</h3>
                    <p class="number"><?= $finishedBookings ?></p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #f8d7da 0%, #fab1a0 100%); color: #721c24;">
                    <div class="icon">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h3>Canceled</h3>
                    <p class="number"><?= $canceledBookings ?></p>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Daftar Booking</h2>
                <span class="badge bg-primary fs-6">Total: <?= count($bookings) ?> booking</span>
            </div>

            <?php if (empty($bookings)): ?>
                <div class="alert alert-secondary">Belum ada booking dari user.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Proyek</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $index => $booking): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                <?php if ($booking['user_gambar'] && $booking['user_gambar'] !== 'default.jpg' && file_exists('../img/user/' . $booking['user_gambar'])): ?>
                                                    <img src="../img/user/<?= htmlspecialchars($booking['user_gambar']) ?>" alt="Avatar">
                                                <?php else: ?>
                                                    <div class="avatar-text"><?= strtoupper(substr($booking['user_nama'], 0, 1)) ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($booking['user_nama']) ?></div>
                                                <small class="text-muted">@<?= htmlspecialchars($booking['user_username']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($booking['project_name']) ?></div>
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> <?= htmlspecialchars($booking['telepon']) ?><br>
                                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars(substr($booking['address'], 0, 30)) ?>...
                                        </small>
                                    </td>
                                    <td><?= formatTanggal($booking['booking_date']) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($booking['status']) ?>">
                                            <?= htmlspecialchars($booking['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <form method="POST" action="" class="d-inline">
                                            <input type="hidden" name="booking_id" value="<?= $booking['id_booking'] ?>">
                                            <input type="hidden" name="update_status" value="1">
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="Pending" <?= $booking['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Finish" <?= $booking['status'] === 'Finish' ? 'selected' : '' ?>>Finish</option>
                                                <option value="Canceled" <?= $booking['status'] === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>