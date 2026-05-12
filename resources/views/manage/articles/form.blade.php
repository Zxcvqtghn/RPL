@extends('layouts.app')
@section('title', $article->exists ? 'Edit Artikel' : 'Artikel Baru')
@section('content')
<div class="page-head">
    <div><p class="kicker">Editorial</p><h2>{{ $article->exists ? 'Edit artikel' : 'Buat artikel baru' }}</h2></div>
</div>
<section class="panel">
    <form class="stack" method="POST" action="{{ $article->exists ? route('manage.articles.update', $article) : route('manage.articles.store') }}">
        @csrf
        @if($article->exists) @method('PUT') @endif
        <div class="field"><label>Judul</label><input name="title" value="{{ old('title', $article->title) }}" required></div>
        <div class="field"><label>Path cover</label><input name="cover_path" value="{{ old('cover_path', $article->cover_path) }}" placeholder="/legacy-media/blog/..."></div>
        <div class="field"><label>Isi</label><textarea name="body" required>{{ old('body', $article->body) }}</textarea></div>
        <button type="submit">Simpan artikel</button>
    </form>
</section>
@endsection
