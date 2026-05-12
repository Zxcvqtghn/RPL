@extends('layouts.app')
@section('title', 'Dashboard - MeSketch')
@section('content')
<div class="page-head">
    <div><p class="kicker">Ringkasan</p><h2>Dashboard {{ $user->name }}</h2><p class="muted">Tampilan menyesuaikan role aktif.</p></div>
</div>
<div class="metric-grid">
    <article class="metric"><span class="muted">Booking</span><strong>{{ $metrics['bookings'] }}</strong></article>
    @if(!is_null($metrics['articles']))<article class="metric"><span class="muted">Artikel</span><strong>{{ $metrics['articles'] }}</strong></article>@endif
    @if(!is_null($metrics['testimonials']))<article class="metric"><span class="muted">Testimoni</span><strong>{{ $metrics['testimonials'] }}</strong></article>@endif
    @if(!is_null($metrics['staff']))<article class="metric"><span class="muted">Staff</span><strong>{{ $metrics['staff'] }}</strong></article>@endif
</div>
<div class="panel" style="margin-top:20px;">
    <div class="section-head"><div><p class="kicker">Aktivitas</p><h3>Booking terbaru</h3></div></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Proyek</th><th>Pemilik</th><th>Tanggal</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($latestBookings as $booking)
                <tr>
                    <td>{{ $booking->project_name }}</td>
                    <td>{{ $booking->relationLoaded('user') ? $booking->user->name : $user->name }}</td>
                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                    <td><span class="status {{ $booking->status }}">{{ strtoupper($booking->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada booking.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
