@extends('layouts.app')

@section('title', 'Kelola Testimoni - MeSketch')

@section('content')
<h2 class="h2">Kelola Testimoni</h2>

<div class="card">
    <div class="card-header">
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; color: var(--navy);">Daftar Testimoni Klien</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 4px;">Kelola testimoni yang akan ditampilkan di halaman depan.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            + Tambah Testimoni
        </a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Klien</th>
                <th>Label Peran</th>
                <th>Rating</th>
                <th>Status Tampil</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $testimonial)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--navy);">{{ $testimonial->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--muted); max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            "{{ $testimonial->message }}"
                        </div>
                    </td>
                    <td>{{ $testimonial->role_label }}</td>
                    <td>
                        <div style="color: #fbbf24; font-weight: 800;">
                            {{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}
                        </div>
                    </td>
                    <td>
                        <span class="status-pill {{ $testimonial->is_featured ? 'finished' : 'pending' }}">
                            {{ $testimonial->is_featured ? 'Unggulan' : 'Standar' }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem; color: #ef4444;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: var(--muted);">
                        Belum ada testimoni yang ditambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
