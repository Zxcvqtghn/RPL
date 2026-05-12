@extends('layouts.app')

@section('title', 'Kelola Booking - MeSketch')

@section('content')
<h2 class="h2">Manajemen Booking Klien</h2>

<div class="card">
    <div class="card-header">
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; color: var(--navy);">Seluruh Antrian Konsultasi</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 4px;">Pantau dan ubah status pengajuan desain dari semua klien.</p>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Detail Klien</th>
                <th>Detail Proyek</th>
                <th>Tanggal Rencana</th>
                <th style="width: 300px;">Status & Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--navy);">{{ $booking->user->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--muted);">{{ $booking->user->email }}</div>
                        <div style="font-size: 0.8rem; color: var(--muted);">{{ $booking->phone }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--navy);">{{ $booking->project_name }}</div>
                        <div style="font-size: 0.8rem; color: var(--muted); max-width: 250px;">{{ $booking->address }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $booking->booking_date->format('d M Y') }}</div>
                        <div style="font-size: 0.75rem; color: var(--muted);">Dipesan: {{ $booking->created_at->diffForHumans() }}</div>
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" style="display: flex; gap: 8px;">
                            @csrf @method('PATCH')
                            <select name="status" style="padding: 8px; font-size: 0.85rem; border-radius: 6px; border: 1px solid var(--border); background: #f8fafc; flex: 1;">
                                @foreach(['pending' => 'Pending / Menunggu', 'finished' => 'Finished / Selesai', 'canceled' => 'Canceled / Batal'] as $value => $label)
                                    <option value="{{ $value }}" @selected($booking->status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary" style="padding: 8px 12px; font-size: 0.8rem;">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 80px; color: var(--muted);">
                        Belum ada antrian booking klien saat ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
