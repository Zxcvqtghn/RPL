@extends('layouts.app')
@section('title', 'Testimoni - MeSketch')
@section('content')
<div class="page-head"><div><p class="kicker">Reputasi</p><h2>Kelola testimoni</h2></div><a class="button" href="{{ route('admin.testimonials.create') }}">Tambah testimoni</a></div>
<div class="table-wrap"><table><thead><tr><th>Nama</th><th>Rating</th><th>Featured</th><th>Aksi</th></tr></thead><tbody>
@forelse($testimonials as $testimonial)
<tr><td>{{ $testimonial->name }}</td><td>{{ $testimonial->rating }}/5</td><td>{{ $testimonial->is_featured ? 'Ya' : 'Tidak' }}</td><td><div class="inline-actions"><a class="button ghost" href="{{ route('admin.testimonials.edit', $testimonial) }}">Edit</a><form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}">@csrf @method('DELETE')<button class="button ghost" type="submit">Hapus</button></form></div></td></tr>
@empty <tr><td colspan="4">Belum ada testimoni.</td></tr> @endforelse
</tbody></table></div>
@endsection
