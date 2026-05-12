@extends('layouts.site')
@section('title', 'MeSketch - Konsultan Desain Interior Premium')
@section('content')
<section class="hero">
    <div class="shell hero-copy">
        <p class="eyebrow">Elevating Modern Living</p>
        <h1>Desain Interior Berkelas & Terukur</h1>
        <p class="lead">Wujudkan hunian impian dengan konsep yang matang, alur konsultasi transparan, dan eksekusi profesional dari tim ahli MeSketch.</p>
        <div class="inline-actions">
            <a class="button" href="{{ route('register') }}">Mulai Konsultasi</a>
            <a class="button secondary" href="#artikel">Lihat Wawasan</a>
        </div>
        <div class="stat-strip">
            <div><strong>150+</strong><br><span>Proyek Selesai</span></div>
            <div><strong>100%</strong><br><span>Kepuasan Klien</span></div>
            <div><strong>24/7</strong><br><span>Dukungan Tim</span></div>
        </div>
    </div>
</section>

<section id="layanan" class="shell section">
    <div class="section-head">
        <p class="kicker">Layanan Kami</p>
        <h2>Pengalaman Desain yang Lebih Profesional</h2>
        <p class="muted">Kami menggabungkan estetika dengan manajemen proyek yang modern untuk memastikan setiap detail ruang Anda terencana dengan sempurna.</p>
    </div>
    <div class="grid-3">
        <article class="panel">
            <div style="font-size: 2.5rem; margin-bottom: 24px;">🛋️</div>
            <h3>Konsultasi Ruang</h3>
            <p class="muted">Brief klien lebih jelas lewat sistem booking terstruktur dan histori permintaan yang terdokumentasi rapi di dashboard Anda.</p>
        </article>
        <article class="panel">
            <div style="font-size: 2.5rem; margin-bottom: 24px;">🎨</div>
            <h3>Editorial Desain</h3>
            <p class="muted">Dapatkan inspirasi dari artikel edukatif yang dikurasi langsung oleh desainer interior kami untuk memperkaya wawasan Anda.</p>
        </article>
        <article class="panel">
            <div style="font-size: 2.5rem; margin-bottom: 24px;">🛠️</div>
            <h3>Manajemen Proyek</h3>
            <p class="muted">Pantau progress pengerjaan desain Anda secara real-time melalui dashboard eksklusif untuk klien MeSketch.</p>
        </article>
    </div>
</section>

<section id="artikel" class="shell section" style="background: var(--panel); border-radius: var(--radius-lg); margin-bottom: 120px; box-shadow: var(--shadow-sm);">
    <div class="shell">
        <div class="section-head">
            <p class="kicker">Artikel & Wawasan</p>
            <h2>Inspirasi untuk Proyek Rumah Anda</h2>
        </div>
        <div class="grid-3">
            @forelse($articles as $article)
                <article class="card">
                    <img class="card-media" src="{{ $article->cover_path ?: asset('site-assets/hero-interior.png') }}" alt="{{ $article->title }}">
                    <div class="card-body">
                        <p class="meta">{{ $article->author->name }} · {{ optional($article->published_at)->format('d M Y') }}</p>
                        <h3>{{ $article->title }}</h3>
                        <p class="muted">{{ Str::limit($article->excerpt, 100) }}</p>
                        <a class="button ghost" href="{{ route('articles.show', $article) }}" style="margin-top: 24px; width: 100%;">Baca Selengkapnya</a>
                    </div>
                </article>
            @empty
                <p class="muted">Belum ada artikel terbaru.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="testimoni" class="shell section">
    <div class="section-head">
        <p class="kicker">Testimoni</p>
        <h2>Alasan Klien Kembali Percaya</h2>
    </div>
    <div class="grid-3">
        @forelse($testimonials as $testimonial)
            <article class="panel quote">
                <div>
                    <div class="stars">
                        @for($i = 0; $i < 5; $i++)
                            <span style="color: {{ $i < $testimonial->rating ? 'var(--accent)' : 'var(--line)' }}">★</span>
                        @endfor
                    </div>
                    <p>"{{ $testimonial->message }}"</p>
                </div>
                <div class="quote-author">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--accent);">
                        {{ substr($testimonial->name, 0, 1) }}
                    </div>
                    <div class="author-info">
                        <strong>{{ $testimonial->name }}</strong>
                        <span>{{ $testimonial->role_label }}</span>
                    </div>
                </div>
            </article>
        @empty
            <p class="muted">Belum ada testimoni klien.</p>
        @endforelse
    </div>
</section>
@endsection
