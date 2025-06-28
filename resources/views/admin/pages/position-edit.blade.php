{{-- resources/views/admin/pages/position-edit.blade.php --}}
@extends('layouts.master')

@section('title','Edit Position')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold">Edit Position</h6>
          <a href="{{ route('admin.positions.index', ['department_id'=>$position->department_id]) }}"
             class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Back
          </a>
        </div>
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger mb-3">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('admin.positions.update', $position) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
              <label>Department</label>
              <select name="department_id" class="form-control" required>
                @foreach($departments as $dept)
                  <option value="{{ $dept->id }}"
                    {{ old('department_id', $position->department_id)==$dept->id?'selected':'' }}>
                    {{ $dept->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Position Name</label>
              <input type="text" name="name" class="form-control"
                     value="{{ old('name', $position->name) }}" required>
            </div>
            <button type="submit" class="btn btn-warning">
              <i class="fas fa-save"></i> Update
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
