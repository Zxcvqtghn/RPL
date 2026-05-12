<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MeSketch - Modern Interior Design')</title>
    <link rel="stylesheet" href="{{ asset('css/mesketch.css') }}">
    <link rel="icon" href="{{ asset('site-assets/sm.png') }}">
</head>
<body>
    <header class="site-header">
        <div class="shell nav">
            <a class="brand" href="{{ route('landing') }}">
                <img src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                <span>MeSketch</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('landing') }}#layanan">Layanan</a>
                <a href="{{ route('landing') }}#artikel">Artikel</a>
                <a href="{{ route('landing') }}#testimoni">Testimoni</a>
                @auth
                    <a class="button dark" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <div style="display: flex; gap: 12px;">
                        <a class="button ghost" href="{{ route('login') }}">Masuk</a>
                        <a class="button" href="{{ route('register') }}">Daftar</a>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="shell footer-grid">
            <div class="footer-brand">
                <a class="brand" href="{{ route('landing') }}">
                    <img src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                    <span>MeSketch</span>
                </a>
                <p>Konsultasi desain interior dengan alur kerja yang terukur, komunikasi jelas, dan hasil yang terasa personal.</p>
            </div>

            <div class="footer-links">
                <p class="footer-label">Navigasi</p>
                <a href="{{ route('landing') }}#layanan">Layanan</a>
                <a href="{{ route('landing') }}#artikel">Artikel</a>
                <a href="{{ route('landing') }}#testimoni">Testimoni</a>
            </div>

            <div class="footer-cta">
                <p class="footer-label">Mulai proyek</p>
                <h3>Rancang ruang dengan brief yang lebih jelas.</h3>
                <div class="footer-actions">
                    <a class="button" href="{{ route('register') }}">Daftar</a>
                    <a class="button ghost" href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>

        <div class="shell footer-bottom">
            <span>&copy; {{ date('Y') }} MeSketch Studio. All rights reserved.</span>
            <span>Interior planning, consultation, and project tracking.</span>
        </div>
    </footer>
</body>
</html>
