<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard MeSketch')</title>
    <link rel="stylesheet" href="{{ asset('css/mesketch.css') }}">
    <link rel="icon" href="{{ asset('site-assets/sm.png') }}">
</head>
<body class="dashboard">
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('site-assets/sm.png') }}" alt="MeSketch">
                <span>MeSketch</span>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">
                    Booking Saya
                </a>
                
                @if(auth()->user()->canManageContent())
                    <div class="nav-group">Konten</div>
                    <a class="nav-link {{ request()->routeIs('manage.articles.*') ? 'active' : '' }}" href="{{ route('manage.articles.index') }}">
                        Kelola Artikel
                    </a>
                @endif

                @if(auth()->user()->isAdmin())
                    <div class="nav-group">Administrasi</div>
                    <a class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                        Testimoni
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}">
                        Tim Staff
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
                        Kelola Booking
                    </a>
                @endif

                <div style="margin-top: auto; padding-bottom: 24px;">
                    <a class="nav-link" href="{{ route('landing') }}" target="_blank">
                        Lihat Website &nearr;
                    </a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-nav">
                <div class="user-profile">
                    <div class="user-name">
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>{{ auth()->user()->role }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline" style="padding: 8px 12px;" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            <div class="view-port">
                @if(session('status'))
                    <div class="notice-banner success">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="notice-banner error">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
