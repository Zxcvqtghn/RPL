@extends('layouts.site')
@section('title', 'Daftar - MeSketch')
@section('footer_class', 'mt-0')
@section('content')
<section class="relative isolate overflow-hidden bg-navy px-4 pb-20 pt-48 text-white sm:px-6 sm:pt-52 lg:px-8 lg:pb-24 lg:pt-40">
    <img class="absolute inset-0 -z-20 h-full w-full object-cover opacity-35" src="{{ asset('site-assets/hero-interior.png') }}" alt="">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-slate-950/95 via-slate-900/85 to-slate-900/40"></div>
    <div class="mx-auto grid min-h-[calc(100vh-10rem)] w-full max-w-7xl items-center gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(24rem,34rem)] lg:gap-16">
        <aside class="max-w-3xl">
            <p class="mb-5 font-display text-sm font-extrabold uppercase tracking-[0.2em] text-accent-soft">Akun klien</p>
            <h1 class="font-display text-5xl font-extrabold leading-tight text-white sm:text-6xl">Buat akses untuk booking dan konsultasi.</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-white/80">Daftarkan profil Anda supaya setiap permintaan desain, jadwal, dan progres proyek tercatat dalam satu alur.</p>
        </aside>

        <div class="rounded-3xl border border-white/45 bg-white/95 p-6 text-ink shadow-rich backdrop-blur-xl sm:p-8">
            <div class="mb-7">
                <h2 class="font-display text-3xl font-extrabold text-navy">Daftar</h2>
                <p class="mt-2 text-muted">Lengkapi data utama untuk membuat akun baru.</p>
            </div>

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 font-bold text-rose-800">{{ $errors->first() }}</div>
            @endif

            <form class="grid gap-5" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="register-name">Nama</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="register-name" name="name" value="{{ old('name') }}" autocomplete="name" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="register-email">Email</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="register-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="register-phone">Telepon</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="register-phone" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="register-password">Password</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="register-password" type="password" name="password" autocomplete="new-password" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="register-password-confirmation">Konfirmasi password</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="register-password-confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                </div>
                <button class="inline-flex min-h-14 items-center justify-center rounded-full bg-accent px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong" type="submit">Daftar</button>
            </form>

            <p class="mt-6 text-center text-muted">Sudah punya akun? <a class="font-extrabold text-accent-strong" href="{{ route('login') }}">Masuk</a></p>
        </div>
    </div>
</section>
@endsection
