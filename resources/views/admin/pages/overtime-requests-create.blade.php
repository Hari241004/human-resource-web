@extends('layouts.master')

@section('title','Tambah Pengajuan Lembur')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-clock"></i> Tambah Pengajuan Lembur</h1>
    <a href="{{ route('admin.overtime-requests.index') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Lembur</h6>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.overtime-requests.store') }}" method="POST">
        @csrf

        <div class="form-row">

          <div class="form-group col-md-6">
            <label for="employee_id"><i class="fas fa-user"></i> Pegawai</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
              <option value="">-- Pilih Pegawai --</option>
              @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                  {{ $employee->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-md-6">
            <label for="date"><i class="fas fa-calendar-alt"></i> Tanggal</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label for="start_time"><i class="fas fa-clock"></i> Jam Mulai</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label for="end_time"><i class="fas fa-clock"></i> Jam Selesai</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
          </div>

          <div class="form-group col-md-12">
            <label for="reason"><i class="fas fa-align-left"></i> Alasan</label>
            <textarea name="reason" id="reason" class="form-control" rows="4" required>{{ old('reason') }}</textarea>
          </div>

        </div>

        <button type="submit" class="btn btn-success btn-block">
          <i class="fas fa-paper-plane"></i> Submit Pengajuan
        </button>

      </form>
    </div>
  </div>
</div>
@endsection
