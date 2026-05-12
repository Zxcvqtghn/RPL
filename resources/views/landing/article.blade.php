@extends('layouts.site')
@section('title', $article->title.' - MeSketch')
@section('content')
<section class="shell section article-detail">
    <div class="article-toolbar">
        <a class="article-back" href="{{ route('landing') }}#artikel">
            <span aria-hidden="true">&larr;</span>
            <span>Kembali ke daftar artikel</span>
        </a>
    </div>
    <div class="content-grid">
        <article class="panel">
            <p class="kicker">{{ $article->author->name }} · {{ optional($article->published_at)->format('d M Y') }}</p>
            <h2>{{ $article->title }}</h2>
            <p class="muted">{{ $article->excerpt }}</p>
            <div class="article-body">{{ $article->body }}</div>
        </article>
        <aside class="panel">
            <img class="card-media" src="{{ $article->cover_path ?: asset('site-assets/portfolio/ptliving.jpg') }}" alt="{{ $article->title }}">
        </aside>
    </div>
</section>
@endsection
