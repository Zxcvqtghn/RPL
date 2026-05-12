@extends('layouts.site')
@section('title', $article->title.' - MeSketch')
@section('content')
<section class="shell section" style="padding-top:56px;">
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
