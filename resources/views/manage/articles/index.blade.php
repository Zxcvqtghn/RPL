@extends('layouts.app')
@section('title', 'Kelola Artikel - MeSketch')
@section('content')
<h2 class="mb-8 font-display text-3xl font-extrabold text-navy sm:text-4xl">Kelola Konten Artikel</h2>
<section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
        <div><h3 class="font-display text-xl font-extrabold text-navy">Editorial Blog & Wawasan</h3><p class="mt-1 text-sm text-muted">Publikasikan artikel inspiratif untuk klien MeSketch Studio.</p></div>
        <a href="{{ route('manage.articles.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-2xl bg-accent px-5 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong">+ Buat Artikel Baru</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-[0.14em] text-muted"><tr><th class="px-5 py-4 sm:px-7">Judul Artikel</th><th class="px-5 py-4">Penulis</th><th class="px-5 py-4">Status / Tanggal</th><th class="px-5 py-4 text-right sm:px-7">Aksi</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($articles as $article)
                    <tr>
                        <td class="px-5 py-5 sm:px-7"><div class="max-w-md truncate font-bold text-navy">{{ $article->title }}</div><div class="mt-1 text-xs text-muted">Slug: {{ $article->slug }}</div></td>
                        <td class="px-5 py-5 font-semibold">{{ $article->author->name }}</td>
                        <td class="px-5 py-5">@if($article->published_at)<div class="font-semibold text-ink">{{ $article->published_at->format('d M Y') }}</div><div class="mt-1 text-xs text-muted">Terbit</div>@else<span class="inline-flex rounded-full bg-orange-100 px-3 py-1 text-xs font-extrabold uppercase text-orange-800">Draft</span>@endif</td>
                        <td class="px-5 py-5 sm:px-7"><div class="flex justify-end gap-2"><a href="{{ route('manage.articles.edit', $article) }}" class="inline-flex min-h-9 items-center justify-center rounded-xl border border-slate-200 px-3 text-xs font-bold transition hover:bg-slate-50">Edit</a><form action="{{ route('manage.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')<button type="submit" class="inline-flex min-h-9 items-center justify-center rounded-xl border border-rose-200 px-3 text-xs font-bold text-rose-700 transition hover:bg-rose-50">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-14 text-center text-muted">Belum ada artikel yang dibuat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
