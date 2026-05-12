<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard MeSketch')</title>
    <link rel="stylesheet" href="{{ asset('css/mesketch.css') }}">
</head>
<body>
    <header class="app-topbar">
        <div class="shell">
            <a class="brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                <span>Workspace MeSketch</span>
            </a>
            <div class="toolbar">
                <span class="muted">{{ auth()->user()->name }} · {{ strtoupper(auth()->user()->role) }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="button ghost" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </header>
    <main class="shell split">
        <aside class="sidebar">
            <div class="brand">
                <img src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                <span>Panel</span>
            </div>
            <nav class="side-nav">
                <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">Booking Saya</a>
                @if(auth()->user()->canManageContent())
                    <a class="{{ request()->routeIs('manage.articles.*') ? 'active' : '' }}" href="{{ route('manage.articles.index') }}">Artikel</a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">Testimoni</a>
                    <a class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}">Staff</a>
                    <a class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">Kelola Booking</a>
                @endif
                <a href="{{ route('landing') }}">Lihat Website</a>
            </nav>
        </aside>
        <section class="workspace">
            @if(session('status'))
                <div class="notice success">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="notice error">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </section>
    </main>
</body>
</html>
