{{-- resources/views/admin/pages/position-show.blade.php --}}
@extends('layouts.master')

@section('title', 'Employees in Position')

@section('content')
<div class="container-fluid px-4 mt-4">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Position: {{ $position->name }}</h1>
    <a href="{{ route('admin.positions.index', ['department_id' => $position->department_id]) }}"
       class="btn btn-secondary btn-sm">
      <i class="fas fa-arrow-left"></i> Back to Positions
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Search --}}
  <form method="GET" class="form-inline mb-3">
    <div class="input-group">
      <input type="text" name="search"
             class="form-control"
             placeholder="Search name, email, or phone..."
             value="{{ $search ?? '' }}">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>

  <div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
      <h6 class="m-0 font-weight-bold">Employees in this Position</h6>
    </div>
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0" style="min-width:900px">
          <thead class="thead-light">
            <tr>
              <th style="width:5%">#</th>
              <th>Photo</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Title</th>
              <th>Department</th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $emp)
              <tr>
                <td>{{ $employees->firstItem() + $loop->index }}</td>
                <td>
                  @if($emp->photo)
                    <img src="{{ asset('storage/'.$emp->photo) }}"
                         class="rounded"
                         style="width:75px; height:100px; object-fit:cover;">
                  @else
                    &mdash;
                  @endif
                </td>
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ optional($emp->recruitment)->phone }}</td>
                <td>{{ $emp->title }}</td>
                <td>{{ $emp->department->name }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">No employees found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-center mt-3">
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
