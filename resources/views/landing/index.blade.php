@extends('layouts.site')
@section('title', 'MeSketch - Konsultan Desain Interior Premium')
@section('content')
<section class="relative isolate min-h-screen overflow-hidden bg-navy px-4 pt-32 text-white sm:px-6 sm:pt-36 lg:px-8 lg:pt-40">
    <img class="absolute inset-0 -z-20 h-full w-full object-cover opacity-40" src="{{ asset('site-assets/hero-interior.png') }}" alt="">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-slate-950/95 via-slate-900/80 to-slate-900/30"></div>
    <div class="mx-auto flex min-h-[calc(100vh-8rem)] w-full max-w-7xl items-center py-14 lg:py-20">
        <div class="max-w-4xl">
            <p class="mb-6 font-display text-sm font-extrabold uppercase tracking-[0.22em] text-accent-soft">Elevating Modern Living</p>
            <h1 class="max-w-5xl font-display text-5xl font-extrabold leading-[1.05] text-white sm:text-6xl lg:text-8xl">Desain Interior Berkelas & Terukur</h1>
            <p class="mt-7 max-w-2xl text-lg leading-8 text-white/80 sm:text-xl">Wujudkan hunian impian dengan konsep yang matang, alur konsultasi transparan, dan eksekusi profesional dari tim ahli MeSketch.</p>
            <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                <a class="inline-flex min-h-14 items-center justify-center rounded-full bg-accent px-8 font-display font-bold text-white shadow-rich transition hover:-translate-y-0.5 hover:bg-accent-strong" href="{{ route('register') }}">Mulai Konsultasi</a>
                <a class="inline-flex min-h-14 items-center justify-center rounded-full border border-white/20 bg-white px-8 font-display font-bold text-ink transition hover:-translate-y-0.5 hover:bg-stone-100" href="#artikel">Lihat Wawasan</a>
            </div>
            <div class="mt-12 grid gap-5 border-t border-white/15 pt-8 sm:grid-cols-3 sm:gap-8">
                <div><strong class="block font-display text-3xl font-extrabold text-accent-soft">150+</strong><span class="mt-1 block text-sm font-bold uppercase tracking-[0.14em] text-white/65">Proyek Selesai</span></div>
                <div><strong class="block font-display text-3xl font-extrabold text-accent-soft">100%</strong><span class="mt-1 block text-sm font-bold uppercase tracking-[0.14em] text-white/65">Kepuasan Klien</span></div>
                <div><strong class="block font-display text-3xl font-extrabold text-accent-soft">24/7</strong><span class="mt-1 block text-sm font-bold uppercase tracking-[0.14em] text-white/65">Dukungan Tim</span></div>
            </div>
        </div>
    </div>
</section>

<section id="layanan" class="px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
    <div class="mx-auto w-full max-w-7xl">
        <div class="mb-12 max-w-3xl lg:mb-16">
            <p class="mb-4 font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">Layanan Kami</p>
            <h2 class="font-display text-4xl font-extrabold leading-tight text-navy sm:text-5xl">Pengalaman Desain yang Lebih Profesional</h2>
            <p class="mt-5 text-base leading-8 text-muted sm:text-lg">Kami menggabungkan estetika dengan manajemen proyek yang modern untuk memastikan setiap detail ruang Anda terencana dengan sempurna.</p>
        </div>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <article class="rounded-3xl border border-slate-200 bg-white p-7 shadow-soft transition hover:-translate-y-1 hover:shadow-rich sm:p-8">
                <div class="mb-6 text-4xl">🛋️</div>
                <h3 class="font-display text-2xl font-extrabold text-navy">Konsultasi Ruang</h3>
                <p class="mt-4 leading-7 text-muted">Brief klien lebih jelas lewat sistem booking terstruktur dan histori permintaan yang terdokumentasi rapi di dashboard Anda.</p>
            </article>
            <article class="rounded-3xl border border-slate-200 bg-white p-7 shadow-soft transition hover:-translate-y-1 hover:shadow-rich sm:p-8">
                <div class="mb-6 text-4xl">🎨</div>
                <h3 class="font-display text-2xl font-extrabold text-navy">Editorial Desain</h3>
                <p class="mt-4 leading-7 text-muted">Dapatkan inspirasi dari artikel edukatif yang dikurasi langsung oleh desainer interior kami untuk memperkaya wawasan Anda.</p>
            </article>
            <article class="rounded-3xl border border-slate-200 bg-white p-7 shadow-soft transition hover:-translate-y-1 hover:shadow-rich sm:p-8 md:col-span-2 xl:col-span-1">
                <div class="mb-6 text-4xl">🛠️</div>
                <h3 class="font-display text-2xl font-extrabold text-navy">Manajemen Proyek</h3>
                <p class="mt-4 leading-7 text-muted">Pantau progress pengerjaan desain Anda secara real-time melalui dashboard eksklusif untuk klien MeSketch.</p>
            </article>
        </div>
    </div>
</section>

<section id="artikel" class="px-4 pb-20 sm:px-6 lg:px-8 lg:pb-28">
    <div class="mx-auto w-full max-w-7xl rounded-[2rem] border border-slate-200 bg-white px-5 py-12 shadow-soft sm:px-8 lg:px-12 lg:py-16">
        <div class="mb-12 max-w-3xl">
            <p class="mb-4 font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">Artikel & Wawasan</p>
            <h2 class="font-display text-4xl font-extrabold leading-tight text-navy sm:text-5xl">Inspirasi untuk Proyek Rumah Anda</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($articles as $article)
                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft transition hover:-translate-y-1 hover:shadow-rich">
                    <img class="aspect-[16/11] w-full object-cover" src="{{ $article->cover_path ?: asset('site-assets/hero-interior.png') }}" alt="{{ $article->title }}">
                    <div class="p-6 sm:p-7">
                        <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-muted">{{ $article->author->name }} · {{ optional($article->published_at)->format('d M Y') }}</p>
                        <h3 class="mt-4 font-display text-2xl font-extrabold leading-tight text-navy">{{ $article->title }}</h3>
                        <p class="mt-4 leading-7 text-muted">{{ Str::limit($article->excerpt, 100) }}</p>
                        <a class="mt-6 inline-flex min-h-12 w-full items-center justify-center rounded-full border border-slate-200 px-5 font-display font-bold text-ink transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50" href="{{ route('articles.show', $article) }}">Baca Selengkapnya</a>
                    </div>
                </article>
            @empty
                <p class="text-muted">Belum ada artikel terbaru.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="testimoni" class="px-4 pb-20 sm:px-6 lg:px-8 lg:pb-28">
    <div class="mx-auto w-full max-w-7xl">
        <div class="mb-12 max-w-3xl">
            <p class="mb-4 font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">Testimoni</p>
            <h2 class="font-display text-4xl font-extrabold leading-tight text-navy sm:text-5xl">Alasan Klien Kembali Percaya</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($testimonials as $testimonial)
            <article class="flex min-h-[18rem] flex-col justify-between rounded-3xl border border-slate-200 bg-white p-7 shadow-soft sm:p-8">
                <div>
                    <div class="mb-5 text-xl font-extrabold text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <span class="{{ $i < $testimonial->rating ? 'text-amber-400' : 'text-slate-200' }}">★</span>
                        @endfor
                    </div>
                    <p class="text-lg italic leading-8 text-ink-soft">"{{ $testimonial->message }}"</p>
                </div>
                <div class="mt-8 flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-accent-soft font-display font-extrabold text-accent-strong">
                        {{ substr($testimonial->name, 0, 1) }}
                    </div>
                    <div>
                        <strong class="block font-display text-lg font-extrabold text-navy">{{ $testimonial->name }}</strong>
                        <span class="text-sm text-muted">{{ $testimonial->role_label }}</span>
                    </div>
                </div>
            </article>
            @empty
                <p class="text-muted">Belum ada testimoni klien.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
