@extends('layouts.app')

@section('title', 'Dashboard - MeSketch')

@section('content')
<h2 class="h2">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>

<div class="stats-grid">
    <div class="stat-card">
        <label>Total Booking</label>
        <div class="value">{{ $metrics['bookings'] }}</div>
    </div>

    @if(!is_null($metrics['articles']))
        <div class="stat-card">
            <label>Artikel Terbit</label>
            <div class="value">{{ $metrics['articles'] }}</div>
        </div>
    @endif

    @if(!is_null($metrics['testimonials']))
        <div class="stat-card">
            <label>Testimoni</label>
            <div class="value">{{ $metrics['testimonials'] }}</div>
        </div>
    @endif

    @if(!is_null($metrics['staff']))
        <div class="stat-card">
            <label>Anggota Tim</label>
            <div class="value">{{ $metrics['staff'] }}</div>
        </div>
    @endif
</div>

<div class="card">
    <div class="card-header">
        <h3>Booking Terbaru</h3>
        <a href="{{ auth()->user()->isAdmin() ? route('admin.bookings.index') : route('bookings.index') }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;">Lihat Semua</a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Proyek</th>
                <th>Pemilik</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestBookings as $booking)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--navy);">{{ $booking->project_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--muted);">ID: #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $booking->relationLoaded('user') ? $booking->user->name : $user->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--muted);">{{ $booking->phone }}</div>
                    </td>
                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                    <td>
                        <span class="status-pill {{ $booking->status }}">
                            {{ $booking->status == 'pending' ? 'Menunggu' : ($booking->status == 'finished' ? 'Selesai' : 'Dibatalkan') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 60px; color: var(--muted);">
                        Belum ada data booking terbaru.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
