@extends('layouts.site')
@section('title', 'Masuk - MeSketch')
@section('content')
<section class="auth-shell">
    <div class="auth-card">
        <p class="kicker">Akses akun</p>
        <h2>Masuk ke workspace</h2>
        <form class="stack" method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            <div class="field"><label>Password</label><input type="password" name="password" required></div>
            <label><input style="width:auto;" type="checkbox" name="remember"> Ingat saya</label>
            <button type="submit">Masuk</button>
        </form>
    </div>
</section>
@endsection
