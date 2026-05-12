@extends('layouts.app')

@section('title', 'Dashboard - MeSketch')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="font-display text-3xl font-extrabold text-navy sm:text-4xl">Halo, {{ explode(' ', auth()->user()->name)[0] }}!</h2>

    @if(auth()->user()->canManageContent())
        <a href="{{ route('manage.articles.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-2xl bg-accent px-5 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong">
            <span class="mr-2 text-lg">+</span> Buat Artikel Baru
        </a>
    @endif
</div>

<div class="mb-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
    @if(!is_null($metrics['bookings']))
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
            <label class="text-xs font-extrabold uppercase tracking-[0.16em] text-muted">Total Booking</label>
            <div class="mt-3 font-display text-4xl font-extrabold text-navy">{{ $metrics['bookings'] }}</div>
        </div>
    @endif
    @if(!is_null($metrics['articles']))
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
            <label class="text-xs font-extrabold uppercase tracking-[0.16em] text-muted">Artikel Terbit</label>
            <div class="mt-3 font-display text-4xl font-extrabold text-navy">{{ $metrics['articles'] }}</div>
        </div>
    @endif
    @if(!is_null($metrics['testimonials']))
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
            <label class="text-xs font-extrabold uppercase tracking-[0.16em] text-muted">Testimoni</label>
            <div class="mt-3 font-display text-4xl font-extrabold text-navy">{{ $metrics['testimonials'] }}</div>
        </div>
    @endif
    @if(!is_null($metrics['staff']))
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
            <label class="text-xs font-extrabold uppercase tracking-[0.16em] text-muted">Anggota Tim</label>
            <div class="mt-3 font-display text-4xl font-extrabold text-navy">{{ $metrics['staff'] }}</div>
        </div>
    @endif
</div>

@if(!is_null($metrics['bookings']))
    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <h3 class="font-display text-xl font-extrabold text-navy">Booking Terbaru</h3>
            <a href="{{ auth()->user()->isAdmin() ? route('admin.bookings.index') : route('bookings.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 px-4 text-sm font-bold text-ink transition hover:bg-slate-50">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-[0.14em] text-muted">
                    <tr><th class="px-5 py-4 sm:px-7">Proyek</th><th class="px-5 py-4">Pemilik</th><th class="px-5 py-4">Tanggal</th><th class="px-5 py-4 sm:px-7">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($latestBookings as $booking)
                        <tr>
                            <td class="px-5 py-5 sm:px-7"><div class="font-bold text-navy">{{ $booking->project_name }}</div><div class="mt-1 text-xs text-muted">ID: #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div></td>
                            <td class="px-5 py-5"><div class="font-semibold">{{ $booking->relationLoaded('user') ? $booking->user->name : $user->name }}</div><div class="mt-1 text-xs text-muted">{{ $booking->phone }}</div></td>
                            <td class="whitespace-nowrap px-5 py-5">{{ $booking->booking_date->format('d M Y') }}</td>
                            <td class="px-5 py-5 sm:px-7"><span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold uppercase {{ $booking->status === 'finished' ? 'bg-emerald-100 text-emerald-800' : ($booking->status === 'canceled' ? 'bg-rose-100 text-rose-800' : 'bg-orange-100 text-orange-800') }}">{{ $booking->status == 'pending' ? 'Menunggu' : ($booking->status == 'finished' ? 'Selesai' : 'Dibatalkan') }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-14 text-center text-muted">Belum ada data booking terbaru.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif

@if(auth()->user()->canManageContent())
    <section class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <h3 class="font-display text-xl font-extrabold text-navy">Artikel Terbaru</h3>
            <a href="{{ route('manage.articles.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 px-4 text-sm font-bold text-ink transition hover:bg-slate-50">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-[0.14em] text-muted">
                    <tr><th class="px-5 py-4 sm:px-7">Judul Artikel</th><th class="px-5 py-4">Penulis</th><th class="px-5 py-4">Tanggal Terbit</th><th class="px-5 py-4 sm:px-7">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($latestArticles as $article)
                        <tr>
                            <td class="px-5 py-5 sm:px-7"><div class="font-bold text-navy">{{ $article->title }}</div><div class="mt-1 text-xs text-muted">Slug: {{ $article->slug }}</div></td>
                            <td class="px-5 py-5 font-semibold">{{ $article->author->name }}</td>
                            <td class="whitespace-nowrap px-5 py-5">{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                            <td class="px-5 py-5 sm:px-7"><a href="{{ route('manage.articles.edit', $article) }}" class="inline-flex min-h-9 items-center justify-center rounded-xl border border-slate-200 px-3 text-xs font-bold text-ink transition hover:bg-slate-50">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-14 text-center text-muted">Belum ada artikel yang dibuat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif
@endsection
