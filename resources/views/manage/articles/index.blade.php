@extends('layouts.app')

@section('title', 'Kelola Artikel - MeSketch')

@section('content')
<h2 class="h2">Kelola Konten Artikel</h2>

<div class="card">
    <div class="card-header">
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.1rem; color: var(--navy);">Editorial Blog & Wawasan</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 4px;">Publikasikan artikel inspiratif untuk klien MeSketch Studio.</p>
        </div>
        <a href="{{ route('manage.articles.create') }}" class="btn btn-primary">
            + Buat Artikel Baru
        </a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Judul Artikel</th>
                <th>Penulis</th>
                <th>Status / Tanggal</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--navy); max-width: 450px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $article->title }}
                        </div>
                        <div style="font-size: 0.75rem; color: var(--muted);">Slug: {{ $article->slug }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $article->author->name }}</div>
                    </td>
                    <td>
                        @if($article->published_at)
                            <div style="font-weight: 600; color: var(--ink);">{{ $article->published_at->format('d M Y') }}</div>
                            <div style="font-size: 0.75rem; color: var(--muted);">Terbit</div>
                        @else
                            <span class="status-pill pending">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('manage.articles.edit', $article) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                            <form action="{{ route('manage.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.8rem; color: #ef4444;">Hapus</button>
                            </form>
                        </div>
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
@endsection
