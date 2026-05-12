<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard MeSketch')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('site-assets/sm.png') }}">
</head>
<body class="min-h-screen bg-slate-50 text-ink">
    <div class="min-h-screen lg:flex">
        <div id="mobile-admin-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/55 backdrop-blur-sm lg:hidden"></div>
        <aside id="mobile-admin-drawer" class="fixed inset-y-0 left-0 z-50 flex w-[min(20rem,88vw)] -translate-x-full flex-col bg-slate-950 text-white shadow-2xl transition duration-300 lg:hidden">
            <div class="flex items-center justify-between gap-4 border-b border-white/10 px-5 py-5">
                <a class="flex items-center gap-3 font-display text-lg font-extrabold" href="{{ route('dashboard') }}">
                    <img class="h-9 w-9 object-contain" src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                    <span>MeSketch</span>
                </a>
                <button type="button" data-mobile-admin-close class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 text-xl font-semibold text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup menu">
                    &times;
                </button>
            </div>

            <nav class="flex flex-1 flex-col gap-1 overflow-y-auto px-4 py-5">
                <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('dashboard') }}">Dashboard</a>
                @if(auth()->user()->role === 'user')
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('bookings.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('bookings.index') }}">Booking Saya</a>
                @endif
                @if(auth()->user()->canManageContent())
                    <div class="px-4 pb-2 pt-6 text-[0.7rem] font-extrabold uppercase tracking-[0.18em] text-white/35">Konten</div>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('manage.articles.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('manage.articles.index') }}">Kelola Artikel</a>
                @endif
                @if(auth()->user()->isAdmin())
                    <div class="px-4 pb-2 pt-6 text-[0.7rem] font-extrabold uppercase tracking-[0.18em] text-white/35">Administrasi</div>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.testimonials.index') }}">Testimoni</a>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.staff.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.staff.index') }}">Tim Staff</a>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.bookings.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.bookings.index') }}">Kelola Booking</a>
                @endif
                <div class="mt-auto pt-8">
                    <a class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white" href="{{ route('landing') }}" target="_blank">Lihat Website &nearr;</a>
                </div>
            </nav>
        </aside>

        <aside class="hidden w-72 shrink-0 flex-col bg-slate-950 text-white lg:sticky lg:top-0 lg:flex lg:h-screen">
            <div class="flex items-center gap-3 px-6 py-8 font-display text-xl font-extrabold">
                <img class="h-9 w-9 object-contain" src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                <span>MeSketch</span>
            </div>
            
            <nav class="flex flex-1 flex-col gap-1 px-4 pb-6">
                <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>

                @if(auth()->user()->role === 'user')
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('bookings.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('bookings.index') }}">
                        Booking Saya
                    </a>
                @endif
                
                @if(auth()->user()->canManageContent())
                    <div class="px-4 pb-2 pt-6 text-[0.7rem] font-extrabold uppercase tracking-[0.18em] text-white/35">Konten</div>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('manage.articles.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('manage.articles.index') }}">
                        Kelola Artikel
                    </a>
                @endif

                @if(auth()->user()->isAdmin())
                    <div class="px-4 pb-2 pt-6 text-[0.7rem] font-extrabold uppercase tracking-[0.18em] text-white/35">Administrasi</div>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.testimonials.index') }}">
                        Testimoni
                    </a>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.staff.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.staff.index') }}">
                        Tim Staff
                    </a>
                    <a class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('admin.bookings.*') ? 'bg-accent text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.bookings.index') }}">
                        Kelola Booking
                    </a>
                @endif

                <div class="mt-auto pt-8">
                    <a class="block rounded-2xl px-4 py-3 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white" href="{{ route('landing') }}" target="_blank">
                        Lihat Website &nearr;
                    </a>
                </div>
            </nav>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto flex min-h-20 w-full max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:justify-end lg:px-10">
                    <div class="flex items-center gap-3 lg:hidden">
                        <button type="button" data-mobile-admin-open class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-xl font-bold text-navy transition hover:bg-slate-50" aria-label="Buka menu admin">
                            ☰
                        </button>
                        <a class="flex items-center gap-3 font-display text-lg font-extrabold text-navy" href="{{ route('dashboard') }}">
                            <img class="h-9 w-9 object-contain" src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                            <span>MeSketch</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-5">
                        <div class="text-right">
                            <strong class="block font-display text-sm font-extrabold text-ink">{{ auth()->user()->name }}</strong>
                            <span class="text-[0.7rem] font-extrabold uppercase tracking-[0.16em] text-muted">{{ auth()->user()->role }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 px-4 font-display text-sm font-bold text-ink transition hover:bg-slate-50" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                @if(session('status'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 font-semibold text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
