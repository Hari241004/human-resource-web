{{-- resources/views/employee/pages/attendance.blade.php --}}
@extends('layouts.master')

@section('title','Presensi Karyawan')

@section('content')
<div class="container-fluid">

  <h1 class="h3 mb-4 text-gray-800">Form & Riwayat Presensi</h1>

  {{-- Informasi Shift --}}
  @if(isset($shift))
    <div class="alert alert-info">
      <strong>Shift:</strong>
      {{ $shift->name }}
      ({{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }}
      &ndash;
      {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }})
    </div>
  @endif

  {{-- Notifikasi hari libur --}}
  @if($isHoliday)
    <div class="alert alert-warning">
      <strong>Perhatian!</strong>
      Hari ini ({{ \Carbon\Carbon::today()->isoFormat('D MMMM Y') }})
      adalah hari libur. Presensi ditutup.
    </div>
  @endif

  {{-- Notifikasi hasil simpan --}}
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- FORM PRESENSI --}}
  <div class="card mb-4">
    <div class="card-header">Isi Presensi</div>
    <div class="card-body">
      <form action="{{ route('employee.presensi.store') }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="date">Tanggal</label>
            <input type="date" id="date" name="date"
                   class="form-control @error('date') is-invalid @enderror"
                   value="{{ old('date', now()->toDateString()) }}"
                   {{ $isHoliday ? 'disabled' : '' }} required>
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="check_in_time">Check In</label>
            <input type="time" id="check_in_time" name="check_in_time"
                   class="form-control @error('check_in_time') is-invalid @enderror"
                   value="{{ old('check_in_time') }}"
                   {{ $isHoliday ? 'disabled' : '' }} required>
            @error('check_in_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="check_out_time">Check Out</label>
            <input type="time" id="check_out_time" name="check_out_time"
                   class="form-control @error('check_out_time') is-invalid @enderror"
                   value="{{ old('check_out_time') }}"
                   {{ $isHoliday ? 'disabled' : '' }}>
            @error('check_out_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="status">Status</label>
            <select id="status" name="status"
                    class="form-control @error('status') is-invalid @enderror"
                    {{ $isHoliday ? 'disabled' : '' }} required>
              <option value="present" {{ old('status')=='present'?'selected':'' }}>Present</option>
              <option value="late"    {{ old('status')=='late'   ?'selected':'' }}>Late</option>
              <option value="absent"  {{ old('status')=='absent' ?'selected':'' }}>Absent</option>
              <option value="excused" {{ old('status')=='excused'?'selected':'' }}>Excused</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-row mt-2">
          <div class="form-group col-md-4">
            <label for="photo">Selfie Photo</label>
            <input type="file" id="photo" name="photo"
                   class="form-control-file @error('photo') is-invalid @enderror"
                   {{ $isHoliday ? 'disabled' : '' }}>
            @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="check_in_location">Lokasi Check In</label>
            <input type="text" id="check_in_location" name="check_in_location"
                   class="form-control @error('check_in_location') is-invalid @enderror"
                   value="{{ old('check_in_location') }}"
                   {{ $isHoliday ? 'disabled' : '' }}>
            @error('check_in_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="notes">Catatan</label>
            <textarea id="notes" name="notes" rows="2"
                      class="form-control @error('notes') is-invalid @enderror"
                      {{ $isHoliday ? 'disabled' : '' }}>{{ old('notes') }}</textarea>
            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <button type="submit"
                class="btn btn-primary"
                {{ $isHoliday ? 'disabled' : '' }}>
          <i class="fas fa-paper-plane"></i>
          {{ $isHoliday ? 'Presensi Ditutup' : 'Submit Presensi' }}
        </button>
      </form>
    </div>
  </div>

  {{-- TABEL RIWAYAT PRESENSI --}}
  <div class="card">
    <div class="card-header">Riwayat Presensi</div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead class="thead-light">
          <tr>
            <th>Tanggal</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Status</th>
            <th>Catatan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($attendances as $a)
            <tr>
              <td>{{ $a->date }}</td>
              <td>{{ $a->check_in_time }}</td>
              <td>{{ $a->check_out_time ?? '-' }}</td>
              <td>{{ ucfirst($a->status) }}</td>
              <td>{{ $a->notes }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">Belum ada presensi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $attendances->links('pagination::bootstrap-4') }}
    </div>
  </div>

</div>
@endsection