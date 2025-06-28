{{-- resources/views/admin/pages/department-index.blade.php --}}
@extends('layouts.master')

@section('title','Data Departments')

@section('content')
<div class="container-fluid">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold">Departments</h6>
      <button class="btn btn-success btn-sm" data-toggle="collapse" data-target="#addDept">
        + Add Department
      </button>
    </div>
    <div class="card-body">
      <div class="collapse mb-4" id="addDept">
        <form action="{{ route('admin.departments.store') }}" method="POST" class="form-inline">
          @csrf
          <div class="form-group mr-2">
            <input type="text" name="name" class="form-control" placeholder="Department Name" required>
          </div>
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered" width="100%">
          <thead class="thead-light">
            <tr>
              <th style="width:5%">#</th>
              <th>Name</th>
              <th style="width:15%">Employees</th>
              <th style="width:30%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($departments as $dept)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dept->name }}</td>
                <td><span class="badge badge-info">{{ $dept->employees_count }}</span></td>
                <td>
                  <a href="{{ route('admin.positions.index', ['department_id' => $dept->id]) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-list"></i> Show Positions
                  </a>
                  <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="d-inline delete-form">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
      Swal.fire({
        title: 'Yakin hapus department ini?',
        text: 'Semua data terkait akan terhapus.',
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
