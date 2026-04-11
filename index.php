<?php
/**
 * Homepage - MeSketch
 * Final Version with Image Slider
 */

require_once 'includes/functions.php';

// Get data dari database
$bacaTesti = getAllTesti();
$bacaBlog = getAllArtikel();

// Limit blog yang ditampilkan (6 artikel terbaru)
$bacaBlog = array_slice($bacaBlog, 0, 6);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="assets/img/sm.png">
    <title>MeSketch - Konsultan Design Terbaik</title>

    <meta name="description" content="MeSketch - Konsultan design interior terbaik di indonesia">
    <meta name="keywords" content="design, graphic design, konsultan, tips, tutorial">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #ca9880;
            --secondary-color: #c4a484;
            --dark-color: #3b2f2f;
            --light-color: #f5f1eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            color: var(--dark-color);
            overflow-x: hidden;
            margin: 0 !important;      
            padding: 0 !important; 
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
        }

        /* Navigation */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            transition: all 0.3s;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-nav .nav-link {
            color: #666;
            font-weight: 500;
            margin: 0 15px;
            transition: color 0.3s;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transition: width 0.3s;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section with Slider */
        .hero-section {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .hero-slider {
            position: relative;
            width: 100%;
            height: 100vh;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            z-index: 1;
        }

        .hero-slide.active {
            opacity: 1;
            z-index: 2;
        }

        /* Overlay gelap untuk semua slide */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* Content di atas overlay */
        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeInDown 1s;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
            opacity: 0.9;
            animation: fadeInUp 1s;
        }

        .btn-hero {
            background: white;
            color: var(--primary-color);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
            animation: fadeInUp 1.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: var(--primary-color);
        }

        /* Slider Navigation Arrows */
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-nav:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-50%) scale(1.1);
        }

        .slider-nav.prev {
            left: 30px;
        }

        .slider-nav.next {
            right: 30px;
        }

        /* Slider Dots */
        .slider-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            gap: 15px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .dot.active,
        .dot:hover {
            background: white;
            transform: scale(1.3);
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .section-title .divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            margin: 0 auto 20px;
            border-radius: 2px;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }

        /* About Section */
        #about-us {
            padding: 100px 0;
            background: white;
        }

        /* Features Section */
        .feature-box {
            text-align: center;
            padding: 40px 20px;
            border-radius: 15px;
            transition: all 0.3s;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-box i {
            font-size: 3rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .feature-box h4 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Portfolio Section */
        #portfolio {
            padding: 150px 0;
            background: var(--light-color);
        }

        .portfolio-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .portfolio-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .portfolio-item:hover img {
            transform: scale(1.1);
        }

        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(212, 195, 183, 0.9) 0%, rgba(106, 68, 16, 0.9) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .portfolio-item:hover .portfolio-overlay {
            opacity: 1;
        }

        .portfolio-overlay-content {
            text-align: center;
            color: white;
        }

        .portfolio-overlay-content h4 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Blog Section */
        #blog {
            padding: 100px 0;
            background: white;
        }

        .blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .blog-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .blog-card-body {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            color: #999;
            font-size: 0.9rem;
        }

        .blog-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .blog-title a {
            color: var(--dark-color);
            text-decoration: none;
            transition: color 0.3s;
        }

        .blog-title a:hover {
            color: var(--primary-color);
        }

        .blog-excerpt {
            color: #666;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .btn-read-more {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            border: none;
        }

        .btn-read-more:hover {
            transform: translateX(5px);
            color: white;
        }

        /* FIX: Ensure Portfolio, Blog, and Testimonial backgrounds stretch to full viewport width */
        #portfolio,
        #blog,
        #testimonials {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
        }

        /* Testimonial Section */
        #testimonials {
            padding: 100px 0;
            /* FIX: Fixed invalid CSS from 'padding: px 0;' and set to 100px */
            background: linear-gradient(135deg, #97928a 0%, #9c5d41 100%);
            color: white;
        }

        .testimonial-item {
            text-align: center;
            padding: 40px;
        }

        .testimonial-text {
            font-size: 1.2rem;
            font-style: italic;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .testimonial-thumb {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid rgba(255, 255, 255, 0.3);
        }

        .testimonial-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .testimonial-author {
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Owl Carousel Custom */
        .owl-theme .owl-dots .owl-dot span {
            background: rgba(255, 255, 255, 0.3);
        }

        .owl-theme .owl-dots .owl-dot.active span {
            background: white;
        }

        .owl-theme .owl-nav [class*='owl-'] {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            margin: 5px;
            padding: 10px 15px;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .owl-theme .owl-nav [class*='owl-']:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Footer */
        .footer {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            background: #3b2f2f;
            color: white;
            padding: 60px 0 30px;
            margin-bottom: 0 !important;  /* ← TAMBAHKAN INI */
        }

        .footer h3 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .slider-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .slider-nav.prev {
                left: 15px;
            }

            .slider-nav.next {
                right: 15px;
            }

            /* .footer full-width fix has been moved out of this media query to apply globally */

            /* Pastikan tidak ada white gap */
            html,
            body {
                overflow-x: hidden;
            }
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="assets/img/sm.png" alt="Logo MeSketch" width="30" height="30" class="me-2">
                MeSketch</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about-us">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section">
        <div class="hero-slider">

            <div class="hero-slide active" style="background: url('assets/img/slider/bg1.jpg') center/cover no-repeat;">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="hero-title">Selamat Datang di MeSketch</h1>
                            <p class="hero-subtitle">Wujudkan Interior Impianmu</p>
                            <a href="login.php" class="btn btn-hero">
                                Booking Sekarang
                            </a>
                        </div>
                        <div class="col-lg-6 text-center"></div>
                    </div>
                </div>
            </div>

            <div class="hero-slide" style="background: url('assets/img/slider/bg3.jpg') center/cover no-repeat;">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="hero-title">Design Interior Profesional</h1>
                            <p class="hero-subtitle">
                                Menciptakan ruangan yang nyaman dan fungsional
                            </p>
                            <a href="#portfolio" class="btn btn-hero">
                                Lihat Portfolio
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-slide" style="background: url('assets/img/slider/bg2.jpg') center/cover no-repeat;">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="hero-title">Konsultasi Gratis</h1>
                            <p class="hero-subtitle">
                                Diskusikan ide desain anda dengan ahlinya
                            </p>
                            <a href="https://wa.me/?text=" class="btn btn-hero">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <button class="slider-nav prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-nav next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="slider-dots">
            <span class="dot active" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let slideIndex = 0;
            const slides = document.querySelectorAll(".hero-slide");
            const dots = document.querySelectorAll(".dot");

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove("active"));
                dots.forEach(dot => dot.classList.remove("active"));

                slides[index].classList.add("active");
                dots[index].classList.add("active");
            }

            function changeSlide(n) {
                slideIndex += n;

                if (slideIndex >= slides.length) slideIndex = 0;
                if (slideIndex < 0) slideIndex = slides.length - 1;

                showSlide(slideIndex);
            }

            function currentSlide(n) {
                slideIndex = n;
                showSlide(slideIndex);
            }

            // supaya bisa dipanggil dari onclick HTML
            window.changeSlide = changeSlide;
            window.currentSlide = currentSlide;

            // auto slide
            setInterval(() => {
                changeSlide(1);
            }, 5000);
        });
    </script>

    <section id="about-us">
        <div class="container">
            <div class="section-title">
                <h2>About Us</h2>
                <div class="divider"></div>
                <p>An interior is the natural projection of the soul - Coco Chanel</p>
            </div>
            <div class="row text-center">
                <div class="col-md-8 mx-auto">
                    <p class="lead">Setiap ide yang bagus akan menjadi hebat dengan adanya perencanaan yang baik. Disini
                        lah kami akan membantu mewujudkan ide tersebut dengan perencanaan yang kami berikan</p>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-border-all mb-3"></i>
                        <h4>Tata Ruang</h4>
                        <p>Menciptakan alur gerak yang efisien dan logis</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-lightbulb mb-3"></i>
                        <h4>Pencahayaan</h4>
                        <p>Membangun suasana yang nyaman</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-layer-group mb-3"></i>
                        <h4>Materials</h4>
                        <p>Menentukan material terbaik, tahan lama, serta memiliki standar keamanan</p>
                    </div>
                </div>
            </div>


            <section id="portfolio">
                <div class="container">
                    <div class="section-title text-center">
                        <h2>Portfolio</h2>
                        <div class="divider"></div>
                        <p>"The details are not the details. They make the design." – Charles Eames</p>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <img src="assets/img/portfolio/pt1.jpg" alt="Japanese Style Interior Design">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-overlay-content">
                                        <h4>Japanese Interior</h4>
                                        <span>Residential Design</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <img src="assets/img/portfolio/ptcom.jpg" alt="Industrial Interior Design">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-overlay-content">
                                        <h4>Industrial Interior</h4>
                                        <span>Commercial Space</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <img src="assets/img/portfolio/ptliving.jpg" alt="Modern Minimalist Interior">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-overlay-content">
                                        <h4>Modern Minimalist</h4>
                                        <span>Living Room</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <img src="assets/img/portfolio/pt4.jpg" alt="Scandinavian Interior Design">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-overlay-content">
                                        <h4>Scandinavian Interior</h4>
                                        <span>Residential Design</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <img src="assets/img/portfolio/pt5.jpg" alt="Contemporary Interior Design">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-overlay-content">
                                        <h4>Contemporary Interior</h4>
                                        <span>Office Space</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <img src="assets/img/portfolio/pt6.jpg" alt="Luxury Interior Design">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-overlay-content">
                                        <h4>Luxury Interior</h4>
                                        <span>Master Bedroom</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section id="blog">
                <div class="container">
                    <div class="section-title">
                        <h2>Kamu Harus Tahu!!</h2>
                        <div class="divider"></div>
                        <p>Berbagai hal yang harus kamu ketahui</p>
                    </div>

                    <div class="row">
                        <?php if (empty($bacaBlog)): ?>
                            <div class="col-12 text-center">
                                <p class="text-muted">Belum ada artikel</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($bacaBlog as $blog): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="blog-card">
                                        <img src="img/blog/<?= htmlspecialchars($blog['gambar']) ?>"
                                            alt="<?= htmlspecialchars($blog['judul']) ?>">
                                        <div class="blog-card-body">
                                            <div class="blog-meta">
                                                <span><i class="far fa-calendar"></i>
                                                    <?= formatTanggal($blog['tanggal']) ?></span>
                                                <span><i class="far fa-user"></i>
                                                    <?= htmlspecialchars($blog['author']) ?></span>
                                            </div>
                                            <h3 class="blog-title">
                                                <a href="blog/detail.php?id=<?= $blog['id_blog'] ?>">
                                                    <?= htmlspecialchars($blog['judul']) ?>
                                                </a>
                                            </h3>
                                            <p class="blog-excerpt"><?= htmlspecialchars($blog['excerpt']) ?></p>
                                            <a href="blog/detail.php?id=<?= $blog['id_blog'] ?>" class="btn-read-more">
                                                Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <section id="testimonials" class="container-fluid px-0">
                <div class="container">
                    <div class="section-title">
                        <h2 style="color: white;">Testimonials</h2>
                        <div class="divider" style="background: white;"></div>
                        <p style="color: rgba(255,255,255,0.9);">Apa kata mereka tentang kami</p>
                    </div>

                    <?php if (empty($bacaTesti)): ?>
                        <div class="text-center">
                            <p>Belum ada testimoni</p>
                        </div>
                    <?php else: ?>
                        <div id="owl-testimonials" class="owl-carousel owl-theme">
                            <?php foreach ($bacaTesti as $testi): ?>
                                <div class="testimonial-item">
                                    <div class="testimonial-thumb">
                                        <img src="assets/img/testimonial/1.jpg" alt="<?= htmlspecialchars($testi['nama']) ?>">
                                    </div>
                                    <p class="testimonial-text">"<?= htmlspecialchars($testi['isi']) ?>"</p>
                                    <h5 class="testimonial-author"><?= htmlspecialchars($testi['nama']) ?></h5>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>


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

            <!-- Back to Top Button -->
    <a href="#home" class="btn btn-primary rounded-circle"
        style="position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; z-index: 1000;">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Owl Carousel (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.15)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });

        // Initialize Owl Carousel for Testimonials
        $(document).ready(function () {
            $("#owl-testimonials").owlCarousel({
                items: 1,
                loop: true,
                margin: 30,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                nav: true,
                dots: true,
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1024: {
                        items: 3
                    }
                }
            });
        });
    </script>

</body>

</html>