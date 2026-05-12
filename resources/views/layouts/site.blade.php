<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MeSketch - Modern Interior Design')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('site-assets/sm.png') }}">
</head>
<body class="min-h-screen bg-paper text-ink">
    <header class="fixed inset-x-0 top-3 z-50 px-4 sm:top-6 sm:px-6">
        <div class="relative z-50 mx-auto w-full max-w-7xl rounded-3xl border border-white/60 bg-white/85 px-4 py-3 shadow-soft backdrop-blur-xl sm:px-6 lg:px-8">
            <div class="flex min-h-14 items-center justify-between gap-4">
                <a class="flex items-center gap-3 font-display text-xl font-extrabold text-navy" href="{{ route('landing') }}">
                    <img class="h-10 w-10 object-contain" src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                    <span>MeSketch</span>
                </a>
                
                <nav class="hidden items-center gap-6 lg:flex">
                    <a class="font-semibold text-ink-soft transition hover:text-accent-strong" href="{{ route('landing') }}#layanan">Layanan</a>
                    <a class="font-semibold text-ink-soft transition hover:text-accent-strong" href="{{ route('landing') }}#artikel">Artikel</a>
                    <a class="font-semibold text-ink-soft transition hover:text-accent-strong" href="{{ route('landing') }}#testimoni">Testimoni</a>
                    @auth
                        <a class="inline-flex min-h-12 items-center justify-center rounded-full bg-navy px-6 font-display font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-slate-800" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <div class="flex items-center gap-3">
                            <a class="inline-flex min-h-12 items-center justify-center rounded-full border border-slate-200 bg-white px-6 font-display font-bold text-ink transition hover:-translate-y-0.5 hover:border-slate-300" href="{{ route('login') }}">Masuk</a>
                            <a class="inline-flex min-h-12 items-center justify-center rounded-full bg-accent px-6 font-display font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-accent-strong" href="{{ route('register') }}">Daftar</a>
                        </div>
                    @endauth
                </nav>

                <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="lg:hidden relative z-[100] cursor-pointer p-2 text-navy focus:outline-none transition hover:text-accent-strong" aria-label="Buka menu">
                    <svg class="h-7 w-7 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <div id="mobile-drawer-overlay" onclick="toggleMobileMenu()" class="fixed inset-0 z-[60] bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden"></div>

    <div id="mobile-drawer" class="fixed inset-y-0 right-0 z-[70] w-3/4 sm:w-80 bg-white shadow-2xl transform transition-transform duration-300 translate-x-full lg:hidden flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-slate-100">
            <span class="font-display text-lg font-extrabold text-navy">Menu</span>
            <button id="close-menu-btn" onclick="toggleMobileMenu()" class="p-2 text-slate-400 hover:text-navy focus:outline-none transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-6 px-6 flex flex-col gap-6">
            <nav class="flex flex-col gap-4">
                <a class="mobile-nav-link font-display text-lg font-bold text-navy hover:text-accent-strong" onclick="toggleMobileMenu()" href="{{ route('landing') }}#layanan">Layanan</a>
                <a class="mobile-nav-link font-display text-lg font-bold text-navy hover:text-accent-strong" onclick="toggleMobileMenu()" href="{{ route('landing') }}#artikel">Artikel</a>
                <a class="mobile-nav-link font-display text-lg font-bold text-navy hover:text-accent-strong" onclick="toggleMobileMenu()" href="{{ route('landing') }}#testimoni">Testimoni</a>
            </nav>
            <div class="border-t border-slate-100 pt-6 flex flex-col gap-3">
                @auth
                    <a class="inline-flex min-h-12 w-full items-center justify-center rounded-full bg-navy px-6 font-display font-bold text-white shadow-soft transition hover:bg-slate-800" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="inline-flex min-h-12 w-full items-center justify-center rounded-full border border-slate-200 bg-white px-6 font-display font-bold text-ink transition hover:border-slate-300" href="{{ route('login') }}">Masuk</a>
                    <a class="inline-flex min-h-12 w-full items-center justify-center rounded-full bg-accent px-6 font-display font-bold text-white shadow-soft transition hover:bg-accent-strong" href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="@yield('footer_class', 'mt-10') bg-navy px-4 py-16 text-white/80 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto grid w-full max-w-7xl gap-10 lg:grid-cols-[1.15fr_0.55fr_0.9fr]">
            <div>
                <a class="mb-5 flex items-center gap-3 font-display text-xl font-extrabold text-white" href="{{ route('landing') }}">
                    <img class="h-10 w-10 object-contain" src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                    <span>MeSketch</span>
                </a>
                <p class="max-w-md text-base leading-7 text-white/70">Konsultasi desain interior dengan alur kerja yang terukur, komunikasi jelas, dan hasil yang terasa personal.</p>
            </div>

            <div class="grid content-start gap-4">
                <p class="font-display text-xs font-extrabold uppercase tracking-[0.18em] text-accent-soft">Navigasi</p>
                <a class="w-fit font-bold text-white transition hover:text-accent-soft" href="{{ route('landing') }}#layanan">Layanan</a>
                <a class="w-fit font-bold text-white transition hover:text-accent-soft" href="{{ route('landing') }}#artikel">Artikel</a>
                <a class="w-fit font-bold text-white transition hover:text-accent-soft" href="{{ route('landing') }}#testimoni">Testimoni</a>
            </div>

            <div>
                <p class="mb-4 font-display text-xs font-extrabold uppercase tracking-[0.18em] text-accent-soft">Mulai proyek</p>
                <h3 class="mb-6 font-display text-2xl font-extrabold leading-tight text-white">Rancang ruang dengan brief yang lebih jelas.</h3>
                <div class="flex flex-wrap gap-3">
                    <a class="inline-flex min-h-12 items-center justify-center rounded-full bg-accent px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong" href="{{ route('register') }}">Daftar</a>
                    <a class="inline-flex min-h-12 items-center justify-center rounded-full border border-white/25 px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-white hover:text-ink" href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>

        <div class="mx-auto mt-12 flex w-full max-w-7xl flex-col gap-3 border-t border-white/10 pt-7 text-sm text-white/55 sm:flex-row sm:items-center sm:justify-between">
            <span>&copy; {{ date('Y') }} MeSketch Studio. All rights reserved.</span>
            <span>Interior planning, consultation, and project tracking.</span>
        </div>
    </footer>
    <script>
        window.toggleMobileMenu = function() {
            const drawer = document.getElementById('mobile-drawer');
            const overlay = document.getElementById('mobile-drawer-overlay');
            if (!drawer || !overlay) return;
            
            const isClosed = drawer.classList.contains('translate-x-full');
            if (isClosed) {
                drawer.classList.remove('translate-x-full');
                drawer.classList.add('translate-x-0');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            } else {
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }
        };
    </script>
</body>
</html>
