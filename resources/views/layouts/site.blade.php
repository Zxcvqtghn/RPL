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
        <div class="mx-auto flex min-h-18 w-full max-w-7xl items-center justify-between rounded-3xl border border-white/60 bg-white/85 px-4 py-3 shadow-soft backdrop-blur-xl sm:px-6 lg:px-8">
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
        </div>
    </header>

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
</body>
</html>
