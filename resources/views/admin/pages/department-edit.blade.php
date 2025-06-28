{{-- resources/views/admin/pages/department-edit.blade.php --}}
@extends('layouts.master')

@section('title','Edit Department')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold">Edit Department</h6>
          <a href="{{ route('admin.departments.index') }}" class="btn btn-light btn-sm">
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

          <form action="{{ route('admin.departments.update', $department) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
              <label>Name</label>
              <input type="text"
                     name="name"
                     class="form-control"
                     value="{{ old('name', $department->name) }}"
                     required>
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
