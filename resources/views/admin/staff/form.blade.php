@extends('layouts.app')
@section('title', $member->exists ? 'Edit Staff' : 'Staff Baru')
@section('content')
<div class="page-head"><div><p class="kicker">Tim</p><h2>{{ $member->exists ? 'Edit staff' : 'Tambah staff' }}</h2></div></div>
<section class="panel"><form class="stack" method="POST" action="{{ $member->exists ? route('admin.staff.update', $member) : route('admin.staff.store') }}">@csrf @if($member->exists) @method('PUT') @endif
<div class="field"><label>Nama</label><input name="name" value="{{ old('name', $member->name) }}" required></div>
<div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email', $member->email) }}" required></div>
<div class="field"><label>Telepon</label><input name="phone" value="{{ old('phone', $member->phone) }}"></div>
<div class="field"><label>Role</label><select name="role"><option value="admin" @selected(old('role', $member->role) === 'admin')>Admin</option><option value="writer" @selected(old('role', $member->role) === 'writer')>Writer</option></select></div>
<div class="field"><label>Password</label><input type="password" name="password" {{ $member->exists ? '' : 'required' }}></div>
<div class="field"><label>Konfirmasi password</label><input type="password" name="password_confirmation" {{ $member->exists ? '' : 'required' }}></div>
<button type="submit">Simpan staff</button></form></section>
@endsection
