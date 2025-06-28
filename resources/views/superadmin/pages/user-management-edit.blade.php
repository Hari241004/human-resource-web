@extends('layouts.master')
@section('title','Edit Pengguna')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Edit Pengguna</h1>

  <form action="{{ route('superadmin.users.update',$user) }}" method="POST">
    @csrf @method('PUT')

    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required>
    </div>

    <div class="form-group">
      <label>Role</label>
      <select name="role" class="form-control" required>
        @foreach($roles as $value => $label)
          <option value="{{ $value }}" @selected(old('role',$user->role)===$value)>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
