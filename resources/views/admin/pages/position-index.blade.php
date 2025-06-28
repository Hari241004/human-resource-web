{{-- resources/views/admin/pages/position-index.blade.php --}}
@extends('layouts.master')

@section('title','Positions')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- Card -->
  <div class="card shadow mb-4">
    <!-- Card Header -->
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Positions</h6>
      <button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#addPos">
        <i class="fas fa-plus"></i> Add Position
      </button>
    </div>

    <!-- Card Body -->
    <div class="card-body">
      <!-- Add Form -->
      <div class="collapse mb-4" id="addPos">
        <form action="{{ route('admin.positions.store') }}" method="POST" class="form-inline">
          @csrf
          <div class="form-group mr-2 mb-2">
            <select name="department_id" class="form-control" required>
              <option value="">-- Department --</option>
              @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id')==$dept->id?'selected':'' }}>
                  {{ $dept->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group mr-2 mb-2">
            <input type="text" name="name" class="form-control" placeholder="Position Name" required>
          </div>
          <button type="submit" class="btn btn-primary mb-2">Save</button>
        </form>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Department</th>
              <th>Employees</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($positions as $pos)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pos->name }}</td>
                <td>{{ $pos->department->name }}</td>
                <td><span class="badge badge-info">{{ $pos->employees_count }}</span></td>
                <td>
                  <a href="{{ route('admin.positions.show', $pos) }}" class="btn btn-info btn-sm" title="Show Employees">
                    <i class="fas fa-users"></i>
                  </a>
                  <a href="{{ route('admin.positions.edit', $pos) }}" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.positions.destroy', $pos) }}"
                        method="POST" class="d-inline delete-form">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4">No positions found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
      Swal.fire({
        title: 'Confirm deletion',
        text: 'This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
      }).then(result => {
        if (result.isConfirmed) {
          this.closest('form.delete-form').submit();
        }
      });
    });
  });
</script>
@endpush
