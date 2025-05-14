@extends('layouts.master')

@section('title','Presensi')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Form Presensi</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('employee.presensi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" name="date" id="date"
             class="form-control @error('date') is-invalid @enderror"
             value="{{ old('date', now()->toDateString()) }}" required>
      @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="check_in_time">Check In Time</label>
      <input type="time" name="check_in_time" id="check_in_time"
             class="form-control @error('check_in_time') is-invalid @enderror"
             value="{{ old('check_in_time') }}" required>
      @error('check_in_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="check_out_time">Check Out Time</label>
      <input type="time" name="check_out_time" id="check_out_time"
             class="form-control @error('check_out_time') is-invalid @enderror"
             value="{{ old('check_out_time') }}">
      @error('check_out_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="photo">Selfie Photo</label>
      <input type="file" name="photo" id="photo"
             class="form-control-file @error('photo') is-invalid @enderror">
      @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="check_in_location">Check In Location</label>
      <input type="text" name="check_in_location" id="check_in_location"
             class="form-control @error('check_in_location') is-invalid @enderror"
             value="{{ old('check_in_location') }}">
      @error('check_in_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="status">Status</label>
      <select name="status" id="status"
              class="form-control @error('status') is-invalid @enderror" required>
        <option value="present" {{ old('status')=='present' ? 'selected':'' }}>Present</option>
        <option value="late"    {{ old('status')=='late'    ? 'selected':'' }}>Late</option>
        <option value="absent"  {{ old('status')=='absent'  ? 'selected':'' }}>Absent</option>
        <option value="excused" {{ old('status')=='excused' ? 'selected':'' }}>Excused</option>
      </select>
      @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="notes">Notes</label>
      <textarea name="notes" id="notes" rows="3"
                class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
      @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="fas fa-paper-plane"></i> Submit
    </button>
  </form>
</div>
@endsection
