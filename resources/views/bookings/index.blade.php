@extends('layouts.app')
@section('title', 'Booking Saya - MeSketch')
@section('content')
<div class="page-head">
    <div><p class="kicker">Booking</p><h2>Ajukan konsultasi baru</h2></div>
</div>
<div class="content-grid">
    <section class="panel">
        <form class="stack" method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <div class="field"><label>Nama proyek</label><input name="project_name" value="{{ old('project_name') }}" required></div>
            <div class="field"><label>Tanggal booking</label><input type="date" name="booking_date" value="{{ old('booking_date') }}" required></div>
            <div class="field"><label>Telepon</label><input name="phone" value="{{ old('phone', auth()->user()->phone) }}" required></div>
            <div class="field"><label>Alamat</label><textarea name="address" required>{{ old('address') }}</textarea></div>
            <div class="field"><label>Catatan</label><textarea name="notes">{{ old('notes') }}</textarea></div>
            <button type="submit">Kirim booking</button>
        </form>
    </section>
    <section class="panel">
        <h3>Riwayat booking</h3>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Proyek</th><th>Tanggal</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->project_name }}</td>
                        <td>{{ $booking->booking_date->format('d M Y') }}</td>
                        <td><span class="status {{ $booking->status }}">{{ strtoupper($booking->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3">Belum ada booking.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
