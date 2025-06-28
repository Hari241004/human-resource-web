{{-- resources/views/employee/pages/overtime-request.blade.php --}}
@extends('layouts.master')

@section('title', 'Overtime Request')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Form Pengajuan Lembur</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('employee.overtime.requests.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="date">Date</label>
      <input
        type="date"
        name="date"
        id="date"
        class="form-control @error('date') is-invalid @enderror"
        value="{{ old('date', now()->toDateString()) }}"
        required
      >
      @error('date')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="start_time">Start Time</label>
      <input
        type="time"
        name="start_time"
        id="start_time"
        class="form-control @error('start_time') is-invalid @enderror"
        value="{{ old('start_time') }}"
        required
      >
      @error('start_time')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="end_time">End Time</label>
      <input
        type="time"
        name="end_time"
        id="end_time"
        class="form-control @error('end_time') is-invalid @enderror"
        value="{{ old('end_time') }}"
        required
      >
      @error('end_time')
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
      <i class="fas fa-paper-plane"></i> Submit Overtime Request
    </button>
  </form>
</div>
@endsection
