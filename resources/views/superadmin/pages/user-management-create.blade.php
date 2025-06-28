@extends('layouts.master')
@section('title','Tambah Pengguna')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Tambah Pengguna</h1>

  <form action="{{ route('superadmin.users.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Role</label>
      <select name="role" class="form-control" required>
        @foreach($roles as $value => $label)
          <option value="{{ $value }}" @selected(old('role')===$value)>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
