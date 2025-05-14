{{-- resources/views/employee/pages/leave-request.blade.php --}}
@extends('layouts.master')

@section('title', 'Leave Request')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Form Leave Request</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('employee.cuti.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="start_date">Start Date</label>
      <input
        type="date"
        name="start_date"
        id="start_date"
        class="form-control @error('start_date') is-invalid @enderror"
        value="{{ old('start_date') }}"
        required
      >
      @error('start_date')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="end_date">End Date</label>
      <input
        type="date"
        name="end_date"
        id="end_date"
        class="form-control @error('end_date') is-invalid @enderror"
        value="{{ old('end_date') }}"
        required
      >
      @error('end_date')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="type">Type</label>
      <select
        name="type"
        id="type"
        class="form-control @error('type') is-invalid @enderror"
        required
      >
        <option value="">-- Select Leave Type --</option>
        <option value="annual" {{ old('type')=='annual' ? 'selected':'' }}>Annual</option>
        <option value="sick"   {{ old('type')=='sick'   ? 'selected':'' }}>Sick</option>
        <option value="other"  {{ old('type')=='other'  ? 'selected':'' }}>Other</option>
      </select>
      @error('type')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="reason">Reason</label>
      <textarea
        name="reason"
        id="reason"
        rows="3"
        class="form-control @error('reason') is-invalid @enderror"
      >{{ old('reason') }}</textarea>
      @error('reason')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="fas fa-paper-plane"></i> Submit Leave Request
    </button>
  </form>
</div>
@endsection
