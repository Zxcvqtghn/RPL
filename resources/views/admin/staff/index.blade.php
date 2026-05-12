@extends('layouts.app')

@section('title', 'Kelola Staff - MeSketch')

@section('content')
<h2 class="h2">Manajemen Tim Staff</h2>

<div class="card">
    <div class="card-header">
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; color: var(--navy);">Daftar Anggota Tim</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 4px;">Kelola akun admin dan penulis untuk MeSketch Studio.</p>
        </div>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
            + Tambah Anggota
        </a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Anggota</th>
                <th>Alamat Email</th>
                <th>Telepon</th>
                <th>Peran / Akses</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staff as $member)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--navy);">{{ $member->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--muted);">Dibuat pada: {{ $member->created_at->format('d M Y') }}</div>
                    </td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?: '-' }}</td>
                    <td>
                        <span class="status-pill {{ $member->role == 'admin' ? 'finished' : 'pending' }}" style="font-size: 0.65rem;">
                            {{ strtoupper($member->role) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.staff.edit', $member) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                            @if(auth()->id() !== $member->id)
                                <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota tim ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem; color: #ef4444;">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: var(--muted);">
                        Belum ada anggota tim selain kamu.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
