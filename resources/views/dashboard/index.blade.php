@extends('layouts.app')

@section('title', 'Dashboard - MeSketch')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
    <h2 class="h2" style="margin: 0;">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
    
    @if(auth()->user()->canManageContent())
        <div class="quick-actions">
            <a href="{{ route('manage.articles.create') }}" class="btn btn-primary">
                <span style="margin-right: 8px;">+</span> Buat Artikel Baru
            </a>
        </div>
    @endif
</div>

<div class="stats-grid">
    @if(!is_null($metrics['bookings']))
        <div class="stat-card">
            <label>Total Booking</label>
            <div class="value">{{ $metrics['bookings'] }}</div>
        </div>
    @endif

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

@if(!is_null($metrics['bookings']))
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
@endif

@if(auth()->user()->canManageContent())
    <div class="card" style="margin-top: 32px;">
        <div class="card-header">
            <h3>Artikel Terbaru</h3>
            <a href="{{ route('manage.articles.index') }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;">Lihat Semua</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Judul Artikel</th>
                    <th>Penulis</th>
                    <th>Tanggal Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestArticles as $article)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: var(--navy);">{{ $article->title }}</div>
                            <div style="font-size: 0.75rem; color: var(--muted);">Slug: {{ $article->slug }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $article->author->name }}</div>
                        </td>
                        <td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('manage.articles.edit', $article) }}" class="btn btn-outline" style="padding: 4px 8px; font-size: 0.75rem;">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 60px; color: var(--muted);">
                            Belum ada artikel yang dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif
@endsection
