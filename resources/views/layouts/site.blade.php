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
        <div class="shell">
            <div style="margin-bottom: 32px;">
                <a class="brand" href="{{ route('landing') }}" style="justify-content: center; margin-bottom: 16px;">
                    <img src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                    <span>MeSketch</span>
                </a>
                <p style="max-width: 500px; margin: 0 auto;">Konsultasi desain interior dengan struktur kerja yang lebih terukur dan hasil yang memuaskan.</p>
            </div>
            <div style="border-top: 1px solid var(--line); padding-top: 32px; font-size: 0.9rem; opacity: 0.6;">
                &copy; {{ date('Y') }} MeSketch Studio. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
