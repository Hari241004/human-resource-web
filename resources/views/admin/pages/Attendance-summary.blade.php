{{-- resources/views/admin/pages/attendance-summary.blade.php --}}
@extends('layouts.master')

@section('title','Ringkasan Presensi')

@section('content')
<div class="container-fluid">

  {{-- Header with Search & Filters --}}
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
      <i class="fas fa-calendar-check"></i> Ringkasan Presensi Pegawai
    </h1>

    <form method="GET" class="form-inline">
      {{-- Search by Name --}}
      <div class="input-group mr-2">
        <input
          type="text"
          name="search"
          class="form-control form-control-sm"
          placeholder="Cari nama..."
          value="{{ $search ?? '' }}"
        >
        <div class="input-group-append">
          <button class="btn btn-outline-secondary btn-sm" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

      {{-- Month Picker --}}
      <select name="month" class="form-control form-control-sm mr-2">
        @foreach(range(1,12) as $m)
          <option value="{{ $m }}"
            {{ $month == $m ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
          </option>
        @endforeach
      </select>

      {{-- Year Picker --}}
      <select name="year" class="form-control form-control-sm mr-2">
        @for($y = now()->year - 5; $y <= now()->year; $y++)
          <option value="{{ $y }}"
            {{ $year == $y ? 'selected' : '' }}>
            {{ $y }}
          </option>
        @endfor
      </select>

      <button class="btn btn-primary btn-sm" type="submit">
        Tampilkan
      </button>
    </form>
  </div>

  {{-- Cards Grid --}}
  <div class="row">
    @forelse($summary as $item)
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow h-100 border-left-primary">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <i class="fas fa-user"></i>
              {{ $item['employee_name'] }}
            </h5>
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-check-circle text-success"></i> Hadir</span>
                <span class="badge badge-success">{{ $item['present'] }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock text-warning"></i> Terlambat</span>
                <span class="badge badge-warning">{{ $item['late'] }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-times-circle text-danger"></i> Tidak Hadir</span>
                <span class="badge badge-danger">{{ $item['absent'] }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-md text-info"></i> Izin/Cuti</span>
                <span class="badge badge-info">{{ $item['cuti'] }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock text-primary"></i> Lembur (jam)</span>
                <span class="badge badge-primary">{{ $item['overtime_hours'] }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center">
          <i class="fas fa-info-circle fa-2x mb-2"></i><br>
          Belum ada data ringkasan presensi untuk periode ini.
        </div>
      </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  <div class="d-flex justify-content-center">
    {{ $summary->withQueryString()->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection
