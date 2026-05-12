@extends('layouts.app')

@section('title', 'Booking Saya - MeSketch')

@section('content')
<h2 class="h2">Kelola Booking</h2>

<div style="display: grid; grid-template-columns: 400px 1fr; gap: 32px; align-items: start;">
    <div class="card">
        <div class="card-header">
            <h3>Buat Pengajuan</h3>
        </div>
        <div style="padding: 32px;">
            <form action="{{ route('bookings.store') }}" method="POST" style="display: grid; gap: 24px;">
                @csrf
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Nama Proyek</label>
                    <input type="text" name="project_name" placeholder="Contoh: Renovasi Ruang Tamu" style="padding: 12px; border: 1px solid var(--border); border-radius: 8px;" required>
                </div>
                
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Tanggal Konsultasi</label>
                    <input type="date" name="booking_date" style="padding: 12px; border: 1px solid var(--border); border-radius: 8px;" required>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" style="padding: 12px; border: 1px solid var(--border); border-radius: 8px;" required>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Alamat</label>
                    <textarea name="address" rows="3" style="padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Riwayat Booking</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Proyek</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <div style="font-weight: 700;">{{ $booking->project_name }}</div>
                            <div style="font-size: 0.75rem; color: var(--muted);">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
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
                        <td colspan="3" style="text-align: center; padding: 60px; color: var(--muted);">
                            Belum ada riwayat booking.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
