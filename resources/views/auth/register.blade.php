@extends('layouts.site')
@section('title', 'Daftar - MeSketch')
@section('content')
<section class="auth-shell">
    <div class="shell auth-grid">
        <aside class="auth-copy">
            <p class="kicker">Akun klien</p>
            <h1>Buat akses untuk booking dan konsultasi.</h1>
            <p class="lead">Daftarkan profil Anda supaya setiap permintaan desain, jadwal, dan progres proyek tercatat dalam satu alur.</p>
        </aside>

        <div class="auth-card">
            <div class="auth-card-head">
                <h2>Daftar</h2>
                <p>Lengkapi data utama untuk membuat akun baru.</p>
            </div>

            @if($errors->any())
                <div class="auth-alert">{{ $errors->first() }}</div>
            @endif

            <form class="stack auth-form" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="field">
                    <label for="register-name">Nama</label>
                    <input id="register-name" name="name" value="{{ old('name') }}" autocomplete="name" required>
                </div>
                <div class="field">
                    <label for="register-email">Email</label>
                    <input id="register-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>
                <div class="field">
                    <label for="register-phone">Telepon</label>
                    <input id="register-phone" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                </div>
                <div class="field">
                    <label for="register-password">Password</label>
                    <input id="register-password" type="password" name="password" autocomplete="new-password" required>
                </div>
                <div class="field">
                    <label for="register-password-confirmation">Konfirmasi password</label>
                    <input id="register-password-confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                </div>
                <button type="submit">Daftar</button>
            </form>

            <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </div>
</section>
@endsection
