<?php
/**
 * Blog Detail Page
 * Menampilkan detail artikel lengkap
 */

require_once '../includes/functions.php';

// Get artikel ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: ../index.php#blog");
    exit();
}

// Get artikel data
$artikel = getArtikelById($id);

if (!$artikel) {
    header("Location: ../index.php#blog");
    exit();
}

// Get all testimoni untuk bagian bawah
$bacaTesti = getAllTesti();

// Get recent articles (5 artikel terbaru, exclude artikel saat ini)
$recentArticles = getAllArtikel();
$recentArticles = array_filter($recentArticles, function ($a) use ($id) {
    return $a['id_blog'] != $id;
});
$artikel = getArtikelById($id);
if (!$artikel) {
    header("Location: ../index.php#blog");
    exit();
}

$author = getUserByUsername($artikel['author']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= htmlspecialchars($artikel['judul']) ?> - MeSketch</title>

    <meta name="description" content="<?= htmlspecialchars($artikel['excerpt']) ?>">
    <meta name="keywords" content="design, graphic design, tips, tutorial">
    <meta name="author" content="<?= htmlspecialchars($artikel['author']) ?>">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../resources/assets/css/footer.css" rel="stylesheet" />

    <style>
        /* =========================
        GLOBAL
        ========================= */
        body {
            font-family: 'Lato', sans-serif;
            color: #333;
            background: #f7f5f3;
        }

        /* =========================
        NAVBAR
        ========================= */
        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 12px 0;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #ca9880 !important;
        }

        .navbar-nav .nav-link {
            color: #666;
            font-weight: 500;
            margin: 0 12px;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #ca9880;
        }

        /* =========================
        ARTICLE HEADER
        ========================= */
        .article-header {
            background: linear-gradient(135deg, #3b2f2f, #ca9880);
            color: #fff;
            padding: 70px 0 55px;
            margin-top: 70px;
        }

        .article-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.4rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 15px;
        }

        .article-meta {
            display: flex;
            gap: 25px;
            align-items: center;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .article-meta i {
            margin-right: 6px;
        }

        /* =========================
        ARTICLE CONTENT
        ========================= */
        .article-content {
            background: #fff;
            border-radius: 14px;
            padding: 45px;
            margin-top: -30px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        }

        .article-image {
            width: 100%;
            max-height: 480px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 35px;
        }

        .article-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #555;
        }

        .article-body p {
            margin-bottom: 18px;
        }

        /* =========================
        SIDEBAR
        ========================= */
        .sidebar {
            position: sticky;
            top: 90px;
        }

        .sidebar-widget {
            background: #fff;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 25px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        }

        .sidebar-widget h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 18px;
        }

        /* Author Avatar */
        .sidebar-widget .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #c4a484, #3b2f2f);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            overflow: hidden;
        }

        .sidebar-widget .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-widget .avatar-text {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 700;
        }

        /* =========================
        RECENT POST
        ========================= */
        .recent-post {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid #eee;
            transition: transform 0.3s;
        }

        .recent-post:last-child {
            border-bottom: none;
        }

        .recent-post:hover {
            transform: translateX(4px);
        }

        .recent-post img {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
        }

        .recent-post-info h5 {
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .recent-post-info h5 a {
            color: #333;
            text-decoration: none;
        }

        .recent-post-info h5 a:hover {
            color: #c4a484;
        }

        .recent-post-date {
            font-size: 0.8rem;
            color: #999;
        }

        /* =========================
        SHARE BUTTONS
        ========================= */
        .share-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }

        .share-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .share-facebook { background: #3b5998; }
        .share-twitter { background: #1da1f2; }
        .share-whatsapp { background: #25d366; }
        .share-linkedin { background: #0077b5; }

        /* =========================
        BACK BUTTON
        ========================= */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #c4a484, #ca9880);
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            margin-bottom: 25px;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        /* =========================
        FOOTER
        ========================= */
        .footer {
            background: #3b2f2f;
            color: #fff;
            padding: 25px 0 15px;
        }

        .footer h3 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
        }

        .footer a:hover {
            color: #fff;
        }

        .social-icons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .social-icons a {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: #ca9880;
            transform: translateY(-2px);
        }

        /* =========================
        RESPONSIVE
        ========================= */
        @media (max-width: 768px) {
            .article-title {
                font-size: 1.8rem;
            }

            .article-content {
                padding: 28px 20px;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">MeSketch</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#about-us">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#porto">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../index.php#blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Article Header -->
    <section class="article-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="article-title"><?= htmlspecialchars($artikel['judul']) ?></h1>
                    <div class="article-meta">
                        <span>
                            <i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($artikel['author']) ?>
                        </span>
                        <span>
                            <i class="bi bi-calendar-event"></i>
                            <?= formatTanggal($artikel['tanggal']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <a href="../index.php#blog" class="back-btn">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Blog
                    </a>

                    <div class="article-content">
                        <?php if ($artikel['gambar']): ?>
                            <img src="../img/blog/<?= htmlspecialchars($artikel['gambar']) ?>"
                                alt="<?= htmlspecialchars($artikel['judul']) ?>" class="article-image">
                        <?php endif; ?>

                        <div class="article-body">
                            <?= nl2br(htmlspecialchars($artikel['isi'])) ?>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons">
                            <strong>Bagikan:</strong>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
                                target="_blank" class="share-btn share-facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($artikel['judul']) ?>"
                                target="_blank" class="share-btn share-twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text=<?= urlencode($artikel['judul'] . ' ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
                                target="_blank" class="share-btn share-whatsapp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
                                target="_blank" class="share-btn share-linkedin">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Recent Posts Widget -->
                        <div class="sidebar-widget">
                            <h4><i class="bi bi-clock-history"></i> Artikel Terbaru</h4>
                            <?php if (empty($recentArticles)): ?>
                                <p class="text-muted">Belum ada artikel lain</p>
                            <?php else: ?>
                                <?php foreach ($recentArticles as $recent): ?>
                                    <div class="recent-post">
                                        <img src="../img/blog/<?= htmlspecialchars($recent['gambar']) ?>"
                                            alt="<?= htmlspecialchars($recent['judul']) ?>">
                                        <div class="recent-post-info">
                                            <h5>
                                                <a href="detail.php?id=<?= $recent['id_blog'] ?>">
                                                    <?= htmlspecialchars(substr($recent['judul'], 0, 50)) ?>        <?= strlen($recent['judul']) > 50 ? '...' : '' ?>
                                                </a>
                                            </h5>
                                            <div class="recent-post-date">
                                                <i class="bi bi-calendar3"></i>
                                                <?= formatTanggal($recent['tanggal']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Author Widget -->
                        <div class="sidebar-widget">
                            <h4><i class="bi bi-person-badge"></i> Tentang Penulis</h4>

                            <div style="text-align:center;">

                            <?php if (!empty($author)): ?>
                                <div class="user-avatar" style="margin:0 auto 15px;">
                                    <?php if (!empty($author['gambar'])): ?>
                                        <img src="../img/user/<?= htmlspecialchars($author['gambar']) ?>"
                                            alt="Avatar"
                                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                        <div class="avatar-text" style="display:none;">
                                            <?= strtoupper(substr($author['username'], 0, 1)) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="avatar-text">
                                            <?= strtoupper(substr($author['username'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <h5><?= htmlspecialchars($author['nama'] ?: $author['username']) ?></h5>
                                <small class="text-muted">@<?= htmlspecialchars($author['username']) ?></small>

                            <?php else: ?>
                                <div class="user-avatar" style="margin:0 auto 15px;">
                                    <div class="avatar-text">?</div>
                                </div>
                                <h5>Penulis tidak ditemukan</h5>
                            <?php endif; ?>

                                <p class="text-muted" style="font-size:0.9rem; margin-top:10px;">
                                    Writer di MeSketch yang berpengalaman dalam dunia desain interior.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3>MeSketch</h3>
                    <p>Konsultan design interior terbaik di indonesia</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h3>Quick Links</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#about-us">About</a></li>
                        <li class="mb-2"><a href="#portfolio">Portfolio</a></li>
                        <li class="mb-2"><a href="#blog">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Gunadarma Depok<br>Jalan Margonda Raya</p>
                    <p><i class="fas fa-phone me-2"></i> +91 22-27782183</p>
                    <p><i class="fas fa-envelope me-2"></i> support@mesketch.com</p>
                </div>
            </div>
            <div class="text-center mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <p class="mb-0">© 2024 MeSketch. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>