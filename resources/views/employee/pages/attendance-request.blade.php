@extends('layouts.master')

@section('title', 'Attendance Request')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Form Pengajuan Presensi</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('employee.presensi.requests.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="date">Date</label>
      <input type="date"
             class="form-control @error('date') is-invalid @enderror"
             id="date" name="date"
             value="{{ old('date') }}"
             required>
      @error('date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="type">Type</label>
      <select class="form-control @error('type') is-invalid @enderror"
              id="type" name="type" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="check-in" {{ old('type')=='check-in' ? 'selected' : '' }}>Check In</option>
        <option value="check-out" {{ old('type')=='check-out' ? 'selected' : '' }}>Check Out</option>
      </select>
      @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="reason">Reason</label>
      <textarea class="form-control @error('reason') is-invalid @enderror"
                id="reason" name="reason"
                rows="3">{{ old('reason') }}</textarea>
      @error('reason')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="fas fa-paper-plane"></i> Submit Request
    </button>
  </form>
</div>
@endsection
