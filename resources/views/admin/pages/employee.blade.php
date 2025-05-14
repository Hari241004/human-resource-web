@extends('layouts.master')

@section('title','Data Pegawai')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
      <a href="{{ route('admin.recruitment.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pegawai
      </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Photo</th>
              <th>Name</th>
              <th>NIK</th>
              <th>Email</th>
              <th>Position</th>
              <th>Title</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach($employees as $employee)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  @if($employee->photo)
                    <div style="width:90px; height:120px; overflow:hidden; border-radius:4px;">
                      <img src="{{ asset('storage/' . $employee->photo) }}"
                           alt="Foto {{ $employee->name }}"
                           style="width:100%; height:100%; object-fit:cover;">
                    </div>
                  @else
                    &mdash;
                  @endif
                </td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->nik }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->title ?? '—' }}</td>
                <td>
                  <a href="{{ route('admin.employees.show', $employee) }}"
                     class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.employees.edit', $employee) }}"
                     class="btn btn-warning btn-sm">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <form action="{{ route('admin.employees.destroy', $employee) }}"
                        method="POST"
                        class="d-inline delete-form">
                    @csrf @method('DELETE')
                    <button type="button"
                            class="btn btn-danger btn-sm btn-delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  {{-- SweetAlert2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', function() {
        Swal.fire({
          title: 'Yakin ingin menghapus?',
          text: 'Data pegawai akan dihapus permanen.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            this.closest('form.delete-form').submit();
          }
        });
      });
    });
  </script>
@endpush
