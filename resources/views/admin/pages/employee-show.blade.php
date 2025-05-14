{{-- resources/views/admin/pages/employee-show.blade.php --}}
@extends('layouts.master')

@section('title','Detail Data Pegawai')

@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header">
      <h6 class="m-0 font-weight-bold text-primary">Detail Data Pegawai</h6>
    </div>
    <div class="card-body">
      <div class="row">
        {{-- Foto Pegawai --}}
        <div class="col-md-4 d-flex justify-content-center align-items-center">
          <div style="width:150px; height:200px; border:1px solid #dee2e6; overflow:hidden; border-radius:4px;">
            @if($employee->photo)
              <img src="{{ asset('storage/' . $employee->photo) }}"
                   alt="Foto {{ $employee->name }}"
                   style="width:100%; height:100%; object-fit:cover;">
            @else
              <div class="d-flex justify-content-center align-items-center bg-light"
                   style="width:100%; height:100%;">
                &mdash;
              </div>
            @endif
          </div>
        </div>

        {{-- Detail Data --}}
        <div class="col-md-8" style="border-left:1px solid #dee2e6;">
          <div class="px-4">
            @php
              $info = [
                'Name'                 => $employee->name,
                'Title'                => $employee->title ?? '-',
                'Position'             => $employee->position,
                'Gender'               => $employee->gender,
                'TMT'                  => \Carbon\Carbon::parse($employee->recruitment->tmt)->format('d-m-Y'),
                'Contract End Date'    => \Carbon\Carbon::parse($employee->recruitment->contract_end_date)->format('d-m-Y'),
                'Place of Birth'       => $employee->recruitment->place_of_birth,
                'Date of Birth'        => \Carbon\Carbon::parse($employee->recruitment->date_of_birth)->format('d-m-Y'),
                'Religion'             => $employee->recruitment->religion,
                'Address'              => $employee->recruitment->address,
              ];
            @endphp

            @foreach($info as $label => $value)
              <div class="py-2" @if(!$loop->last) style="border-bottom:1px dashed #ced4da;" @endif>
                <strong>{{ $label }}:</strong> {{ $value }}
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>
  </div>
</div>
@endsection
