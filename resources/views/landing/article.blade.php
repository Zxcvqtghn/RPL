@extends('layouts.site')
@section('title', $article->title.' - MeSketch')
@section('content')
<section class="px-4 pb-20 pt-32 sm:px-6 sm:pt-36 lg:px-8 lg:pb-28 lg:pt-40">
    <div class="mx-auto w-full max-w-7xl">
        <div class="mb-7">
        <a class="inline-flex min-h-12 items-center gap-3 rounded-full border border-slate-200 bg-white px-5 font-display font-extrabold text-navy shadow-soft transition hover:-translate-y-0.5 hover:border-navy hover:bg-navy hover:text-white" href="{{ route('landing') }}#artikel">
            <span aria-hidden="true">&larr;</span>
            <span>Kembali ke daftar artikel</span>
        </a>
        </div>
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1.35fr)_minmax(20rem,0.8fr)] lg:gap-8">
            <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8 lg:p-10">
                <p class="font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">{{ $article->author->name }} · {{ optional($article->published_at)->format('d M Y') }}</p>
                <h2 class="mt-5 font-display text-4xl font-extrabold leading-tight text-navy sm:text-5xl">{{ $article->title }}</h2>
                <p class="mt-5 text-lg leading-8 text-muted">{{ $article->excerpt }}</p>
                <div class="mt-8 whitespace-pre-line leading-8 text-ink-soft">{{ $article->body }}</div>
            </article>
            <aside class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
                <img class="aspect-[16/11] h-full w-full object-cover lg:aspect-[4/5]" src="{{ $article->cover_path ?: asset('site-assets/portfolio/ptliving.jpg') }}" alt="{{ $article->title }}">
            </aside>
        </div>
    </div>
</section>
@endsection
