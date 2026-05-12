@extends('layouts.app')

@section('title', 'Booking Saya - MeSketch')

@section('content')
<h2 class="mb-8 font-display text-3xl font-extrabold text-navy sm:text-4xl">Kelola Booking</h2>

<div class="grid gap-6 xl:grid-cols-[minmax(22rem,26rem)_minmax(0,1fr)]">
    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
        <div class="border-b border-slate-200 px-5 py-5 sm:px-7"><h3 class="font-display text-xl font-extrabold text-navy">Buat Pengajuan</h3></div>
        <div class="p-5 sm:p-7">
            <form action="{{ route('bookings.store') }}" method="POST" class="grid gap-5">
                @csrf
                <div class="grid gap-2"><label class="text-xs font-extrabold uppercase tracking-[0.14em] text-muted">Nama Proyek</label><input class="min-h-13 rounded-2xl border border-slate-200 bg-white px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" type="text" name="project_name" placeholder="Contoh: Renovasi Ruang Tamu" required></div>
                <div class="grid gap-2"><label class="text-xs font-extrabold uppercase tracking-[0.14em] text-muted">Tanggal Konsultasi</label><input class="min-h-13 rounded-2xl border border-slate-200 bg-white px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" type="date" name="booking_date" required></div>
                <div class="grid gap-2"><label class="text-xs font-extrabold uppercase tracking-[0.14em] text-muted">Nomor Telepon</label><input class="min-h-13 rounded-2xl border border-slate-200 bg-white px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" type="text" name="phone" value="{{ auth()->user()->phone }}" required></div>
                <div class="grid gap-2"><label class="text-xs font-extrabold uppercase tracking-[0.14em] text-muted">Alamat</label><textarea class="min-h-28 rounded-2xl border border-slate-200 bg-white px-4 py-3 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="address" rows="3" required></textarea></div>
                <button type="submit" class="inline-flex min-h-13 w-full items-center justify-center rounded-2xl bg-accent px-5 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong">Kirim Pengajuan</button>
            </form>
        </div>
    </section>

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
        <div class="border-b border-slate-200 px-5 py-5 sm:px-7"><h3 class="font-display text-xl font-extrabold text-navy">Riwayat Booking</h3></div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-[0.14em] text-muted"><tr><th class="px-5 py-4 sm:px-7">Proyek</th><th class="px-5 py-4">Tanggal</th><th class="px-5 py-4 sm:px-7">Status</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr><td class="px-5 py-5 sm:px-7"><div class="font-bold">{{ $booking->project_name }}</div><div class="mt-1 text-xs text-muted">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div></td><td class="whitespace-nowrap px-5 py-5">{{ $booking->booking_date->format('d M Y') }}</td><td class="px-5 py-5 sm:px-7"><span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold uppercase {{ $booking->status === 'finished' ? 'bg-emerald-100 text-emerald-800' : ($booking->status === 'canceled' ? 'bg-rose-100 text-rose-800' : 'bg-orange-100 text-orange-800') }}">{{ $booking->status == 'pending' ? 'Menunggu' : ($booking->status == 'finished' ? 'Selesai' : 'Dibatalkan') }}</span></td></tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-14 text-center text-muted">Belum ada riwayat booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
