{{-- resources/views/admin/pages/employee.blade.php --}}

@extends('layouts.master')

@section('title','Data Pegawai')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
      <a href="{{ route('admin.recruitment.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pegawai
      </a>
    </div>
    <div class="card-body">

      {{-- Search Form --}}
      <form method="GET" class="form-inline mb-3">
        <div class="input-group">
          <input type="text" name="search"
                 class="form-control"
                 placeholder="Cari nama, NIK, atau email..."
                 value="{{ $search ?? '' }}">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-sm" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Photo</th>
              <th>Name</th>
              <th>NIK</th>
              <th>Email</th>
              <th>Phone</th>
              <th class="text-center">Position</th>
              <th>Title</th>
              <th>Department</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $employee)
              <tr>
                <td>{{ $employees->firstItem() + $loop->index }}</td>
                <td>
                  @if($employee->photo)
                    <div style="width:90px; height:120px; overflow:hidden; border-radius:4px;">
                      <img src="{{ asset('storage/'.$employee->photo) }}"
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
                <td>{{ $employee->phone ?? '—' }}</td>
                <td class="text-center">
                  {{ $employee->position ? $employee->position->name : '—' }}
                </td>
                <td>{{ $employee->title ?? '—' }}</td>
                <td>{{ $employee->department ? $employee->department->name : '—' }}</td>
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
                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center">Tidak ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-center">
        {{ $employees->links('pagination::bootstrap-4') }}
      </div>

    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.pagination .page-link {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
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
      }).then(result => {
        if (result.isConfirmed) {
          this.closest('form.delete-form').submit();
        }
      });
    });
  });
</script>
@endpush
