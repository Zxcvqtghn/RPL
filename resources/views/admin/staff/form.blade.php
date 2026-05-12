@extends('layouts.app')
@section('title', $member->exists ? 'Edit Staff' : 'Staff Baru')
@section('content')
<div class="mb-8">
    <p class="mb-3 font-display text-sm font-extrabold uppercase tracking-[0.18em] text-accent-strong">Tim</p>
    <h2 class="font-display text-3xl font-extrabold text-navy sm:text-4xl">{{ $member->exists ? 'Edit staff' : 'Tambah staff' }}</h2>
</div>
<section class="max-w-4xl rounded-3xl border border-slate-200 bg-white p-5 shadow-soft sm:p-8">
    <form class="grid gap-5 md:grid-cols-2" method="POST" action="{{ $member->exists ? route('admin.staff.update', $member) : route('admin.staff.store') }}">
        @csrf @if($member->exists) @method('PUT') @endif
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Nama</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="name" value="{{ old('name', $member->name) }}" required></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Email</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" type="email" name="email" value="{{ old('email', $member->email) }}" required></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Telepon</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="phone" value="{{ old('phone', $member->phone) }}"></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Role</label><select class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" name="role"><option value="admin" @selected(old('role', $member->role) === 'admin')>Admin</option><option value="writer" @selected(old('role', $member->role) === 'writer')>Writer</option></select></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Password</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" type="password" name="password" {{ $member->exists ? '' : 'required' }}></div>
        <div class="grid gap-2"><label class="text-sm font-bold text-ink-soft">Konfirmasi password</label><input class="min-h-13 rounded-2xl border border-slate-200 px-4 outline-none transition focus:border-accent focus:ring-4 focus:ring-accent/15" type="password" name="password_confirmation" {{ $member->exists ? '' : 'required' }}></div>
        <button class="inline-flex min-h-13 w-fit items-center justify-center rounded-2xl bg-accent px-6 font-display font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent-strong md:col-span-2" type="submit">Simpan staff</button>
    </form>
</section>
@endsection
