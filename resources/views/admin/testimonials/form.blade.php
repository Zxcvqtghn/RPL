@extends('layouts.app')
@section('title', $testimonial->exists ? 'Edit Testimoni' : 'Testimoni Baru')
@section('content')
<div class="mb-8">
    <p class="mb-3 font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">Reputasi</p>
    <h2 class="font-display text-3xl font-extrabold text-navy sm:text-4xl">{{ $testimonial->exists ? 'Edit testimoni' : 'Tambah testimoni' }}</h2>
</div>
<section class="max-w-4xl rounded-3xl border border-slate-200 bg-white p-5 shadow-soft sm:p-8">
    <form class="grid gap-5" method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">
        @csrf @if($testimonial->exists) @method('PUT') @endif
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Nama</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="name" value="{{ old('name', $testimonial->name) }}" required></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Label peran</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="role_label" value="{{ old('role_label', $testimonial->role_label) }}"></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Pesan</label><textarea class="min-h-48 rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="message" required>{{ old('message', $testimonial->message) }}</textarea></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Rating</label><select class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="rating">@for($i=5;$i>=1;$i--)<option value="{{ $i }}" @selected(old('rating', $testimonial->rating ?: 5) == $i)>{{ $i }}</option>@endfor</select></div>
        <label class="inline-flex w-fit items-center gap-3 font-semibold text-ink-soft"><input class="h-4 w-4 rounded border-slate-300 accent-accent" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->is_featured))> Tampilkan di landing page</label>
        <button class="inline-flex min-h-13 w-fit items-center justify-center rounded-2xl bg-accent px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong" type="submit">Simpan testimoni</button>
    </form>
</section>
@endsection
