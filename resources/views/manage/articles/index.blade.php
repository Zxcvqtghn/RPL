@extends('layouts.app')
@section('title', 'Artikel - MeSketch')
@section('content')
<div class="page-head">
    <div><p class="kicker">Editorial</p><h2>Kelola artikel</h2></div>
    <a class="button" href="{{ route('manage.articles.create') }}">Artikel baru</a>
</div>
<div class="table-wrap">
    <table>
        <thead><tr><th>Judul</th><th>Penulis</th><th>Publikasi</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author->name }}</td>
                <td>{{ optional($article->published_at)->format('d M Y') }}</td>
                <td>
                    <div class="inline-actions">
                        <a class="button ghost" href="{{ route('manage.articles.edit', $article) }}">Edit</a>
                        <form method="POST" action="{{ route('manage.articles.destroy', $article) }}">@csrf @method('DELETE')<button class="button ghost" type="submit">Hapus</button></form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada artikel.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
