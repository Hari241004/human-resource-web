@extends('layouts.master')
@section('title','Manajemen Pengguna')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Manajemen Pengguna</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

  <div class="card">
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $idx => $u)
          <tr>
            <td>{{ $users->firstItem() + $idx }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ ucfirst($u->role) }}</td>
            <td>
              <a href="{{ route('superadmin.users.edit',$u) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('superadmin.users.destroy',$u) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
