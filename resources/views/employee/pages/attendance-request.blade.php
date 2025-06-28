{{-- resources/views/employee/pages/attendance-request.blade.php --}}
@extends('layouts.master')

@section('title','Pengajuan Presensi')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Form Pengajuan Presensi</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('employee.presensi.requests.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="date">Tanggal</label>
      <input type="date" id="date" name="date"
             class="form-control @error('date') is-invalid @enderror"
             value="{{ old('date') }}" required>
      @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="type">Tipe</label>
      <select id="type" name="type"
              class="form-control @error('type') is-invalid @enderror" required>
        <option value="">-- Pilih Tipe --</option>
        <option value="check-in"  {{ old('type')=='check-in' ? 'selected':'' }}>Check In</option>
        <option value="check-out" {{ old('type')=='check-out'? 'selected':'' }}>Check Out</option>
      </select>
      @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="reason">Alasan</label>
      <textarea id="reason" name="reason" rows="3"
                class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
      @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="fas fa-paper-plane"></i> Kirim Pengajuan
    </button>

    <a href="{{ route('employee.presensi.requests.index') }}"
       class="btn btn-secondary ml-2">
      <i class="fas fa-history"></i> Riwayat Pengajuan
    </a>
  </form>
</div>
@endsection
