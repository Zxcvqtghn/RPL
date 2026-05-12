@extends('layouts.site')
@section('title', 'Masuk - MeSketch')
@section('footer_class', 'mt-0')
@section('content')
<section class="relative isolate overflow-hidden bg-navy px-4 pb-20 pt-32 text-white sm:px-6 sm:pt-36 lg:px-8 lg:pb-24 lg:pt-40">
    <img class="absolute inset-0 -z-20 h-full w-full object-cover opacity-35" src="{{ asset('site-assets/hero-interior.png') }}" alt="">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-slate-950/95 via-slate-900/85 to-slate-900/40"></div>
    <div class="mx-auto grid min-h-[calc(100vh-10rem)] w-full max-w-7xl items-center gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(24rem,32rem)] lg:gap-16">
        <aside class="max-w-3xl">
            <p class="mb-5 font-display text-sm font-extrabold uppercase tracking-[0.2em] text-accent-soft">Akses akun</p>
            <h1 class="font-display text-5xl font-extrabold leading-tight text-white sm:text-6xl">Masuk ke ruang konsultasi MeSketch.</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-white/80">Kelola booking, pantau proyek, dan lanjutkan percakapan desain Anda dari satu dashboard yang rapi.</p>
        </aside>

        <div class="rounded-3xl border border-white/45 bg-white/95 p-6 text-ink shadow-rich backdrop-blur-xl sm:p-8">
            <div class="mb-7">
                <h2 class="font-display text-3xl font-extrabold text-navy">Masuk</h2>
                <p class="mt-2 text-muted">Gunakan email yang terdaftar untuk melanjutkan.</p>
            </div>

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 font-bold text-rose-800">{{ $errors->first() }}</div>
            @endif

            <form class="grid gap-5" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="login-email">Email</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="login-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-bold text-ink-soft" for="login-password">Password</label>
                    <input class="min-h-14 rounded-2xl border border-slate-200 bg-white px-4 outline-none ring-0 transition focus:border-accent focus:ring-4 focus:ring-accent/15" id="login-password" type="password" name="password" autocomplete="current-password" required>
                </div>
                <label class="inline-flex w-fit items-center gap-3 font-semibold text-ink-soft">
                    <input class="h-4 w-4 rounded border-slate-300 accent-accent" type="checkbox" name="remember" @checked(old('remember'))>
                    <span>Ingat saya</span>
                </label>
                <button class="inline-flex min-h-14 items-center justify-center rounded-full bg-accent px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong" type="submit">Masuk</button>
            </form>

            <p class="mt-6 text-center text-muted">Belum punya akun? <a class="font-extrabold text-accent-strong" href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </div>
</section>
@endsection
