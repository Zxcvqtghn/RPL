@extends('layouts.site')
@section('title', 'Masuk - MeSketch')
@section('content')
<section class="auth-shell">
    <div class="shell auth-grid">
        <aside class="auth-copy">
            <p class="kicker">Akses akun</p>
            <h1>Masuk ke ruang konsultasi MeSketch.</h1>
            <p class="lead">Kelola booking, pantau proyek, dan lanjutkan percakapan desain Anda dari satu dashboard yang rapi.</p>
        </aside>

        <div class="auth-card">
            <div class="auth-card-head">
                <h2>Masuk</h2>
                <p>Gunakan email yang terdaftar untuk melanjutkan.</p>
            </div>

            @if($errors->any())
                <div class="auth-alert">{{ $errors->first() }}</div>
            @endif

            <form class="stack auth-form" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="field">
                    <label for="login-email">Email</label>
                    <input id="login-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>
                <div class="field">
                    <label for="login-password">Password</label>
                    <input id="login-password" type="password" name="password" autocomplete="current-password" required>
                </div>
                <label class="checkbox-row">
                    <input type="checkbox" name="remember" @checked(old('remember'))>
                    <span>Ingat saya</span>
                </label>
                <button type="submit">Masuk</button>
            </form>

            <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </div>
</section>
@endsection
