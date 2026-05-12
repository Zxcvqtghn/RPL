@extends('layouts.site')
@section('title', 'Daftar - MeSketch')
@section('content')
<section class="auth-shell">
    <div class="auth-card">
        <p class="kicker">Akun klien</p>
        <h2>Buat akses booking</h2>
        <form class="stack" method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="field"><label>Nama</label><input name="name" value="{{ old('name') }}" required></div>
            <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            <div class="field"><label>Telepon</label><input name="phone" value="{{ old('phone') }}"></div>
            <div class="field"><label>Password</label><input type="password" name="password" required></div>
            <div class="field"><label>Konfirmasi password</label><input type="password" name="password_confirmation" required></div>
            <button type="submit">Daftar</button>
        </form>
    </div>
</section>
@endsection
