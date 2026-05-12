@extends('layouts.app')
@section('title', $article->exists ? 'Edit Artikel' : 'Artikel Baru')
@section('content')
<div class="mb-8">
    <p class="mb-3 font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">Editorial</p>
    <h2 class="font-display text-3xl font-extrabold text-navy sm:text-4xl">{{ $article->exists ? 'Edit artikel' : 'Buat artikel baru' }}</h2>
</div>
<section class="max-w-4xl rounded-3xl border border-slate-200 bg-white p-5 shadow-soft sm:p-8">
    <form class="grid gap-5" method="POST" action="{{ $article->exists ? route('manage.articles.update', $article) : route('manage.articles.store') }}">
        @csrf
        @if($article->exists) @method('PUT') @endif
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Judul</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="title" value="{{ old('title', $article->title) }}" required></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Path cover</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="cover_path" value="{{ old('cover_path', $article->cover_path) }}" placeholder="/legacy-media/blog/..."></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Isi</label><textarea class="min-h-72 rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="body" required>{{ old('body', $article->body) }}</textarea></div>
        <button class="inline-flex min-h-13 w-fit items-center justify-center rounded-2xl bg-accent px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong" type="submit">Simpan artikel</button>
    </form>
</section>
@endsection
