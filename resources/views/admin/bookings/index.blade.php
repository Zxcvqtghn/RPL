@extends('layouts.app')
@section('title', 'Kelola Booking - MeSketch')
@section('content')
<div class="page-head"><div><p class="kicker">Operasional</p><h2>Kelola booking klien</h2></div></div>
<div class="table-wrap"><table><thead><tr><th>Klien</th><th>Proyek</th><th>Tanggal</th><th>Status</th></tr></thead><tbody>
@forelse($bookings as $booking)
<tr>
    <td>{{ $booking->user->name }}<br><span class="muted">{{ $booking->user->email }}</span></td>
    <td>{{ $booking->project_name }}<br><span class="muted">{{ $booking->address }}</span></td>
    <td>{{ $booking->booking_date->format('d M Y') }}</td>
    <td>
        <form class="inline-actions" method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf @method('PATCH')
            <select name="status">
                @foreach(['pending' => 'Pending', 'finished' => 'Finished', 'canceled' => 'Canceled'] as $value => $label)
                    <option value="{{ $value }}" @selected($booking->status === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit">Simpan</button>
        </form>
    </td>
</tr>
@empty <tr><td colspan="4">Belum ada booking.</td></tr> @endforelse
</tbody></table></div>
@endsection
