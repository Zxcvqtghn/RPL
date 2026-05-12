@extends('layouts.app')
@section('title', 'Staff - MeSketch')
@section('content')
<div class="page-head"><div><p class="kicker">Tim</p><h2>Kelola staff</h2></div><a class="button" href="{{ route('admin.staff.create') }}">Tambah staff</a></div>
<div class="table-wrap"><table><thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead><tbody>
@forelse($staff as $member)
<tr><td>{{ $member->name }}</td><td>{{ $member->email }}</td><td>{{ strtoupper($member->role) }}</td><td><div class="inline-actions"><a class="button ghost" href="{{ route('admin.staff.edit', $member) }}">Edit</a><form method="POST" action="{{ route('admin.staff.destroy', $member) }}">@csrf @method('DELETE')<button class="button ghost" type="submit">Hapus</button></form></div></td></tr>
@empty <tr><td colspan="4">Belum ada staff.</td></tr> @endforelse
</tbody></table></div>
@endsection
