@extends('layouts.app')
@section('title', $testimonial->exists ? 'Edit Testimoni' : 'Testimoni Baru')
@section('content')
<div class="page-head"><div><p class="kicker">Reputasi</p><h2>{{ $testimonial->exists ? 'Edit testimoni' : 'Tambah testimoni' }}</h2></div></div>
<section class="panel"><form class="stack" method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">@csrf @if($testimonial->exists) @method('PUT') @endif
<div class="field"><label>Nama</label><input name="name" value="{{ old('name', $testimonial->name) }}" required></div>
<div class="field"><label>Label peran</label><input name="role_label" value="{{ old('role_label', $testimonial->role_label) }}"></div>
<div class="field"><label>Pesan</label><textarea name="message" required>{{ old('message', $testimonial->message) }}</textarea></div>
<div class="field"><label>Rating</label><select name="rating">@for($i=5;$i>=1;$i--)<option value="{{ $i }}" @selected(old('rating', $testimonial->rating ?: 5) == $i)>{{ $i }}</option>@endfor</select></div>
<label><input style="width:auto;" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->is_featured))> Tampilkan di landing page</label>
<button type="submit">Simpan testimoni</button></form></section>
@endsection
