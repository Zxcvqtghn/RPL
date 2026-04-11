<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$bookings = getBookingsByUser($user['id']);
$error = '';
$success = '';
$project_name = '';
$booking_date = '';
$phone = '';
$address = '';
$notes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_name = trim($_POST['project_name'] ?? '');
    $booking_date = trim($_POST['booking_date'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    if (empty($project_name) || empty($booking_date) || empty($phone) || empty($address)) {
        $error = 'Semua field wajib diisi.';
    } elseif (!DateTime::createFromFormat('Y-m-d', $booking_date)) {
        $error = 'Tanggal booking tidak valid.';
    } else {
        $inserted = insertBooking(
            $user['id'],
            $user['username'],
            $user['nama'],
            $phone,
            $project_name,
            $booking_date,
            $address,
            $notes
        );

        if ($inserted) {
            $success = 'Booking berhasil dikirim. Tim kami akan segera menghubungi Anda.';
            $bookings = getBookingsByUser($user['id']);
            $project_name = '';
            $booking_date = '';
            $phone = '';
            $address = '';
            $notes = '';
        } else {
            $error = 'Terjadi kesalahan saat mengirim booking. Coba lagi.';
        }
    }
}

function formatBookingDate($value)
{
    $date = DateTime::createFromFormat('Y-m-d', $value);
    return $date ? $date->format('d M Y') : $value;
}

function formatCreatedAt($value)
{
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    return $date ? $date->format('d M Y H:i') : $value;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - MeSketch</title>
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
        .booking-card, .booking-history { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .booking-card h2, .booking-history h2 { margin-bottom: 20px; color: #333; }
        .btn-brown { background: linear-gradient(135deg, #ca9880 100%); color: white; }
        .table-responsive { overflow-x: auto; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #c4a484 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1rem; overflow: hidden; }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="brand">MeSketch</div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a class="nav-link active" href="booking.php"><i class="bi bi-calendar-plus"></i> Booking</a>
                    <a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i> Profile</a>
                    <a class="nav-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </nav>
            </div>
            <div class="col-md-10 main-content">
                <div class="page-header">
                    <h1>Booking</h1>
                    <p class="text-muted mb-0">Catat dan lihat riwayat booking Anda di sini.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success" role="alert"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <div class="row gy-4">
                    <div class="col-xl-5">
                        <div class="booking-card">
                            <h2>Booking Baru</h2>
                            <form method="POST" action="" autocomplete="off">
                                <div class="mb-3">
                                    <label for="project_name" class="form-label">Nama Proyek</label>
                                    <input type="text" id="project_name" name="project_name" class="form-control" value="<?= htmlspecialchars($project_name) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="booking_date" class="form-label">Tanggal Booking</label>
                                    <input type="date" id="booking_date" name="booking_date" class="form-control" value="<?= htmlspecialchars($booking_date) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Telepon</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea id="address" name="address" class="form-control" rows="4" required><?= htmlspecialchars($address) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Keterangan Tambahan</label>
                                    <textarea id="notes" name="notes" class="form-control" rows="3"><?= htmlspecialchars($notes) ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-brown w-100">Kirim Booking</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="booking-history">
                            <h2>Riwayat Booking</h2>
                            <?php if (empty($bookings)): ?>
                                <div class="alert alert-secondary">Belum ada booking. Silakan buat booking baru.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Proyek</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bookings as $index => $booking): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($booking['project_name']) ?></td>
                                                    <td><?= formatBookingDate($booking['booking_date']) ?></td>
                                                    <td>
                                                        <span class="status-badge status-<?= strtolower($booking['status']) ?>">
                                                            <?= htmlspecialchars($booking['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= formatCreatedAt($booking['created_at']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
