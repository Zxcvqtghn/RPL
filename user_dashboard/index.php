<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$bookingCount = countBookingsByUser($user['id']);
$bookings = getBookingsByUser($user['id']);
$lastBooking = $bookings[0] ?? null;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MeSketch</title>
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
        .header { background: white; padding: 20px 30px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; font-size: 1.8rem; color: #333; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-avatar { width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #c4a484 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem; }
        .stat-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: transform 0.3s, box-shadow 0.3s; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .stat-card .icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 15px; }
        .btn-brown { background: linear-gradient(135deg, #ca9880 100%); color: white; }
        .btn-dark-brown { background: linear-gradient(135deg, #3b2f2f 100%); color: white; }
        .stat-card.light-brown .icon { background: linear-gradient(135deg, #c4a484); color: white; }
        .stat-card.brown .icon { background: linear-gradient(135deg, #ca9880); color: white; }
        .stat-card.dark-brown .icon { background: linear-gradient(135deg, #3b2f2f); color: white; }
        .stat-card h3 { color: #666; font-size: 0.9rem; margin: 0 0 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card .number { font-size: 2.5rem; font-weight: bold; color: #333; margin: 0; }
        .quick-actions { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .quick-actions h4 { margin-bottom: 20px; color: #333; }
        .quick-actions .btn { border-radius: 10px; padding: 12px 20px; font-weight: 600; transition: all 0.3s; color: white; }
        @media (max-width: 992px) { .header { flex-direction: column; gap: 20px; } }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <div class="brand">MeSketch</div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a class="nav-link" href="booking.php"><i class="bi bi-calendar-plus"></i> Booking</a>
                    <a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i> Profile</a>
                    <a class="nav-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </nav>
            </div>
            <div class="col-md-10 main-content">
                <div class="header">
                    <div>
                        <h1>Dashboard</h1>
                        <p class="text-muted mb-0">Hi, <?= htmlspecialchars($user['nama']) ?>.</p>
                        <small class="text-muted">Email: <?= htmlspecialchars($user['username']) ?></small>
                    </div>
                    <div class="user-info">
                        <div class="user-avatar">
                            <?php if (!empty($user['gambar'])): ?>
                                <img src="../img/user/<?= htmlspecialchars($user['gambar']) ?>" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            <?php else: ?>
                                <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="stat-card light-brown">
                            <div class="icon"><i class="bi bi-calendar-check"></i></div>
                            <h3>Total Booking</h3>
                            <p class="number"><?= $bookingCount ?></p>
                            <p class="text-muted mb-0">Lihat daftar booking Anda pada halaman Booking.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card dark-brown">
                            <div class="icon"><i class="bi bi-clock-history"></i></div>
                            <h3>Booking Terakhir</h3>
                            <?php if ($lastBooking): ?>
                                <p class="number"><?= htmlspecialchars($lastBooking['project_name']) ?></p>
                                <p class="text-muted mb-0"><?= date('d M Y', strtotime($lastBooking['booking_date'])) ?> - <?= htmlspecialchars($lastBooking['status']) ?></p>
                            <?php else: ?>
                                <p class="number">-</p>
                                <p class="text-muted mb-0">Belum ada booking.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="quick-actions mt-4">
                    <h4>Menu Cepat</h4>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="booking.php" class="btn btn-brown"><i class="bi bi-calendar-plus"></i> Buat Booking</a>
                        <a href="profile.php" class="btn btn-dark-brown"><i class="bi bi-person-circle"></i> Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
